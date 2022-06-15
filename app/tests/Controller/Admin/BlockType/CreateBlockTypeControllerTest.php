<?php

/**
 * File that defines the CreateBlockTypeControllerTest class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
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
 * This class is used to test the block type creation.
 */
class CreateBlockTypeControllerTest extends LoginPantherTestCase
{
    private const EXPECTED_GRID_LINES = 1;

    /**
     * @throws ReflectionException
     */
    public function testCreateNewBlockType()
    {
        $crawler = $this->navigateToCreatePage($this->client, BlockTypeCRUDController::class);
        $updateForm = $crawler->filter(
            sprintf(
                UtilsAdminSelector::ENTITY_FORM_SELECTOR,
                UtilsAdminSelector::ENTITY_FORM_NEW,
                UtilsAdminSelector::getShortClassName(BlockType::class)
            )
        )->form([
            'BlockType[type]' => 'header',
            'BlockType[layout]' => 'path/to/header-layout.html.twig',
            'BlockType[formType]' => 'file-to-replace-by-real-form-types.php',
        ]);
        $crawler = $this->submitFormAndReturn($this->client);
        $dataGridLine = $crawler->filter(UtilsAdminSelector::DATAGRID_ROWS_SELECTOR)->count();

        $this->assertEquals(
            self::EXPECTED_GRID_LINES,
            $dataGridLine,
            sprintf(AssertMessageProvider::EXPECTED_ROWS_NUMBER_ERROR_MESSAGE, self::EXPECTED_GRID_LINES, $dataGridLine)
        );
    }
}
