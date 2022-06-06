<?php

/**
 * File that defines the DeletePageTemplateTest class.
 *
 * @author Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use App\Controller\Admin\Index;
use App\Fixture\FixtureAttachedTrait;
use Symfony\Component\Panther\Client;
use App\Entity\Structure\PageTemplate;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Uri\AdminUriProvider;
use App\Tests\Provider\AssertMessageProvider;
use Symfony\Component\Panther\PantherTestCase;
use App\Tests\Provider\Actions\NavigationAction;
use App\Tests\Provider\Selector\Admin\UtilsAdminSelector;
use App\Tests\Controller\Admin\Site\ShowNoSiteControllerTest;

/**
 * Class used to test the delete page template.
 */
class DeletePageTemplateTest extends PantherTestCase
{
    use FixtureAttachedTrait {
        setUp as setUpTrait;
    }

    use LogAction;

    use AdminUriProvider;

    use NavigationAction;

    /** @var null|Client  */
    private $client = null;

    protected function setUp(): void
    {
        $this->initUserConnection();
    }


    public function testDeletePageTemplate()
    {
        /** @var PageTemplate $pageTemplate */
        $pageTemplate = $this->fixtureRepository->getReference('page_template');
        $crawler = $this->navigateToActionPage(
            $this->client,
            PageTemplate::class,
            $pageTemplate->getId(),
            UtilsAdminSelector::DELETE_BUTTON_MODAL_SELECTOR
        );
        $crawler = $this->clickElement($this->client, UtilsAdminSelector::DELETE_ENTITY_BUTTON_SELECTOR);
        $emptyResult = $crawler->filter(UtilsAdminSelector::NO_DATAGRID_RESULT_SELECTOR)->count();

        $this->assertEquals(
            AssertMessageProvider::COUNT_EXPECTED_NO_RESULT_MESSAGE,
            $emptyResult,
            AssertMessageProvider::EXPECTED_NO_RESULT_ERROR_MESSAGE
        );
    }

    protected function tearDown(): void
    {
        $this->adminLogout($this->client, $this->client->refreshCrawler());
    }
}
