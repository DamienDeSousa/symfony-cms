<?php

/**
 * Defines the CantUpdateBlockTypeTest class.
 *
 * @author Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\BlockType;

use App\Controller\Admin\BlockType\BlockTypeCRUDController;
use App\Entity\Structure\BlockType;
use App\Tests\LoginPantherTestCase;
use App\Tests\Provider\AssertMessageProvider;
use App\Tests\Provider\Selector\Admin\UtilsAdminSelector;
use ReflectionException;

/**
 * Tests the behaviour when wrong data are set.
 */
class CantUpdateBlockTypeTest extends LoginPantherTestCase
{
    private const EXPECTED_ALERT_MESSAGES = 2;

    /**
     * @throws ReflectionException
     */
    public function testUpdateBlockTypeWithAlreadyUsedTypeAndLayout()
    {
        /** @var BlockType $firstBlock */
        $firstBlock = $this->fixtureRepository->getReference('block_type_0');
        /** @var BlockType $secondBlock */
        $secondBlock = $this->fixtureRepository->getReference('block_type_1');
        $crawler = $this->navigateToActionPage(
            $this->client,
            BlockTypeCRUDController::class,
            $firstBlock->getId(),
            UtilsAdminSelector::EDIT_BUTTON_REDIRECT_SELECTOR
        );
        $updateForm = $crawler->filter(
            sprintf(
                UtilsAdminSelector::ENTITY_FORM_SELECTOR,
                UtilsAdminSelector::ENTITY_FORM_EDIT,
                UtilsAdminSelector::getShortClassName(BlockType::class)
            )
        )->form([
            'BlockType[type]' => $secondBlock->getType(),
            'BlockType[layout]' => $secondBlock->getLayout(),
        ]);
        $crawler = $this->submitFormAndReturn($this->client);
        $alertDangerNodes = $crawler->filter(UtilsAdminSelector::ALERT_FORM_MESSAGE_SELECTOR)->count();

        $this->assertEquals(
            self::EXPECTED_ALERT_MESSAGES,
            $alertDangerNodes,
            sprintf(
                AssertMessageProvider::EXPECTED_ERROR_ALERT_MESSAGE,
                self::EXPECTED_ALERT_MESSAGES,
                $alertDangerNodes
            )
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testUpdateWithEmptyValues()
    {
        /** @var BlockType $firstBlock */
        $firstBlock = $this->fixtureRepository->getReference('block_type_0');
        $crawler = $this->navigateToActionPage(
            $this->client,
            BlockTypeCRUDController::class,
            $firstBlock->getId(),
            UtilsAdminSelector::EDIT_BUTTON_REDIRECT_SELECTOR
        );
        $updateForm = $crawler->filter(
            sprintf(
                UtilsAdminSelector::ENTITY_FORM_SELECTOR,
                UtilsAdminSelector::ENTITY_FORM_EDIT,
                UtilsAdminSelector::getShortClassName(BlockType::class)
            )
        )->form([
            'BlockType[type]' => '',
            'BlockType[layout]' => '',
        ]);
        $expectedPage = $this->client->getCurrentURL();
        $crawler = $this->submitFormAndReturn($this->client);
        $actualPage = $this->client->getCurrentURL();

        $this->assertEquals(
            $expectedPage,
            $actualPage,
            sprintf(AssertMessageProvider::EXPECTED_ERROR_ON_PAGE_MESSAGE, $expectedPage, $actualPage)
        );
    }
}
