<?php

/**
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\Site;

use App\Entity\Site;
use App\Entity\User;
use App\Fixture\FixtureAttachedTrait;
use Symfony\Component\Panther\PantherTestCase;

class ShowSiteControllerTest extends PantherTestCase
{
    use FixtureAttachedTrait;

    public function testDisplaySitePage()
    {
        /** @var User $user */
        $user = $this->fixtureRepository->getReference('user');
        /** @var Site $site */
        $site = $this->fixtureRepository->getReference('site');

        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/admin-GC2NeDwu26y6pred');
        $loginForm = $crawler->selectButton('_submit')->form([
            '_username' => $user->getUsername(),
            '_password' => $user->getPassword()
        ]);
        $crawler = $client->submit($loginForm);
        $crawler = $client->request('GET', '/admin/site/show');

        $this->assertSelectorTextSame('.card-header', 'Informations');

        $client->waitFor('#dropdownMenuButton');
        $client->executeScript("document.querySelector('#dropdownMenuButton').click()");

        $link = $crawler->filter('#logout')->attr('href');
        $crawler = $client->request('GET', $link);
    }
}
