<?php

/**
 * File that defines the GridPageTemplateTest class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use App\Entity\User;
use App\Controller\Admin\Index;
use App\Fixture\FixtureAttachedTrait;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Uri\AdminUriProvider;
use Symfony\Component\Panther\PantherTestCase;

/**
 * This class is used to test the page template data grid.
 */
class GridPageTemplateTest extends PantherTestCase
{
    use FixtureAttachedTrait {
        setUp as setUpTrait;
    }

    use LogAction;

    use AdminUriProvider;

    protected function setUp(): void
    {
        $this->setUpTrait();
        /** @var User $user */
        $user = $this->fixtureRepository->getReference('user');
        $client = static::createPantherClient();
        $this->login($user, $this->provideAdminLoginUri(), $client);
    }

    public function testDataGridDisplay()
    {
        $client = static::createPantherClient();
        //Navigate to create PageTemplate page.
        $crawler = $client->request('GET', Index::ADMIN_HOME_PAGE_URI);
        $client->executeScript("document.querySelector('#main-navbar-toggler').click()");
        //wait 1 seconde to display the menu (stop being toggled)
        usleep(1000000);
        $linkGeneralParameters = $crawler->filter('#admin_page_template_grid_id')->link();
        $crawler = $client->click($linkGeneralParameters);
        $numberOfLines = $crawler->filter('table > tbody')->children()->count();

        $this->assertEquals(2, $numberOfLines, 'Expected 2 lines in the grid, got ' . $numberOfLines . '.');
    }

    protected function tearDown(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', $this->provideAdminHomePageUri());
        $crawler = $this->adminLogout($client, $crawler);
    }
}
