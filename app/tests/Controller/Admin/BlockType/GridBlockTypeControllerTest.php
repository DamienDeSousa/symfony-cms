<?php

/**
 * File that defines the GridBlockTypeControllerTest class.
 *
 * @author Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\BlockType;

use App\Controller\Admin\Index;
use App\Entity\User;
use App\Fixture\FixtureAttachedTrait;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Uri\AdminUriProvider;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\PantherTestCase;

/**
 * Class used to test the block type grid controller.
 */
class GridBlockTypeControllerTest extends PantherTestCase
{
    use FixtureAttachedTrait {
        setUp as setUpTrait;
    }

    use LogAction;

    use AdminUriProvider;

    /** @var Client */
    private $client;

    protected function setUp(): void
    {
        $this->setUpTrait();
        /** @var User $user */
        $user = $this->fixtureRepository->getReference('user');
        $this->client = static::createPantherClient();
        $this->login($user, $this->provideAdminLoginUri(), $this->client);
    }

    public function testDataGridDisplay()
    {
        $crawler = $this->client->request('GET', Index::ADMIN_HOME_PAGE_URI);
        $this->client->executeScript("document.querySelector('#main-navbar-toggler').click()");
        //wait 1 seconde to display the menu (stop being toggled)
        usleep(1000000);
        $linkGeneralParameters = $crawler->filter('#link_admin_block_type_grid_id')->link();
        $crawler = $this->client->click($linkGeneralParameters);
        $numberOfLines = $crawler->filter('table > tbody')->children()->count();

        $this->assertEquals(2, $numberOfLines, 'Expected 2 lines in the grid, got ' . $numberOfLines . '.');
    }

    protected function tearDown(): void
    {
        $crawler = $this->client->request('GET', $this->provideAdminHomePageUri());
        $crawler = $this->adminLogout($this->client, $crawler);
    }
}