<?php

/**
 * File that defines the Display Title test. This class is used to verify the title of each admin page.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\SmokeTest\MetaData;

use App\Entity\Site;
use App\Fixture\FixtureAttachedTrait;
use Symfony\Component\Panther\PantherTestCase;

class DisplayTitleTest extends PantherTestCase
{
    use FixtureAttachedTrait {
        setUp as setUpTrait;
    }

    protected function setUp(): void
    {
        $this->setUpTrait();
        /** @var User $user */
        $user = $this->fixtureRepository->getReference('user');

        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/admin-GC2NeDwu26y6pred');
        $loginForm = $crawler->selectButton('_submit')->form([
            '_username' => $user->getUsername(),
            '_password' => $user->getPassword()
        ]);
        $crawler = $client->submit($loginForm);
    }

    public function provideUrls()
    {
        return [
            ['/admin-GC2NeDwu26y6pred'],
            ['/admin/'],
            ['/admin/site/show'],
        ];
    }

    /**
     * @dataProvider provideUrls
     */
    public function testTitleOnAdminPages($url)
    {
        $client = static::createPantherClient();

        /** @var Site $site */
        $site = $this->fixtureRepository->getReference('site');

        $crawler = $client->request('GET', $url);

        $this->assertEquals($site->getTitle(), $client->getTitle());
    }

    protected function tearDown(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/admin/');
        $client->waitFor('#dropdownMenuButton');
        $client->executeScript("document.querySelector('#dropdownMenuButton').click()");

        $link = $crawler->filter('#logout')->attr('href');
        $crawler = $client->request('GET', $link);
    }
}
