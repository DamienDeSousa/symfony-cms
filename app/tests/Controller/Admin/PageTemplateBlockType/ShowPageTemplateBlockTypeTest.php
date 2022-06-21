<?php

/**
 * File that defines the UpdatePageTemplateBlockTypeTest test class.
 *
 * @author Damien DE SOUSA
 * @copyright 2022
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplateBlockType;

use Dades\CmsBundle\Entity\PageTemplateBlockType;
use Dades\EasyAdminExtensionBundle\Controller\Admin\PageTemplateBlockType\PageTemplateBlockTypeCRUDController;
use Dades\TestUtils\LoginPantherTestCase;
use Dades\TestUtils\Provider\AssertMessageProvider;
use Dades\TestUtils\Provider\Selector\Admin\UtilsAdminSelector;

/**
 * Tests the right behaviour of page template block type updating.
 */
class ShowPageTemplateBlockTypeTest extends LoginPantherTestCase
{
    public function testShowPageTemplateBlockTypePage()
    {
        /** @var PageTemplateBlockType $pageTemplateBlockType */
        $pageTemplateBlockType = $this->fixtureRepository->getReference('page_template_block_type');
        $crawler = $this->navigateLeftMenuLink($this->client, PageTemplateBlockTypeCRUDController::class);
        $node = UtilsAdminSelector::findRowInDatagrid($crawler, $pageTemplateBlockType->getId());

        $this->assertEquals(
            $pageTemplateBlockType->getId(),
            $node->attr(UtilsAdminSelector::DATA_ID_ATTR_TAG_SELECTOR),
            sprintf(
                AssertMessageProvider::EXPECTED_ROW_ENTITY_ID_ERROR_MESSAGE,
                $pageTemplateBlockType->getId(),
                $node->attr(UtilsAdminSelector::DATA_ID_ATTR_TAG_SELECTOR)
            )
        );
    }
}
