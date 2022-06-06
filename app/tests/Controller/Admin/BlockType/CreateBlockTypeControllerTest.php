<?php

/**
 * File that defines the CreateBlockTypeControllerTest class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\BlockType;

use App\Entity\User;
use App\Entity\Structure\BlockType;
use App\Fixture\FixtureAttachedTrait;
use Symfony\Component\Panther\Client;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Uri\AdminUriProvider;
use Symfony\Component\Panther\PantherTestCase;
use App\Tests\Provider\Actions\NavigationAction;
use App\Tests\Provider\Selector\Admin\UtilsAdminSelector;

/**
 * This class is used to test the block type creation.
 */
class CreateBlockTypeControllerTest extends PantherTestCase
{
    use FixtureAttachedTrait {
        setUp as setUpTrait;
    }

    use LogAction;

    use AdminUriProvider;

    use NavigationAction;

    private const EXPECTED_GRID_LINES = 1;

    /** @var Client */
    private $client;

    protected function setUp(): void
    {
        $this->initUserConnection();
    }



    public function testCreateNewBlockType()
    {
        $crawler = $this->navigateToCreatePage($this->client, BlockType::class);
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
            sprintf('Expected %s line, got %s', self::EXPECTED_GRID_LINES, $dataGridLine)
        );
    }

    protected function tearDown(): void
    {
        $this->adminLogout($this->client, $this->client->refreshCrawler());
    }
}
