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
use App\Entity\User;
use App\Fixture\FixtureAttachedTrait;
use App\Tests\Provider\Uri\AdminUriProvider;
use App\Tests\Provider\Uri\UriProvider;
use App\Tests\Provider\Url\AdminUrlProvider;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Css\Admin\AdminCssProvider;

class LoginCheckTest extends PantherTestCase
{
    use FixtureAttachedTrait;

    use AdminUriProvider;

    use UriProvider;

    use AdminUrlProvider;

    use LogAction;

    use AdminCssProvider;

    public function testDisplayLoginAdminPage()
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', $this->provideAdminLoginUri());
        $usernameInput = $crawler->filter($this->provideUsernameLoginId())->count();
        $passwordInput = $crawler->filter($this->providePasswdLoginId())->count();

        $this->assertEquals(1, $usernameInput, 'Assert that user name input exists');
        $this->assertEquals(1, $passwordInput, 'Assert that password input exists');
    }

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
        $crawler = $this->login($user, $this->provideAdminLoginUri(), $client);

        $this->assertEquals(
            $this->provideAdminBaseUrl() . $this->provideAdminHomePageUri(),
            $crawler->getUri(),
            'Assert that authentification succeed and redirect to admin home page'
        );

        $crawler = $this->adminLogout($client, $crawler);

        $this->assertEquals(
            $this->provideAdminBaseUrl() . $this->provideHomePageUri(),
            $crawler->getUri(),
            'Assert that logout succeed and redirect to home page'
        );
    }

    public function testDisplayErrorMessageBadCredentials()
    {
        /** @var User $user */
        $user = $this->fixtureRepository->getReference('user');
        $client = static::createPantherClient();
        $crawler = $client->request('GET', $this->provideAdminLoginUri());
        $loginForm = $crawler->selectButton($this->provideSubmitLoginName())->form([
            $this->provideUsernameLoginName() => $user->getUsername(),
            $this->providePasswdLoginName() => 'wrong_password'
        ]);
        $crawler = $client->submit($loginForm);
        $errorMessage = $crawler->filter($this->provideErrorMsgClass())->count();

        $this->assertEquals(1, $errorMessage, 'Assert that login failed and bad credential message is present');
    }
}
