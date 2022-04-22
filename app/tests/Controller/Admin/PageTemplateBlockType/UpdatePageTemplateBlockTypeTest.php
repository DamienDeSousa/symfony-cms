<?php

/**
 * File that defines the UpdatePageTemplateBlockTypeTest test class.
 *
 * @author Damien DE SOUSA
 * @copyright 2022
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplateBlockType;

use App\Entity\User;
use App\Controller\Admin\Index;
use App\Entity\Structure\BlockType;
use App\Fixture\FixtureAttachedTrait;
use Symfony\Component\Panther\Client;
use App\Entity\Structure\PageTemplate;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Uri\AdminUriProvider;
use App\Tests\Provider\Url\AdminUrlProvider;
use Symfony\Component\Panther\PantherTestCase;
use App\Entity\Structure\PageTemplateBlockType;
use App\Controller\Admin\PageTemplateBlockType\UpdatePageTemplateBlockTypeController;

/**
 * Tests the right behaviour of page template block type updating.
 */
class UpdatePageTemplateBlockTypeTest extends PantherTestCase
{
    use FixtureAttachedTrait {
        setUp as setUpTrait;
    }

    use LogAction;

    use AdminUriProvider;

    use AdminUrlProvider;

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

    public function testUpdatePageTemplateBlockTypeSuccessfully()
    {
        $newPageTemplate = $this->fixtureRepository->getReference('new_page_template');
        $newBlockType = $this->fixtureRepository->getReference('new_block_type');

        $crawler = $this->client->request('GET', Index::ADMIN_HOME_PAGE_URI);
        $this->client->executeScript("document.querySelector('#main-navbar-toggler').click()");
        //wait 1 seconde to display the menu (stop being toggled)
        usleep(1000000);
        $linkGeneralParameters = $crawler->filter('#link_admin_page_template_block_type_grid_id')->link();
        $crawler = $this->client->click($linkGeneralParameters);
        $this->client->executeScript("document.querySelector('.btn-outline-warning').click()");
        $crawler = $this->client->waitFor('.card');

        $updateForm = $crawler->selectButton('register_page_template_block_type')->form([
            'create_page_template_block_type[slug]' => 'my_little_slug',
            'create_page_template_block_type[pageTemplate]' => $newPageTemplate->getId(),
            'create_page_template_block_type[blockType]' => $newBlockType->getId(),
        ]);
        $crawler = $this->client->submit($updateForm);
        $nodeAlertSuccess = $crawler->filter('.alert-success')->first();

        $this->assertTrue(
            is_string($nodeAlertSuccess->text()),
            'Got a ' . gettype($nodeAlertSuccess->text()) . ' instead of a string'
        );
        $this->assertGreaterThan(
            0,
            strlen($nodeAlertSuccess->text()),
            'actual value is not greater than expected'
        );
    }

    public function testCreatePageTemplateBlockTypeWithEmptySlug()
    {
        /** @var PageTemplate $pageTemplate */
        $pageTemplate = $this->fixtureRepository->getReference('page_template');
        /** @var BlockType $blockType */
        $blockType = $this->fixtureRepository->getReference('block_type');
        /** @var PageTemplateBlockType $pageTemplateBlockType */
        $pageTemplateBlockType = $this->fixtureRepository->getReference('page_template_block_type');

        $crawler = $this->client->request('GET', Index::ADMIN_HOME_PAGE_URI);
        $this->client->executeScript("document.querySelector('#main-navbar-toggler').click()");
        //wait 1 seconde to display the menu (stop being toggled)
        usleep(1000000);
        $linkGeneralParameters = $crawler->filter('#link_admin_page_template_block_type_grid_id')->link();
        $crawler = $this->client->click($linkGeneralParameters);
        $this->client->executeScript("document.querySelector('.btn-outline-warning').click()");
        $crawler = $this->client->waitFor('.card');

        $updateForm = $crawler->selectButton('register_page_template_block_type')->form([
            'create_page_template_block_type[slug]' => '',
            'create_page_template_block_type[pageTemplate]' => $pageTemplate->getId(),
            'create_page_template_block_type[blockType]' => $blockType->getId(),
        ]);
        $crawler = $this->client->submit($updateForm);

        $expectedUrl = $this->provideAdminBaseUrl()
            . UpdatePageTemplateBlockTypeController::UPDATE_PAGE_TEMPLATE_BLOCK_TYPE_ROUTE_URI
            . $pageTemplateBlockType->getId();

        $this->assertEquals(
            $expectedUrl,
            $this->client->getCurrentURL(),
            'form cant be submitted with empty slug, expected url [' . $expectedUrl . '], current url ['
                . $this->client->getCurrentURL() . ']'
        );
    }

    public function testCreatePageTemplateBlockTypeWithAlreadyExistingSlugForPageTemplateAndBlockType()
    {
        /** @var PageTemplate $newPageTemplate */
        $newPageTemplate = $this->fixtureRepository->getReference('new_page_template');
        /** @var BlockType $blockType */
        $blockType = $this->fixtureRepository->getReference('block_type');
        /** @var PageTemplateBlockType $pageTemplateBlockType */
        $pageTemplateBlockType = $this->fixtureRepository->getReference('page_template_block_type');

        $crawler = $this->client->request('GET', Index::ADMIN_HOME_PAGE_URI);
        $this->client->executeScript("document.querySelector('#main-navbar-toggler').click()");
        //wait 1 seconde to display the menu (stop being toggled)
        usleep(1000000);
        $linkGeneralParameters = $crawler->filter('#link_admin_page_template_block_type_grid_id')->link();
        $crawler = $this->client->click($linkGeneralParameters);
        $this->client->executeScript("document.querySelector('.btn-outline-warning').click()");
        $crawler = $this->client->waitFor('.card');

        $updateForm = $crawler->selectButton('register_page_template_block_type')->form([
            'create_page_template_block_type[slug]' => $pageTemplateBlockType->getSlug(),
            'create_page_template_block_type[pageTemplate]' => $newPageTemplate->getId(),
            'create_page_template_block_type[blockType]' => $blockType->getId(),
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

    protected function tearDown(): void
    {
        $crawler = $this->client->request('GET', $this->provideAdminHomePageUri());
        $crawler = $this->adminLogout($this->client, $crawler);
    }
}
