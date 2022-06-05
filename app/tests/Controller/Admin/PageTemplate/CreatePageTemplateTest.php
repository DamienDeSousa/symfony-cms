<?php

/**
 * File that defines the CreatePageTemplateTest class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use App\Fixture\FixtureAttachedTrait;
use Symfony\Component\Panther\Client;
use App\Entity\Structure\PageTemplate;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Uri\AdminUriProvider;
use Symfony\Component\Panther\PantherTestCase;
use App\Tests\Provider\Actions\NavigationAction;
use App\Tests\Provider\Selector\Admin\UtilsAdminSelector;
use App\Controller\Admin\PageTemplate\PageTemplateCRUDController;

/**
 * This class is used to test the page template creation.
 */
class CreatePageTemplateTest extends PantherTestCase
{
    use FixtureAttachedTrait {
        setUp as setUpTrait;
    }

    use LogAction;

    use AdminUriProvider;

    use NavigationAction;

    private const EXPECTED_GRID_LINES = 1;

    /** @var Client */
    private $client = null;

    protected function setUp(): void
    {
        $this->initUserConnection();
    }


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
            sprintf('Expected %s line, got %s', self::EXPECTED_GRID_LINES, $dataGridLine)
        );
    }

    protected function tearDown(): void
    {
        $this->adminLogout($this->client, $this->client->refreshCrawler());
    }
}
