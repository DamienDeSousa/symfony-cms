<?php

/**
 * File that defines the CreateBlockTypeControllerTest class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
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
 * This class is used to test the block type creation.
 */
class CreateBlockTypeControllerTest extends LoginPantherTestCase
{
    private const EXPECTED_GRID_LINES = 1;

    /**
     * @throws ReflectionException
     * @throws Exception
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
