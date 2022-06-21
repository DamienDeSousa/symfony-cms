<?php

/**
 * File that defines the DeleteLinkedBlockTypeControllerTest class.
 *
 * @author Damien DE SOUSA
 * @copyright 2022
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
 * Class used to test the deletion to a linked block type.
 */
class DeleteLinkedBlockTypeControllerTest extends LoginPantherTestCase
{
    private const EXPECTED_ONE_ALERT_MESSAGE = 1;

    /**
     * @throws Exception
     */
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
