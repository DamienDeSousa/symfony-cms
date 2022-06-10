<?php

/**
 * File that defines the DeletePageTemplateBlockTypeTest test class.
 *
 * @author Damien DE SOUSA
 * @copyright 2022
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplateBlockType;

use App\Controller\Admin\PageTemplateBlockType\PageTemplateBlockTypeCRUDController;
use App\Entity\Structure\PageTemplateBlockType;
use App\Tests\LoginPantherTestCase;
use App\Tests\Provider\AssertMessageProvider;
use App\Tests\Provider\Selector\Admin\UtilsAdminSelector;

/**
 * Test the right behaviour of page template block type deletion.
 */
class DeletePageTemplateBlockTypeTest extends LoginPantherTestCase
{
    public function testDeletePageTemplateBlockTypeSuccessfully()
    {
        /** @var PageTemplateBlockType $pageTemplateBlockType */
        $pageTemplateBlockType = $this->fixtureRepository->getReference('page_template_block_type');
        $this->navigateToActionPage(
            $this->client,
            PageTemplateBlockTypeCRUDController::class,
            $pageTemplateBlockType->getId(),
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
}
