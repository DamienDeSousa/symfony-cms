<?php

/**
 * File that defines the DeleteLinkedPageTemplateTest class.
 *
 * @author Damien DE SOUSA
 * @copyright 2022
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use App\Entity\User;
use RuntimeException;
use InvalidArgumentException;
use App\Controller\Admin\Index;
use App\Fixture\FixtureAttachedTrait;
use Symfony\Component\Panther\Client;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Uri\AdminUriProvider;
use Symfony\Component\Panther\PantherTestCase;
use Facebook\WebDriver\Exception\TimeoutException;
use Facebook\WebDriver\Exception\NoSuchElementException;

/**
 * This class is used to test the possibility to deleted a page template linked to a block type.
 */
class DeleteLinkedPageTemplateTest extends PantherTestCase
{
    use FixtureAttachedTrait {
        setUp as setUpTrait;
    }

    use LogAction;

    use AdminUriProvider;

    /** @var null|Client  */
    private $client = null;

    protected function setUp(): void
    {
        $this->setUpTrait();
        /** @var User $user */
        $user = $this->fixtureRepository->getReference('user');
        $this->client = static::createPantherClient();
        $this->login($user, $this->provideAdminLoginUri(), $this->client);
    }

    /**
     * ToDo:
     * rework this test when PageTemplateBlockTypes are intégrated
     */
    // public function testDeleteLinkedPageTemplate()
    // {
    //     //Navigate to create PageTemplate page.
    //     $crawler = $this->client->request('GET', Index::ADMIN_HOME_PAGE_URI);
    //     $this->client->executeScript("document.querySelector('#main-navbar-toggler').click()");
    //     //wait 1 seconde to display the menu (stop being toggled)
    //     usleep(1000000);
    //     $linkGeneralParameters = $crawler->filter('#admin_page_template_grid_id')->link();
    //     $crawler = $this->client->click($linkGeneralParameters);
    //     $this->client->executeScript("document.querySelector('.btn-outline-danger').click()");
    //     $crawler = $this->client->waitFor('.modal');
    //     $this->client->executeScript("document.querySelector('.btn-danger').click()");
    //     $crawler = $this->client->refreshCrawler();
    //     $nodeAlertSuccess = $crawler->filter('.alert-success');
    //     $tableRows = $crawler->filter('table > tbody')->children()->count();

    //     $this->assertTrue(
    //         is_string($nodeAlertSuccess->text()),
    //         'Got a ' . gettype($nodeAlertSuccess->text()) . ' instead of a string'
    //     );
    //     $this->assertGreaterThan(
    //         0,
    //         strlen($nodeAlertSuccess->text()),
    //         'actual value is not greater than expected'
    //     );
    //     $this->assertEquals(
    //         0,
    //         $tableRows,
    //         'Page template not deleted, expected 0 rows in table, got ' . $tableRows . ' rows'
    //     );
    // }

    protected function tearDown(): void
    {
        $crawler = $this->client->request('GET', $this->provideAdminHomePageUri());
        $crawler = $this->adminLogout($this->client, $crawler);
    }
}
