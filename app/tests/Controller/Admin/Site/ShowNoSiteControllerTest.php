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
use App\Controller\Admin\Site\SiteCRUDController;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Actions\NavigationAction;
use App\Tests\Provider\AssertMessageProvider;
use App\Tests\Provider\Selector\Admin\UtilsAdminSelector;
use App\Tests\Provider\Uri\AdminUriProvider;
use Symfony\Component\Panther\PantherTestCase;
use Symfony\Component\Panther\Client;

class ShowNoSiteControllerTest extends PantherTestCase
{
    use FixtureAttachedTrait {
        setUp as setUpTrait;
    }

    use AdminUriProvider;

    use LogAction;

    use NavigationAction;

    public const EXPECTED_NO_RESULT_MESSAGE = 1;

    /** @var Client */
    private $client;

    protected function setUp(): void
    {
        $this->initUserConnection();
    }

    public function testDisplayNoSitePage()
    {
        $crawler = $this->navigateLeftMenuLink($this->client, SiteCRUDController::class);
        $emptyResult = $crawler->filter(UtilsAdminSelector::NO_DATAGRID_RESULT_SELECTOR)->count();

        $this->assertEquals(
            self::EXPECTED_NO_RESULT_MESSAGE,
            $emptyResult,
            AssertMessageProvider::EXPECTED_NO_RESULT_ERROR_MESSAGE
        );
    }

    protected function tearDown(): void
    {
        $this->adminLogout($this->client, $this->client->getCrawler());
    }
}
