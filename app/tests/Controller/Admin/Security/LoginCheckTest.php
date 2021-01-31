<?php

/**
 * File that defines the login check test class. This class test the access to the admin page.
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
