<?php

/**
 * File that defines the DeleteLinkedBlockTypeControllerTest class.
 *
 * @author Damien DE SOUSA
 * @copyright 2022
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\BlockType;

use App\Entity\User;
use App\Controller\Admin\Index;
use App\Entity\Structure\BlockType;
use App\Fixture\FixtureAttachedTrait;
use Symfony\Component\Panther\Client;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Uri\AdminUriProvider;
use Symfony\Component\Panther\PantherTestCase;

/**
 * Class used to test the deletion to a linked block type.
 */
class DeleteLinkedBlockTypeControllerTest extends PantherTestCase
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

    public function testUnableToDeleteLinkedBlockType()
    {
        $crawler = $this->client->request('GET', Index::ADMIN_HOME_PAGE_URI);
        /** @var BlockType $linkedBlockType */
        $linkedBlockType = $this->fixtureRepository->getReference('linked_block_type');
        $this->client->executeScript("document.querySelector('#main-navbar-toggler').click()");
        //wait 1 seconde to display the menu (stop being toggled)
        usleep(1000000);
        $linkGeneralParameters = $crawler->filter('#link_admin_block_type_grid_id')->link();
        $crawler = $this->client->click($linkGeneralParameters);
        $firstButton = sprintf('#modal_delete_%d', $linkedBlockType->getId());
        $this->client->executeScript(
            "document.querySelector('.btn-outline-danger[data-target=\"$firstButton\"]').click()"
        );
        $crawler = $this->client->waitFor('.modal');
        $this->client->executeScript("document.querySelector('.btn-danger').click()");
        $crawler = $this->client->refreshCrawler();
        $nodeAlertError = $crawler->filter('.alert-danger');
        $tableRows = $crawler->filter('table > tbody')->children()->count();

        $this->assertTrue(
            is_string($nodeAlertError->text()),
            'Got a ' . gettype($nodeAlertError->text()) . ' instead of a string'
        );
        $this->assertGreaterThan(
            0,
            strlen($nodeAlertError->text()),
            'actual value is not greater than expected'
        );
        $this->assertEquals(
            1,
            $tableRows,
            'Page template not deleted, expected 1 rows in table, got ' . $tableRows . ' rows'
        );
    }

    protected function tearDown(): void
    {
        $crawler = $this->client->request('GET', $this->provideAdminHomePageUri());
        $crawler = $this->adminLogout($this->client, $crawler);
    }
}
