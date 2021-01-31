<?php

/**
 * File that defines the login check test class. This class test the access to the admin page.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Test\Controller\Admin\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginCheckTest extends WebTestCase
{
    public function testDisplayLoginAdminPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin-GC2NeDwu26y6pred');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
