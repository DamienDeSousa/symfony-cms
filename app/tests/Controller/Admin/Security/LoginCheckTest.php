<?php

/**
 * File that defines the login check test class. This class test the access to the admin page.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\Security;

use App\Entity\User;
use App\Tests\FixturePantherTestCase;
use App\Tests\Provider\Actions\LogAction;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Exception\TimeoutException;

class LoginCheckTest extends FixturePantherTestCase
{
    use LogAction;

    protected function setUp(): void
    {
        $this->setUpTrait();
    }

    /**
     * @throws NoSuchElementException
     * @throws TimeoutException
     */
    public function testAuthentificationSucceed()
    {
        /** @var User $user */
        $user = $this->fixtureRepository->getReference('user');
        $client = static::createPantherClient();
        $crawler = $this->login($user, $this->provideAdminLoginUri(), $client);

        $this->assertEquals(
            $this->provideAdminBaseUrl() . $this->provideAdminHomePageUri(),
            $crawler->getUri() . '/',
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
        $loginForm = $crawler->selectButton('_submit')->form([
            '_username' => $user->getUsername(),
            '_password' => 'wrong_password'
        ]);
        $crawler = $client->submit($loginForm);
        $errorMessage = $crawler->filter('.text-danger')->count();

        $this->assertEquals(1, $errorMessage, 'Assert that login failed and bad credential message is present');
    }
}
