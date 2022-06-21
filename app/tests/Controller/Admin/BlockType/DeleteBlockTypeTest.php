<?php

/**
 * File that defines the DeleteBlockTypeTest class.
 *
 * @author Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\BlockType;

use Dades\CmsBundle\Entity\BlockType;
use Dades\EasyAdminExtensionBundle\Controller\Admin\BlockType\BlockTypeCRUDController;
use Dades\TestUtils\LoginPantherTestCase;
use Dades\TestUtils\Provider\AssertMessageProvider;
use Dades\TestUtils\Provider\Selector\Admin\UtilsAdminSelector;
use Exception;

/**
 * Class used to test the delete block type.
 */
class DeleteBlockTypeTest extends LoginPantherTestCase
{
    /**
     * @throws Exception
     */
    public function testDeleteBlockType()
    {
        /** @var BlockType $blockType */
        $blockType = $this->fixtureRepository->getReference('block_type');
        $crawler = $this->navigateToActionPage(
            $this->client,
            BlockTypeCRUDController::class,
            $blockType->getId(),
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
