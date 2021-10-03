<?php

/**
 * File that defines the CantCreatePageTemplateTest class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use App\Entity\User;
use App\Controller\Admin\Index;
use App\Fixture\FixtureAttachedTrait;
use App\Entity\Structure\PageTemplate;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Uri\AdminUriProvider;
use Symfony\Component\Panther\PantherTestCase;

/**
 * This class is used to test the impossibility to create a new page template.
 */
class CantCreatePageTemplateTest extends PantherTestCase
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


    public function testCreateNewPageTemplateWithDataAlreadyUsed()
    {
        /** @var PageTemplate $pageTemplate */
        $pageTemplate = $this->fixtureRepository->getReference('page_template');
        $client = static::createPantherClient();
        //Navigate to create PageTemplate page.
        $crawler = $client->request('GET', Index::ADMIN_HOME_PAGE_URI);
        $client->executeScript("document.querySelector('#main-navbar-toggler').click()");
        //wait 1 seconde to display the menu (stop being toggled)
        usleep(1000000);
        $linkGeneralParameters = $crawler->filter('#admin_page_template_grid_id')->link();
        $crawler = $client->click($linkGeneralParameters);
        $client->executeScript("document.querySelector('#create-page-template-button').click()");
        $crawler = $client->waitFor('.card');

        $updateForm = $crawler->selectButton('register_page_template')->form([
            'create_page_template[name]' => $pageTemplate->getName(),
            'create_page_template[layout]' => $pageTemplate->getLayout(),
        ]);
        $crawler = $client->submit($updateForm);
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
        $client = static::createPantherClient();
        $crawler = $client->request('GET', $this->provideAdminHomePageUri());
        $crawler = $this->adminLogout($client, $crawler);
    }
}