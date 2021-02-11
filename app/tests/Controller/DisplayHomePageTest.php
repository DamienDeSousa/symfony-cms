<?php

/**
 * File that defines the display home page test. This class test the access to the home page.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Component\Panther\PantherTestCase;
use App\Fixture\FixtureAttachedTrait;

class DisplayHomePageTest extends PantherTestCase
{
    use FixtureAttachedTrait;

    public function testSomething()
    {
        $user = $this->fixtureRepository->getReference('user');
        dump($user);
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
    }
}
