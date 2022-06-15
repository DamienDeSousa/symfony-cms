<?php

/**
 * File that defines the CreatePageTemplateTest class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use App\Tests\LoginPantherTestCase;
use App\Entity\Structure\PageTemplate;
use App\Tests\Provider\AssertMessageProvider;
use App\Tests\Provider\Selector\Admin\UtilsAdminSelector;
use App\Controller\Admin\PageTemplate\PageTemplateCRUDController;
use ReflectionException;

/**
 * This class is used to test the page template creation.
 */
class CreatePageTemplateTest extends LoginPantherTestCase
{
    private const EXPECTED_GRID_LINES = 1;

    /**
     * @throws ReflectionException
     */
    public function testCreateNewPageTemplate()
    {
        $crawler = $this->navigateToCreatePage($this->client, PageTemplateCRUDController::class);
        $updateForm = $crawler->filter(
            sprintf(
                UtilsAdminSelector::ENTITY_FORM_SELECTOR,
                UtilsAdminSelector::ENTITY_FORM_NEW,
                UtilsAdminSelector::getShortClassName(PageTemplate::class)
            )
        )->form([
            'PageTemplate[name]' => 'Star Wars',
            'PageTemplate[layout]' => 'path/to/layout.html.twig',
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
