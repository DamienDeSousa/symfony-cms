<?php

/**
 * Defines the CantUpdateBlockTypeTest class.
 *
 * @author Damien DE SOUSA
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
use App\Tests\Provider\Url\AdminUrlProvider;
use Symfony\Component\Panther\PantherTestCase;

/**
 * Tests the behaviour when wrong data are set.
 */
class CantUpdateBlockTypeTest extends PantherTestCase
{
    use FixtureAttachedTrait {
        setUp as setUpTrait;
    }

    use LogAction;

    use AdminUriProvider;

    use AdminUrlProvider;

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

    public function testUpdateWithAlreadyUsedType()
    {
        /** @var BlockType $firstBlock */
        $firstBlock = $this->fixtureRepository->getReference('block_type_0');
        /** @var BlockType $secondBlock */
        $secondBlock = $this->fixtureRepository->getReference('block_type_1');
        $crawler = $this->client->request('GET', Index::ADMIN_HOME_PAGE_URI);
        $this->client->executeScript("document.querySelector('#main-navbar-toggler').click()");
        //wait 1 seconde to display the menu (stop being toggled)
        usleep(1000000);
        $linkGeneralParameters = $crawler->filter('#link_admin_block_type_grid_id')->link();
        $crawler = $this->client->click($linkGeneralParameters);
        $this->client->executeScript("document.querySelector('.btn-outline-warning').click()");
        $crawler = $this->client->waitFor('.card');

        $updateForm = $crawler->selectButton('register_block_type')->form([
            'create_block_type[type]' => $secondBlock->getType(),
        ]);
        $crawler = $this->client->submit($updateForm);

        $alertDangerNode = $crawler->filter('.alert-danger')->first();

        $this->assertTrue(
            is_string($alertDangerNode->text()),
            'Got a ' . gettype($alertDangerNode->text()) . ' instead of a string'
        );
        $this->assertGreaterThan(
            0,
            strlen($alertDangerNode->text()),
            'actual value is not greater than expected'
        );
    }

    public function testUpdateWithAlreadyUsedLayout()
    {
        /** @var BlockType $firstBlock */
        $firstBlock = $this->fixtureRepository->getReference('block_type_0');
        /** @var BlockType $secondBlock */
        $secondBlock = $this->fixtureRepository->getReference('block_type_1');
        $crawler = $this->client->request('GET', Index::ADMIN_HOME_PAGE_URI);
        $this->client->executeScript("document.querySelector('#main-navbar-toggler').click()");
        //wait 1 seconde to display the menu (stop being toggled)
        usleep(1000000);
        $linkGeneralParameters = $crawler->filter('#link_admin_block_type_grid_id')->link();
        $crawler = $this->client->click($linkGeneralParameters);
        $this->client->executeScript("document.querySelector('.btn-outline-warning').click()");
        $crawler = $this->client->waitFor('.card');

        $updateForm = $crawler->selectButton('register_block_type')->form([
            'create_block_type[layout]' => $secondBlock->getLayout(),
        ]);
        $crawler = $this->client->submit($updateForm);

        $alertDangerNode = $crawler->filter('.alert-danger')->first();

        $this->assertTrue(
            is_string($alertDangerNode->text()),
            'Got a ' . gettype($alertDangerNode->text()) . ' instead of a string'
        );
        $this->assertGreaterThan(
            0,
            strlen($alertDangerNode->text()),
            'actual value is not greater than expected'
        );
    }

    public function testUpdateWithEmptyValues()
    {
        /** @var BlockType $firstBlock */
        $firstBlock = $this->fixtureRepository->getReference('block_type_0');
        /** @var BlockType $secondBlock */
        $secondBlock = $this->fixtureRepository->getReference('block_type_1');
        $crawler = $this->client->request('GET', Index::ADMIN_HOME_PAGE_URI);
        $this->client->executeScript("document.querySelector('#main-navbar-toggler').click()");
        //wait 1 seconde to display the menu (stop being toggled)
        usleep(1000000);
        $linkGeneralParameters = $crawler->filter('#link_admin_block_type_grid_id')->link();
        $crawler = $this->client->click($linkGeneralParameters);
        $this->client->executeScript("document.querySelector('.btn-outline-warning').click()");
        $crawler = $this->client->waitFor('.card');

        $updateForm = $crawler->selectButton('register_block_type')->form([
            'create_block_type[type]' => '',
            'create_block_type[layout]' => '',
        ]);
        $crawler = $this->client->submit($updateForm);

        $expectedPage = $this->provideAdminBaseUrl() . $this->provideAdminBlockTypeUpdateUri() . $firstBlock->getId();
        $actualPage = $this->client->getCurrentURL();
        $this->assertEquals(
            $expectedPage,
            $actualPage,
            sprintf('Expected to be on page %s, actual page is %s', $expectedPage, $actualPage)
        );
    }

    protected function tearDown(): void
    {
        $crawler = $this->client->request('GET', $this->provideAdminHomePageUri());
        $crawler = $this->adminLogout($this->client, $crawler);
    }
}
