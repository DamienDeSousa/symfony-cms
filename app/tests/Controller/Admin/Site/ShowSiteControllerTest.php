<?php

/**
 * File that defines the show site controller test.
 * This class is used to the page when a site is created.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\Site;

use App\Controller\Admin\Site\SiteCRUDController;
use App\Entity\Site;
use App\Fixture\FixtureAttachedTrait;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Actions\NavigationAction;
use App\Tests\Provider\Selector\Admin\UtilsAdminSelector;
use App\Tests\Provider\Uri\AdminUriProvider;
use Symfony\Component\Panther\PantherTestCase;
use Symfony\Component\Panther\Client;

class ShowSiteControllerTest extends PantherTestCase
{
    use FixtureAttachedTrait {
        setUp as setUpTrait;
    }

    use AdminUriProvider;

    use LogAction;

    use NavigationAction;

    private const ERROR_MESSAGE = 'Expected row with entity id %d, got %s';

    /** @var Client */
    private $client;

    protected function setUp(): void
    {
        $this->initUserConnection();
    }

    public function testDisplaySitePage()
    {
        /** @var Site $site */
        $site = $this->fixtureRepository->getReference('site');
        $crawler = $this->navigateLeftMenuLink($this->client, SiteCRUDController::class);
        $node = UtilsAdminSelector::findRowInDatagrid($crawler, $site->getId());

        $this->assertEquals(
            $site->getId(),
            $node->attr('data-id'),
            sprintf(self::ERROR_MESSAGE, $site->getId(), $node->attr('data-id'))
        );
    }

    protected function tearDown(): void
    {
        $this->adminLogout($this->client, $this->client->getCrawler());
    }
}
