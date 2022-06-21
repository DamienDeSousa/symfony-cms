<?php

/**
 * File that defines the UpdateBlockTypeTest class.
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
use ReflectionException;

/**
 * Class used to test the update page template form.
 */
class UpdateBlockTypeTest extends LoginPantherTestCase
{
    private const EXPECTED_ROWS_COUNT = 1;

    /**
     * @throws ReflectionException
     *
     * @throws Exception
     */
    public function testUpdateBlockType()
    {
        /** @var BlockType $blockType */
        $blockType = $this->fixtureRepository->getReference('block_type');
        $crawler = $this->navigateToActionPage(
            $this->client,
            BlockTypeCRUDController::class,
            $blockType->getId(),
            UtilsAdminSelector::EDIT_BUTTON_REDIRECT_SELECTOR
        );
        $updateForm = $crawler->filter(
            sprintf(
                UtilsAdminSelector::ENTITY_FORM_SELECTOR,
                UtilsAdminSelector::ENTITY_FORM_EDIT,
                UtilsAdminSelector::getShortClassName(BlockType::class)
            )
        )->form([
            'BlockType[type]' => 'footer',
            'BlockType[layout]' => 'another/file/path/file.html.twig',
        ]);
        $crawler = $this->submitFormAndReturn($this->client);
        $datagridRow = UtilsAdminSelector::findRowInDatagrid($crawler, $blockType->getId())->count();

        $this->assertEquals(
            self::EXPECTED_ROWS_COUNT,
            $datagridRow,
            sprintf(AssertMessageProvider::EXPECTED_ROWS_NUMBER_ERROR_MESSAGE, self::EXPECTED_ROWS_COUNT, $datagridRow)
        );
    }
}
