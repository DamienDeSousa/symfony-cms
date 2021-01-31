<?php

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
