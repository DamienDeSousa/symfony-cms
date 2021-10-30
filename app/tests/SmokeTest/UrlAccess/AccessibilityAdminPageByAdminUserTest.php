<?php

/**
 * File that defines the AccessibilityAdminPageByAdminUser class.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\SmokeTest\UrlAccess;

use App\Entity\User;
use App\Fixture\FixtureAttachedTrait;
use Symfony\Component\Panther\Client;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Uri\AdminUriProvider;
use App\Tests\Provider\Url\AdminUrlProvider;
use Symfony\Component\Panther\PantherTestCase;

/**
 * This class is used to test accessibility to pages by admin user.
 */
class AccessibilityAdminPageByAdminUserTest extends PantherTestCase
{
    use FixtureAttachedTrait {
        setUp as setUpTrait;
    }

    use LogAction;

    use AdminUriProvider;

    use AdminUrlProvider;

    /** @var Client */
    private $client;

    protected function setUp(): void
    {
        $this->setUpTrait();
        /** @var User $user */
        $user = $this->fixtureRepository->getReference('user');
        $this->client = static::createPantherClient([], [], ['request_timeout_in_ms' => 20000000]);
        $this->login($user, $this->provideAdminLoginUri(), $this->client);
    }

    public function provideAccessibleUrls()
    {
        return [
            [$this->provideAdminHomePageUri()],
            [$this->provideAdminSiteShowUri()],
            [$this->provideAdminSiteUpdateUri()],
            [$this->provideAdminPageTemplateGridUri()],
        ];
    }

    /**
     * @dataProvider provideAccessibleUrls
     */
    public function testPageIsAccessible($url)
    {
        $crawler = $this->client->request('GET', $url);
        $isSideBarPresent = $crawler->filter('#sidebar-wrapper')->count();

        $this->assertEquals(1, $isSideBarPresent, 'Expected to get ' . $url . ', get error page');
    }

    public function provideUnaccessibleUrls()
    {
        return [
            [$this->provideAdminPageTemplateCreateUri()],
            [$this->provideAdminPageBlockTypeCreateUri()],
        ];
    }

    /**
     * @dataProvider provideUnaccessibleUrls
     */
    public function testPageIsUnaccessible($url)
    {
        $crawler = $this->client->request('GET', $url);
        $isSideBarPresent = $crawler->filter('#sidebar-wrapper')->count();

        $this->assertEquals(0, $isSideBarPresent, 'Expected to get 403 page, get ' . $url . ' page');
    }

    protected function tearDown(): void
    {
        $crawler = $this->client->request('GET', $this->provideAdminHomePageUri());
        $crawler = $this->adminLogout($this->client, $crawler);
    }
}
