<?php

/**
 * File that defines the ShowBlockTypeTest class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\BlockType;

use App\Entity\Structure\BlockType;
use App\Fixture\FixtureAttachedTrait;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Uri\AdminUriProvider;
use Symfony\Component\Panther\PantherTestCase;
use App\Tests\Provider\Actions\NavigationAction;
use App\Tests\Provider\Selector\Admin\UtilsAdminSelector;
use App\Controller\Admin\BlockType\BlockTypeCRUDController;
use App\Tests\Controller\Admin\Site\ShowSiteControllerTest;

/**
 * This class is used to test the page template data grid.
 */
class ShowBlockTypeTest extends PantherTestCase
{
    use FixtureAttachedTrait {
        setUp as setUpTrait;
    }

    use LogAction;

    use AdminUriProvider;

    use NavigationAction;

    /**
     * @var \Symfony\Component\Panther\Client
     */
    private $client = null;

    protected function setUp(): void
    {
        $this->initUserConnection();
    }

    public function testShowBlockTypePage()
    {
        /** @var BlockType $blockType */
        $blockType = $this->fixtureRepository->getReference('block_type');
        $crawler = $this->navigateLeftMenuLink($this->client, BlockTypeCRUDController::class);
        $node = UtilsAdminSelector::findRowInDatagrid($crawler, $blockType->getId());

        $this->assertEquals(
            $blockType->getId(),
            $node->attr('data-id'),
            sprintf(ShowSiteControllerTest::ERROR_MESSAGE, $blockType->getId(), $node->attr('data-id'))
        );
    }

    protected function tearDown(): void
    {
        $this->adminLogout($this->client, $this->client->refreshCrawler());
    }
}
