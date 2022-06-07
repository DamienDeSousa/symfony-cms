<?php

/**
 * File that defines the ShowBlockTypeTest class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\BlockType;

use App\Entity\Structure\BlockType;
use App\Tests\LoginPantherTestCase;
use App\Tests\Provider\AssertMessageProvider;
use App\Tests\Provider\Selector\Admin\UtilsAdminSelector;
use App\Controller\Admin\BlockType\BlockTypeCRUDController;

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
