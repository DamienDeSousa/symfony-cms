<?php

/**
 * File that defines the UpdateBlockTypeTest class.
 *
 * @author Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\BlockType;

use App\Entity\Structure\BlockType;
use App\Fixture\FixtureAttachedTrait;
use Symfony\Component\Panther\Client;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Uri\AdminUriProvider;
use App\Tests\Provider\AssertMessageProvider;
use Symfony\Component\Panther\PantherTestCase;
use App\Tests\Provider\Actions\NavigationAction;
use App\Tests\Provider\Selector\Admin\UtilsAdminSelector;
use App\Controller\Admin\BlockType\BlockTypeCRUDController;

/**
 * Class used to test the update page template form.
 */
class UpdateBlockTypeTest extends PantherTestCase
{
    use FixtureAttachedTrait {
        setUp as setUpTrait;
    }

    use LogAction;

    use AdminUriProvider;

    use NavigationAction;

    private const EXPECTED_ROWS_COUNT = 1;

    /** @var null|Client  */
    private $client = null;

    protected function setUp(): void
    {
        $this->initUserConnection();
    }

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

    protected function tearDown(): void
    {
        $this->adminLogout($this->client, $this->client->refreshCrawler());
    }
}
