<?php

/**
 * File that defines the UpdatePageTemplateBlockTypeTest test class.
 *
 * @author Damien DE SOUSA
 * @copyright 2022
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplateBlockType;

use Dades\CmsBundle\Entity\BlockType;
use Dades\CmsBundle\Entity\PageTemplate;
use Dades\CmsBundle\Entity\PageTemplateBlockType;
use Dades\EasyAdminExtensionBundle\Controller\Admin\PageTemplateBlockType\PageTemplateBlockTypeCRUDController;
use Dades\TestUtils\LoginPantherTestCase;
use Dades\TestUtils\Provider\AssertMessageProvider;
use Dades\TestUtils\Provider\Selector\Admin\UtilsAdminSelector;
use Exception;
use ReflectionException;

/**
 * Tests the right behaviour of page template block type updating.
 */
class UpdatePageTemplateBlockTypeTest extends LoginPantherTestCase
{
    private const EXPECTED_ROWS_COUNT = 1;

    private const EXPECTED_ALERT_MESSAGE_COUNT = 1;

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function testUpdatePageTemplateBlockTypeSuccessfully()
    {
        $newPageTemplate = $this->fixtureRepository->getReference('new_page_template');
        $newBlockType = $this->fixtureRepository->getReference('new_block_type');
        /** @var PageTemplateBlockType $newPageTemplateBlockType */
        $newPageTemplateBlockType = $this->fixtureRepository->getReference('new_page_template_block_type');

        $crawler = $this->navigateToActionPage(
            $this->client,
            PageTemplateBlockTypeCRUDController::class,
            $newPageTemplateBlockType->getId(),
            UtilsAdminSelector::EDIT_BUTTON_REDIRECT_SELECTOR
        );
        $crawler->filter(
            sprintf(
                UtilsAdminSelector::ENTITY_FORM_SELECTOR,
                UtilsAdminSelector::ENTITY_FORM_EDIT,
                UtilsAdminSelector::getShortClassName(PageTemplateBlockType::class)
            )
        )->form([
            'PageTemplateBlockType[slug]' => 'header',
            'PageTemplateBlockType[pageTemplate]' => $newPageTemplate->getId(),
            'PageTemplateBlockType[blockType]' => $newBlockType->getId(),
        ]);
        $crawler = $this->submitFormAndReturn($this->client);
        $datagridRow = UtilsAdminSelector::findRowInDatagrid($crawler, $newPageTemplateBlockType->getId())->count();

        $this->assertEquals(
            self::EXPECTED_ROWS_COUNT,
            $datagridRow,
            sprintf(AssertMessageProvider::EXPECTED_ROWS_NUMBER_ERROR_MESSAGE, self::EXPECTED_ROWS_COUNT, $datagridRow)
        );
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function testUpdatePageTemplateBlockTypeWithEmptySlug()
    {
        /** @var PageTemplate $pageTemplate */
        $pageTemplate = $this->fixtureRepository->getReference('page_template');
        /** @var BlockType $blockType */
        $blockType = $this->fixtureRepository->getReference('block_type');
        /** @var PageTemplateBlockType $pageTemplateBlockType */
        $pageTemplateBlockType = $this->fixtureRepository->getReference('page_template_block_type');
        /** @var PageTemplateBlockType $pageTemplateBlockType */
        $pageTemplateBlockType = $this->fixtureRepository->getReference('new_page_template_block_type');

        $crawler = $this->navigateToActionPage(
            $this->client,
            PageTemplateBlockTypeCRUDController::class,
            $pageTemplateBlockType->getId(),
            UtilsAdminSelector::EDIT_BUTTON_REDIRECT_SELECTOR
        );
        $crawler->filter(
            sprintf(
                UtilsAdminSelector::ENTITY_FORM_SELECTOR,
                UtilsAdminSelector::ENTITY_FORM_EDIT,
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

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function testUpdatePageTemplateBlockTypeWithAlreadyExistingSlugForPageTemplateAndBlockType()
    {
        /** @var PageTemplate $pageTemplate */
        $pageTemplate = $this->fixtureRepository->getReference('page_template');
        /** @var BlockType $blockType */
        $blockType = $this->fixtureRepository->getReference('block_type');
        /** @var PageTemplateBlockType $pageTemplateBlockType */
        $pageTemplateBlockType = $this->fixtureRepository->getReference('page_template_block_type');
        /** @var PageTemplateBlockType $newPageTemplateBlockType */
        $newPageTemplateBlockType = $this->fixtureRepository->getReference('new_page_template_block_type');
        $crawler = $this->navigateToActionPage(
            $this->client,
            PageTemplateBlockTypeCRUDController::class,
            $newPageTemplateBlockType->getId(),
            UtilsAdminSelector::EDIT_BUTTON_REDIRECT_SELECTOR
        );
        $crawler->filter(
            sprintf(
                UtilsAdminSelector::ENTITY_FORM_SELECTOR,
                UtilsAdminSelector::ENTITY_FORM_EDIT,
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
