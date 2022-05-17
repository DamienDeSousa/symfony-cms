<?php

/**
 * File that defines the CreateBlockTypeControllerTest class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\BlockType;

use Exception;
use LogicException;
use App\Entity\User;
use RuntimeException;
use InvalidArgumentException;
use App\Controller\Admin\Index;
use App\Fixture\FixtureAttachedTrait;
use Symfony\Component\Panther\Client;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Uri\AdminUriProvider;
use Symfony\Component\Panther\PantherTestCase;
use PHPUnit\Framework\ExpectationFailedException;
use Facebook\WebDriver\Exception\TimeoutException;
use Facebook\WebDriver\Exception\NoSuchElementException;
use SebastianBergmann\RecursionContext\InvalidArgumentException as RecursionContextInvalidArgumentException;

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


    /**
     * Desable this for while src/Form/Type/Block directory is empty
     * TODO : Enable it when the directory src/Form/Type/Block is set
     */
    // public function testCreateNewBlockType()
    // {
    //     //Navigate to create BlockType page.
    //     $crawler = $this->client->request('GET', Index::ADMIN_HOME_PAGE_URI);
    //     $this->client->executeScript("document.querySelector('#main-navbar-toggler').click()");
    //     //wait 1 seconde to display the menu (stop being toggled)
    //     usleep(1000000);
    //     $linkGeneralParameters = $crawler->filter('#link_admin_block_type_grid_id')->link();
    //     $crawler = $this->client->click($linkGeneralParameters);
    //     $this->client->executeScript("document.querySelector('#create-block-type-button').click()");
    //     $crawler = $this->client->waitFor('.card');

    //     $createForm = $crawler->selectButton('register_block_type')->form([
    //         'create_block_type[type]' => 'Block Type Test',
    //         'create_block_type[layout]' => 'path/to/layout.html.twig',
    //         'create_block_type[formType]' => '',
    //     ]);
    //     $crawler = $this->client->submit($createForm);
    //     $nodeAlertSuccess = $crawler->filter('.alert-success')->first();

    //     $this->assertTrue(
    //         is_string($nodeAlertSuccess->text()),
    //         'Got a ' . gettype($nodeAlertSuccess->text()) . ' instead of a string'
    //     );
    //     $this->assertGreaterThan(
    //         0,
    //         strlen($nodeAlertSuccess->text()),
    //         'actual value is not greater than expected'
    //     );
    // }

    protected function tearDown(): void
    {
        $crawler = $this->client->request('GET', $this->provideAdminHomePageUri());
        $crawler = $this->adminLogout($this->client, $crawler);
    }
}
