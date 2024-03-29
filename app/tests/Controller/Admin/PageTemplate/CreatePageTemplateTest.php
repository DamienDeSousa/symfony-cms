<?php

/**
 * File that defines the CreatePageTemplateTest class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use Dades\CmsBundle\Entity\PageTemplate;
use Dades\EasyAdminExtensionBundle\Controller\Admin\PageTemplate\PageTemplateCRUDController;
use Dades\TestUtils\LoginPantherTestCase;
use Dades\TestUtils\Provider\AssertMessageProvider;
use Dades\TestUtils\Provider\Selector\Admin\UtilsAdminSelector;
use Exception;
use ReflectionException;

/**
 * This class is used to test the page template creation.
 */
class CreatePageTemplateTest extends LoginPantherTestCase
{
    private const EXPECTED_GRID_LINES = 1;

    /**
     * @throws ReflectionException
     * @throws Exception
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
