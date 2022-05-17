<?php

/**
 * File that defines the UpdateBlockTypeTest class.
 *
 * @author Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\BlockType;

use App\Entity\User;
use RuntimeException;
use InvalidArgumentException;
use App\Controller\Admin\Index;
use App\Entity\Structure\BlockType;
use App\Fixture\FixtureAttachedTrait;
use Symfony\Component\Panther\Client;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Uri\AdminUriProvider;
use Symfony\Component\Panther\PantherTestCase;
use Facebook\WebDriver\Exception\TimeoutException;
use Facebook\WebDriver\Exception\NoSuchElementException;

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
     * Enable this test when src/Form/Type/Block will be set.
     */
    // public function testCreateNewPageTemplate()
    // {
    //     $crawler = $this->client->request('GET', Index::ADMIN_HOME_PAGE_URI);
    //     $this->client->executeScript("document.querySelector('#main-navbar-toggler').click()");
    //     //wait 1 seconde to display the menu (stop being toggled)
    //     usleep(1000000);
    //     $linkGeneralParameters = $crawler->filter('#link_admin_block_type_grid_id')->link();
    //     $crawler = $this->client->click($linkGeneralParameters);
    //     $this->client->executeScript("document.querySelector('.btn-outline-warning').click()");
    //     $crawler = $this->client->waitFor('.card');

    //     $updateForm = $crawler->selectButton('register_block_type')->form([
    //         'create_block_type[type]' => 'body',
    //         'create_block_type[layout]' => 'path/to/body/template.html.twig',
    //     ]);
    //     $crawler = $this->client->submit($updateForm);
    //     $nodeAlertSuccess = $crawler->filter('.alert-success')->first();
    //     /** @var BlockType $blockType */
    //     $blockType = $this->fixtureRepository->getReference('block_type');

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
    //         'body',
    //         $blockType->getType(),
    //         'block type types are not the same: expected "body", got "' . $blockType->getType()
    //             . '"'
    //     );
    // }

    protected function tearDown(): void
    {
        $crawler = $this->client->request('GET', $this->provideAdminHomePageUri());
        $crawler = $this->adminLogout($this->client, $crawler);
    }
}
