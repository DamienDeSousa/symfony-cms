<?php

/**
 * File that defines the Show no site controller test. This class is used to test the page when a site is not created.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\Site;

use App\Fixture\FixtureAttachedTrait;
use Symfony\Component\Panther\PantherTestCase;

class ShowNoSiteControllerTest extends PantherTestCase
{
    use FixtureAttachedTrait;

    public function testDisplayNoSitePage()
    {
        /** @var User $user */
        $user = $this->fixtureRepository->getReference('user');
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/admin-GC2NeDwu26y6pred');
        $loginForm = $crawler->selectButton('_submit')->form([
            '_username' => $user->getUsername(),
            '_password' => $user->getPassword()
        ]);
        $crawler = $client->submit($loginForm);
        $crawler = $client->request('GET', '/admin/site/show');

        $this->assertSelectorTextSame('.card-title', 'Le site n\'existe pas !');

        $client->waitFor('#dropdownMenuButton');
        $client->executeScript("document.querySelector('#dropdownMenuButton').click()");

        $link = $crawler->filter('#logout')->attr('href');
        $crawler = $client->request('GET', $link);
    }
}
