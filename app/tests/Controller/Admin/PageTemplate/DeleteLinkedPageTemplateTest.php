<?php

/**
 * File that defines the DeleteLinkedPageTemplateTest class.
 *
 * @author Damien DE SOUSA
 * @copyright 2022
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use App\Controller\Admin\PageTemplate\PageTemplateCRUDController;
use App\Controller\Admin\PageTemplateBlockType\PageTemplateBlockTypeCRUDController;
use App\Entity\Structure\PageTemplate;
use App\Tests\LoginPantherTestCase;
use App\Tests\Provider\AssertMessageProvider;
use App\Tests\Provider\Selector\Admin\UtilsAdminSelector;

/**
 * This class is used to test the possibility to deleted a page template linked to a block type.
 */
class DeleteLinkedPageTemplateTest extends LoginPantherTestCase
{
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
