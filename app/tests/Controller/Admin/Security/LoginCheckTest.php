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
use App\Fixture\FixtureAttachedTrait;

class LoginCheckTest extends PantherTestCase
{
    use FixtureAttachedTrait;

    public function testDisplayLoginAdminPage()
    {
        $user = $this->fixtureRepository->getReference('user');
        dump($user);
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin-GC2NeDwu26y6pred');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
