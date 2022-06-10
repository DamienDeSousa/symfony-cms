<?php

/**
 * File that defines the CreatePageTemplateBlockTypeTest test class.
 *
 * @author Damien DE SOUSA
 * @copyright 2022
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplateBlockType;

use App\Controller\Admin\PageTemplateBlockType\PageTemplateBlockTypeCRUDController;
use App\Entity\Structure\BlockType;
use App\Tests\LoginPantherTestCase;
use App\Entity\Structure\PageTemplate;
use App\Entity\Structure\PageTemplateBlockType;
use App\Tests\Provider\AssertMessageProvider;
use App\Tests\Provider\Selector\Admin\UtilsAdminSelector;

/**
 * Test the right behaviour of page template block type creation.
 */
class CreatePageTemplateBlockTypeTest extends LoginPantherTestCase
{
    private const EXPECTED_COUNT_ROWS_IN_DATAGRID = 2;

    private const EXPECTED_ALERT_MESSAGE_COUNT = 1;

    public function testCreatePageTemplateBlockTypeSuccessfully()
    {
        /** @var PageTemplate $pageTemplate */
        $pageTemplate = $this->fixtureRepository->getReference('page_template');
        /** @var BlockType $blockType */
        $blockType = $this->fixtureRepository->getReference('block_type');

        $crawler = $this->navigateToCreatePage($this->client, PageTemplateBlockTypeCRUDController::class);
        $crawler->filter(
            sprintf(
                UtilsAdminSelector::ENTITY_FORM_SELECTOR,
                UtilsAdminSelector::ENTITY_FORM_NEW,
                UtilsAdminSelector::getShortClassName(PageTemplateBlockType::class)
            )
        )->form([
            'PageTemplateBlockType[slug]' => 'my_little_slug',
            'PageTemplateBlockType[pageTemplate]' => $pageTemplate->getId(),
            'PageTemplateBlockType[blockType]' => $blockType->getId(),
        ]);
        $crawler = $this->submitFormAndReturn($this->client);

        $countDataGridRow = UtilsAdminSelector::countRowsInDataGrid($crawler);

        $this->assertEquals(
            self::EXPECTED_COUNT_ROWS_IN_DATAGRID,
            $countDataGridRow,
            sprintf(
                AssertMessageProvider::EXPECTED_ROWS_NUMBER_ERROR_MESSAGE,
                self::EXPECTED_COUNT_ROWS_IN_DATAGRID,
                $countDataGridRow
            )
        );
    }

    public function testCreatePageTemplateBlockTypeWithEmptySlug()
    {
        /** @var PageTemplate $pageTemplate */
        $pageTemplate = $this->fixtureRepository->getReference('page_template');
        /** @var BlockType $blockType */
        $blockType = $this->fixtureRepository->getReference('block_type');

        $crawler = $this->navigateToCreatePage($this->client, PageTemplateBlockTypeCRUDController::class);
        $crawler->filter(
            sprintf(
                UtilsAdminSelector::ENTITY_FORM_SELECTOR,
                UtilsAdminSelector::ENTITY_FORM_NEW,
                UtilsAdminSelector::getShortClassName(PageTemplateBlockType::class)
            )
        )->form([
            'PageTemplateBlockType[slug]' => '',
            'PageTemplateBlockType[pageTemplate]' => $pageTemplate->getId(),
            'PageTemplateBlockType[blockType]' => $blockType->getId(),
        ]);
        $expectedUrl = $this->client->getCurrentURL();
        $this->submitFormAndReturn($this->client);

        $this->assertEquals(
            $expectedUrl,
            $this->client->getCurrentURL(),
            sprintf(
                AssertMessageProvider::EXPECTED_ERROR_ON_PAGE_MESSAGE,
                $expectedUrl,
                $this->client->getCurrentURL()
            )
        );
    }

    public function testCreatePageTemplateBlockTypeWithAlreadyExistingSlugForPageTemplateAndBlockType()
    {
        /** @var PageTemplate $pageTemplate */
        $pageTemplate = $this->fixtureRepository->getReference('page_template');
        /** @var BlockType $blockType */
        $blockType = $this->fixtureRepository->getReference('block_type');
        /** @var PageTemplateBlockType $pageTemplateBlockType */
        $pageTemplateBlockType = $this->fixtureRepository->getReference('page_template_block_type');

        $crawler = $this->navigateToCreatePage($this->client, PageTemplateBlockTypeCRUDController::class);
        $crawler->filter(
            sprintf(
                UtilsAdminSelector::ENTITY_FORM_SELECTOR,
                UtilsAdminSelector::ENTITY_FORM_NEW,
                UtilsAdminSelector::getShortClassName(PageTemplateBlockType::class)
            )
        )->form([
            'PageTemplateBlockType[slug]' => $pageTemplateBlockType->getSlug(),
            'PageTemplateBlockType[pageTemplate]' => $pageTemplate->getId(),
            'PageTemplateBlockType[blockType]' => $blockType->getId(),
        ]);
        $crawler = $this->submitFormAndReturn($this->client);
        $countAlertMessage = $crawler->filter(UtilsAdminSelector::ALERT_FORM_MESSAGE_SELECTOR)->count();

        $this->assertEquals(
            self::EXPECTED_ALERT_MESSAGE_COUNT,
            $countAlertMessage,
            sprintf(
                AssertMessageProvider::EXPECTED_ALERT_MESSAGE_MESSAGE,
                self::EXPECTED_ALERT_MESSAGE_COUNT,
                $countAlertMessage
            )
        );
    }
}
