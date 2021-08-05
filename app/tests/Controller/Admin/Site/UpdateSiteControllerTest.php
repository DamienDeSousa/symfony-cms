<?php

/**
 * This file defines the Update site controller test.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\Site;

use LogicException;
use App\Entity\Site;
use App\Entity\User;
use RuntimeException;
use InvalidArgumentException;
use App\Controller\Admin\Index;
use App\Fixture\FixtureAttachedTrait;
use Symfony\Component\Panther\Client;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Data\SiteProvider;
use App\Tests\Provider\Uri\AdminUriProvider;
use App\Tests\Provider\Url\AdminUrlProvider;
use Symfony\Component\Panther\PantherTestCase;
use Symfony\Component\Panther\DomCrawler\Crawler;
use Facebook\WebDriver\Exception\TimeoutException;
use Facebook\WebDriver\Exception\NoSuchElementException;

/**
 * This class is used to test the update site feature.
 */
class UpdateSiteControllerTest extends PantherTestCase
{
    use FixtureAttachedTrait {
        setUp as setUpTrait;
    }

    use AdminUriProvider;

    use LogAction;

    use SiteProvider;

    use AdminUrlProvider;

    protected function setUp(): void
    {
        $this->setUpTrait();
        /** @var User $user */
        $user = $this->fixtureRepository->getReference('user');
        $client = static::createPantherClient();
        $this->login($user, $this->provideAdminLoginUri(), $client);
    }

    /**
     * This method IS NOT a test. It is just used to navigate to the update site form page.
     *
     * @param Client $client
     *
     * @return Crawler
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws LogicException
     * @throws NoSuchElementException
     * @throws TimeoutException
     */
    private function navigateToUpdateSitePage(Client $client): Crawler
    {
        $crawler = $client->request('GET', Index::ADMIN_HOME_PAGE_URI);
        $client->executeScript("document.querySelector('#main-navbar-toggler').click()");
        //wait 1 seconde to display the menu (stop being toggled)
        usleep(1000000);
        $linkGeneralParameters = $crawler->filter('#link_admin_site_show_id')->link();
        $crawler = $client->click($linkGeneralParameters);
        $client->executeScript("document.querySelector('.card-header').click()");

        return $client->waitFor('.card');
    }

    public function testUpdateWebSiteWithNewTitleAndNewValidImage()
    {
        /** @var Site $site */
        $site = $this->fixtureRepository->getReference('site');
        $client = static::createPantherClient();
        $crawler = $this->navigateToUpdateSitePage($client);
        $updateForm = $crawler->selectButton('update_site[save]')->form([
            'update_site[title]' => 'Star Wars',
        ]);
        $updateForm['update_site[icon]']->upload(dirname(__FILE__) . '/../../../../tests-artifacts/starwars.ico');
        $crawler = $client->submit($updateForm);

        $this->assertEquals(
            $crawler->filter('ul > li:nth-child(1) > span.lead')->text(),
            'Star Wars',
            'The displayed title on the admin site show page and the expected title are different.'
        );
        $this->assertEquals(
            $client->getTitle(),
            'Star Wars',
            'The displayed title on the tab and the expected title are different.'
        );
        $this->assertEquals(
            $crawler->filter('ul > li:nth-child(2) > img')->attr('src'),
            $this->provideAdminBaseUrl() . '/uploads/icon/' . $site->getIcon(),
            'The displayed icon on the admin site show page and the expected icon are different.'
        );
        $this->assertEquals(
            $crawler->filter('head > link:nth-child(5)')->attr('href'),
            $this->provideAdminBaseUrl() . '/uploads/icon/' . $site->getIcon(),
            'The displayed icon on the tab and the expected icon are different.'
        );
    }

    public function testUpdateSiteWithNewTitleAndEmptyImage()
    {
        $client = static::createPantherClient();
        $crawler = $this->navigateToUpdateSitePage($client);
        $updateForm = $crawler->selectButton('update_site[save]')->form([
            'update_site[title]' => 'Star Wars',
        ]);
        $crawler = $client->submit($updateForm);

        $this->assertEquals(
            $crawler->filter('ul > li:nth-child(1) > span.lead')->text(),
            'Star Wars',
            'The displayed title on the admin site show page and the expected title are different.'
        );
        $this->assertEquals(
            $client->getTitle(),
            'Star Wars',
            'The displayed title on the tab and the expected title are different.'
        );
        $this->assertEquals(
            $crawler->filter('ul > li:nth-child(2) > img')->attr('src'),
            $this->provideAdminBaseUrl() . '/uploads/icon/',
            'No image must be present, seems that there is one.'
        );
    }

    public function testUpdateSiteWithEmptyTitleAndWrongImageType()
    {
        /** @var Site $site */
        $site = $this->fixtureRepository->getReference('site');
        $client = static::createPantherClient();
        $crawler = $this->navigateToUpdateSitePage($client);
        $updateForm = $crawler->selectButton('update_site[save]')->form([]);
        //upload wrong file
        $updateForm['update_site[icon]']->upload(dirname(__FILE__) . '/../../../../tests-artifacts/starwars.pdf');
        $crawler = $client->submit($updateForm);

        //assert error messages
        $this->assertEquals(
            $client->getCurrentURL(),
            $this->provideAdminBaseUrl() . $this->provideAdminSiteUpdateUri(),
            'Expected to display the admin site update page but another is displayed.'
        );
        $this->assertEquals(
            $crawler->filter('div.alert.alert-danger')->count(),
            1,
            'Expected to display 1 alert error message, but 0 or more than 1 are presents.'
        );
    }

    protected function tearDown(): void
    {
        /** @var Site $site */
        $site = $this->fixtureRepository->getReference('site');
        if (is_file(dirname(__FILE__) . '/../../../../public/uploads/icon/' . $site->getIcon())) {
            unlink(dirname(__FILE__) . '/../../../../public/uploads/icon/' . $site->getIcon());
        }
        $client = static::createPantherClient();
        $crawler = $client->request('GET', $this->provideAdminHomePageUri());
        $crawler = $this->adminLogout($client, $crawler);
    }
}
