<?php

/**
 * File that defines the UpdatePageTemplateTest class.
 *
 * @author Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use App\Entity\User;
use App\Controller\Admin\Index;
use App\Fixture\FixtureAttachedTrait;
use Symfony\Component\Panther\Client;
use App\Entity\Structure\PageTemplate;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Uri\AdminUriProvider;
use Symfony\Component\Panther\PantherTestCase;

/**
 * Class used to test the update page template form.
 */
class UpdatePageTemplateTest extends PantherTestCase
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


    public function testCreateNewPageTemplate()
    {
        //Navigate to create PageTemplate page.
        $crawler = $this->client->request('GET', Index::ADMIN_HOME_PAGE_URI);
        $this->client->executeScript("document.querySelector('#main-navbar-toggler').click()");
        //wait 1 seconde to display the menu (stop being toggled)
        usleep(1000000);
        $linkGeneralParameters = $crawler->filter('#admin_page_template_grid_id')->link();
        $crawler = $this->client->click($linkGeneralParameters);
        $this->client->executeScript("document.querySelector('.btn-outline-warning').click()");
        $crawler = $this->client->waitFor('.card');

        $updateForm = $crawler->selectButton('register_page_template')->form([
            'create_page_template[name]' => 'New Page Template Test',
            'create_page_template[layout]' => 'new/random/path/to/layout.html.twig',
        ]);
        $crawler = $this->client->submit($updateForm);
        $nodeAlertSuccess = $crawler->filter('.alert-success')->first();
        /** @var PageTemplate $pageTemplate */
        $pageTemplate = $this->fixtureRepository->getReference('page_template');

        $this->assertTrue(
            is_string($nodeAlertSuccess->text()),
            'Got a ' . gettype($nodeAlertSuccess->text()) . ' instead of a string'
        );
        $this->assertGreaterThan(
            0,
            strlen($nodeAlertSuccess->text()),
            'actual value is not greater than expected'
        );
        $this->assertEquals(
            'New Page Template Test',
            $pageTemplate->getName(),
            'page template name are not the same: expected "New Page Template Test", got "' . $pageTemplate->getName()
                . '"'
        );
        $this->assertEquals(
            'new/random/path/to/layout.html.twig',
            $pageTemplate->getLayout(),
            'page template layout are not the same: expected "new/random/path/to/layout.html.twig", got "'
                . $pageTemplate->getName() . '"'
        );
    }

    protected function tearDown(): void
    {
        $crawler = $this->client->request('GET', $this->provideAdminHomePageUri());
        $crawler = $this->adminLogout($this->client, $crawler);
    }
}
