<?php

/**
 * File that defines the ShowBlockTypeTest class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\BlockType;

use App\Entity\User;
use App\Controller\Admin\Index;
use App\Fixture\FixtureAttachedTrait;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Uri\AdminUriProvider;
use Symfony\Component\Panther\PantherTestCase;

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

    /**
     * @var \Symfony\Component\Panther\Client
     */
    private $client = null;

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
        //Navigate to create PageTemplate page.
        $crawler = $this->client->request('GET', Index::ADMIN_HOME_PAGE_URI);
        $this->client->executeScript("document.querySelector('#main-navbar-toggler').click()");
        //wait 1 seconde to display the menu (stop being toggled)
        usleep(1000000);
        $linkPageGrid = $crawler->filter('#link_admin_block_type_grid_id')->link();
        $crawler = $this->client->click($linkPageGrid);
        $this->client->executeScript("document.querySelector('.btn-outline-info').click()");
        $crawler = $this->client->waitFor('table');
        $numberOflineInTable = $crawler->filter('table > tbody')->children()->count();

        $this->assertEquals(
            2,
            $numberOflineInTable,
            'Expected 2 lines in the table, got ' . $numberOflineInTable . '.'
        );
    }

    protected function tearDown(): void
    {
        $crawler = $this->client->request('GET', $this->provideAdminHomePageUri());
        $crawler = $this->adminLogout($this->client, $crawler);
    }
}
