<?php

/**
 * File that defines the DeleteLinkedBlockTypeControllerTest class.
 *
 * @author Damien DE SOUSA
 * @copyright 2022
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\BlockType;

use App\Controller\Admin\BlockType\BlockTypeCRUDController;
use App\Entity\Structure\BlockType;
use App\Tests\LoginPantherTestCase;
use App\Tests\Provider\AssertMessageProvider;
use App\Tests\Provider\Selector\Admin\UtilsAdminSelector;

/**
 * Class used to test the deletion to a linked block type.
 */
class DeleteLinkedBlockTypeControllerTest extends LoginPantherTestCase
{
    private const EXPECTED_ONE_ALERT_MESSAGE = 1;
    public function testUnableToDeleteLinkedBlockType()
    {
        /** @var BlockType $linkedBlockType */
        $linkedBlockType = $this->fixtureRepository->getReference('linked_block_type');
        $crawler = $this->navigateToActionPage(
            $this->client,
            BlockTypeCRUDController::class,
            $linkedBlockType->getId(),
            UtilsAdminSelector::DELETE_BUTTON_MODAL_SELECTOR
        );

        $crawler = $this->clickElement($this->client, UtilsAdminSelector::DELETE_ENTITY_BUTTON_SELECTOR);
        $countDangerAlert = $crawler->filter(UtilsAdminSelector::DANGER_ALERT_SELECTOR)->count();

        $this->assertEquals(
            self::EXPECTED_ONE_ALERT_MESSAGE,
            $countDangerAlert,
            sprintf(
                AssertMessageProvider::EXPECTED_ALERT_MESSAGE_MESSAGE,
                self::EXPECTED_ONE_ALERT_MESSAGE,
                $countDangerAlert
            )
        );
    }
}
