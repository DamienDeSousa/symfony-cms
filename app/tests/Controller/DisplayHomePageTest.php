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

class DisplayHomePageTest extends PantherTestCase
{
    public function testSomething()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
    }
}
