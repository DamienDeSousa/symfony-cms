<?php

/**
 * File that defines the ShowPageTemplateTest class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use App\Fixture\FixtureAttachedTrait;
use App\Entity\Structure\PageTemplate;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Uri\AdminUriProvider;
use Symfony\Component\Panther\PantherTestCase;
use App\Tests\Provider\Actions\NavigationAction;
use App\Tests\Provider\Selector\Admin\UtilsAdminSelector;
use App\Tests\Controller\Admin\Site\ShowSiteControllerTest;
use App\Controller\Admin\PageTemplate\PageTemplateCRUDController;

/**
 * This class is used to test the page template data grid.
 */
class ShowPageTemplateTest extends PantherTestCase
{
    use FixtureAttachedTrait {
        setUp as setUpTrait;
    }

    use LogAction;

    use AdminUriProvider;

    use NavigationAction;

    /**
     * @var \Symfony\Component\Panther\Client
     */
    private $client = null;

    protected function setUp(): void
    {
        $this->initUserConnection();
    }

    public function testShowPageTemplatePage()
    {
        /** @var PageTemplate $pageTemplate */
        $pageTemplate = $this->fixtureRepository->getReference('page_template');
        $crawler = $this->navigateLeftMenuLink($this->client, PageTemplateCRUDController::class);
        $node = UtilsAdminSelector::findRowInDatagrid($crawler, $pageTemplate->getId());

        $this->assertEquals(
            $pageTemplate->getId(),
            $node->attr('data-id'),
            sprintf(ShowSiteControllerTest::ERROR_MESSAGE, $pageTemplate->getId(), $node->attr('data-id'))
        );
    }

    protected function tearDown(): void
    {
        $this->adminLogout($this->client, $this->client->refreshCrawler());
    }
}
