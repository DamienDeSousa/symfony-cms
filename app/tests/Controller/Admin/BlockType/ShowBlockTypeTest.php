<?php

/**
 * File that defines the ShowBlockTypeTest class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\BlockType;

use Dades\CmsBundle\Entity\BlockType;
use Dades\EasyAdminExtensionBundle\Controller\Admin\BlockType\BlockTypeCRUDController;
use Dades\TestUtils\LoginPantherTestCase;
use Dades\TestUtils\Provider\AssertMessageProvider;
use Dades\TestUtils\Provider\Selector\Admin\UtilsAdminSelector;

/**
 * This class is used to test the page template data grid.
 */
class ShowBlockTypeTest extends LoginPantherTestCase
{
    public function testShowBlockTypePage()
    {
        /** @var BlockType $blockType */
        $blockType = $this->fixtureRepository->getReference('block_type');
        $crawler = $this->navigateLeftMenuLink($this->client, BlockTypeCRUDController::class);
        $node = UtilsAdminSelector::findRowInDatagrid($crawler, $blockType->getId());

        $this->assertEquals(
            $blockType->getId(),
            $node->attr(UtilsAdminSelector::DATA_ID_ATTR_TAG_SELECTOR),
            sprintf(
                AssertMessageProvider::EXPECTED_ROW_ENTITY_ID_ERROR_MESSAGE,
                $blockType->getId(),
                $node->attr(UtilsAdminSelector::DATA_ID_ATTR_TAG_SELECTOR)
            )
        );
    }
}
