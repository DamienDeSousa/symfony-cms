<?php

/**
 * File that defines the DeleteLinkedPageTemplateTest class.
 *
 * @author Damien DE SOUSA
 * @copyright 2022
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use Dades\CmsBundle\Entity\PageTemplate;
use Dades\EasyAdminExtensionBundle\Controller\Admin\PageTemplate\PageTemplateCRUDController;
use Dades\EasyAdminExtensionBundle\Controller\Admin\PageTemplateBlockType\PageTemplateBlockTypeCRUDController;
use Dades\TestUtils\LoginPantherTestCase;
use Dades\TestUtils\Provider\AssertMessageProvider;
use Dades\TestUtils\Provider\Selector\Admin\UtilsAdminSelector;
use Exception;

/**
 * This class is used to test the possibility to deleted a page template linked to a block type.
 */
class DeleteLinkedPageTemplateTest extends LoginPantherTestCase
{
    /**
     * @throws Exception
     */
    public function testDeleteLinkedPageTemplate()
    {
        /** @var PageTemplate $pageTemplate */
        $pageTemplate = $this->fixtureRepository->getReference('page_template');
        $crawler = $this->navigateToActionPage(
            $this->client,
            PageTemplateCRUDController::class,
            $pageTemplate->getId(),
            UtilsAdminSelector::DELETE_BUTTON_MODAL_SELECTOR
        );
        $crawler = $this->clickElement($this->client, UtilsAdminSelector::DELETE_ENTITY_BUTTON_SELECTOR);
        $pageTemplateEmptyResult = $crawler->filter(UtilsAdminSelector::NO_DATAGRID_RESULT_SELECTOR)->count();

        $crawler = $this->navigateLeftMenuLink($this->client, PageTemplateBlockTypeCRUDController::class);
        $pageTemplateBlockTypeEmptyResult = $crawler->filter(UtilsAdminSelector::NO_DATAGRID_RESULT_SELECTOR)->count();

        $this->assertEquals(
            AssertMessageProvider::COUNT_EXPECTED_NO_RESULT_MESSAGE,
            $pageTemplateEmptyResult,
            AssertMessageProvider::EXPECTED_NO_RESULT_ERROR_MESSAGE
        );
        $this->assertEquals(
            AssertMessageProvider::COUNT_EXPECTED_NO_RESULT_MESSAGE,
            $pageTemplateBlockTypeEmptyResult,
            AssertMessageProvider::EXPECTED_NO_RESULT_ERROR_MESSAGE
        );
    }
}
