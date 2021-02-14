<?php

/**
 * File that defines the login check test class. This class test the access to the admin page.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\Security;

use Symfony\Component\Panther\PantherTestCase;
use App\Security\Admin\Login\Captcha;
use App\Entity\User;
use App\Fixture\FixtureAttachedTrait;

class LoginCheckTest extends PantherTestCase
{
    use FixtureAttachedTrait;

    /**
     * Put this test in first to avoid session problems with connections failure.
     * If you put this test after login tests failure, the captcha will be displayed on form.
     *
     * @return void
     */
    public function testAuthentificationSucceed()
    {
        /** @var User $user */
        $user = $this->fixtureRepository->getReference('user');
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/admin-GC2NeDwu26y6pred');
        $loginForm = $crawler->selectButton('_submit')->form([
            '_username' => $user->getUsername(),
            '_password' => $user->getPassword()
        ]);
        $chromeClient = $client->createChromeClient();
        $crawler = $client->submit($loginForm);

        $this->assertEquals(
            getenv('CUSTOM_PANTHER_BASE_URL') . '/admin/',
            $crawler->getUri(),
            'Assert that authentification succeed and redirect to admin home page'
        );
    }

    public function testDisplayLoginAdminPage()
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/admin-GC2NeDwu26y6pred');
        $usernameInput = $crawler->filter('#username')->count();
        $passwordInput = $crawler->filter('#password')->count();

        $this->assertEquals(1, $usernameInput, 'Assert that user name input exists');
        $this->assertEquals(1, $passwordInput, 'Assert that password input exists');
    }

    public function testDisplayErrorMessageBadCredentials()
    {
        /** @var User $user */
        $user = $this->fixtureRepository->getReference('user');
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/admin-GC2NeDwu26y6pred');
        $loginForm = $crawler->selectButton('_submit')->form([
            '_username' => $user->getUsername(),
            '_password' => 'wrong_password'
        ]);
        $crawler = $client->submit($loginForm);
        $errorMessage = $crawler->filter('.text-danger')->count();

        $this->assertEquals(1, $errorMessage, 'Assert that login failed and bad credential message is present');
    }

    public function testDisplayCaptchaOnThirdLoginFailed()
    {
        /** @var User $user */
        $user = $this->fixtureRepository->getReference('user');
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/admin-GC2NeDwu26y6pred');
        for ($i = 0; $i < Captcha::LIMIT_DISPLAY_CAPTCHA; $i++) {
            $loginForm = $crawler->selectButton('_submit')->form([
                '_username' => $user->getUsername(),
                '_password' => 'wrong_password'
            ]);
            $crawler = $client->submit($loginForm);
        }
        $captchaCodeInput = $crawler->filter('#captchaCode')->count();

        $this->assertEquals(1, $captchaCodeInput, 'Assert that the captcha input is display if the limit is reached');
    }
}
