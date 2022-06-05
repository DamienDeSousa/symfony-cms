<?php

/**
 * This file defines the Update site controller test.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\Site;

use Exception;
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
use App\Tests\Provider\Actions\NavigationAction;
use App\Controller\Admin\Site\SiteCRUDController;
use Symfony\Component\Panther\DomCrawler\Crawler;
use Facebook\WebDriver\Exception\TimeoutException;
use Facebook\WebDriver\Exception\NoSuchElementException;
use App\Tests\Provider\Selector\Admin\UtilsAdminSelector;

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

    use NavigationAction;

    /** @var ?Client */
    private $client;

    protected function setUp(): void
    {
        $this->initUserConnection();
    }

    public function testUpdateWebSiteWithNewTitleAndNewValidImage()
    {
        /** @var Site $site */
        $site = $this->fixtureRepository->getReference('site');
        $crawler = $this->navigateToActionPage(
            $this->client,
            SiteCRUDController::class,
            $site->getId(),
            UtilsAdminSelector::EDIT_BUTTON_REDIRECT_SELECTOR
        );
        $updateForm = $crawler->filter('#edit-Site-form')->form([
            'Site[title]' => 'Obiwan Kenobi'
        ]);
        $updateForm['Site[icon][file]']->upload(dirname(__FILE__) . '/../../../../tests-artifacts/starwars.ico');

        $crawler = $this->submitFormAndReturn($this->client);
        $crawler = UtilsAdminSelector::findRowInDatagrid($crawler, $site->getId());
        $siteTitle = $crawler->filter('td.text-left.field-text > span')->text();
        $siteImage = $crawler->filter('td.text-center.field-image > a > img')->attr('src');

        $this->assertEquals(
            $siteTitle,
            $site->getTitle(),
            'The displayed title on the admin site show page and the expected title are different.'
        );
        $this->assertEquals(
            $siteImage,
            $this->provideAdminBaseUrl() . '/uploads/icon/' . $site->getIcon(),
            'The displayed icon on the admin site show page and the expected icon are different.'
        );
    }

    public function testUpdateSiteWithNewTitleAndEmptyImage()
    {
        /** @var Site $site */
        $site = $this->fixtureRepository->getReference('site');
        $crawler = $this->navigateToActionPage(
            $this->client,
            SiteCRUDController::class,
            $site->getId(),
            UtilsAdminSelector::EDIT_BUTTON_REDIRECT_SELECTOR
        );
        $crawler->filter('#edit-Site-form')->form([
            'Site[title]' => 'Star Wars'
        ]);

        $crawler = $this->submitFormAndReturn($this->client);
        $crawler = UtilsAdminSelector::findRowInDatagrid($crawler, $site->getId());
        $siteTitle = $crawler->filter('td.text-left.field-text > span')->text();
        try {
            $siteImage = $crawler->filter('td.text-center.field-image > a > img')->attr('src');
        } catch (Exception $exception) {
            $siteImage = '';
        }

        $this->assertEquals(
            $siteTitle,
            $site->getTitle(),
            'The displayed title on the admin site show page and the expected title are different.'
        );
        $this->assertNotEquals(
            $siteImage,
            $this->provideAdminBaseUrl() . '/uploads/icon/' . $site->getIcon(),
            'The displayed icon on the admin site show page and the expected icon are different.'
        );
    }

    public function testUpdateSiteWithEmptyTitleAndWrongImageType()
    {
        /** @var Site $site */
        $site = $this->fixtureRepository->getReference('site');
        $crawler = $this->navigateToActionPage(
            $this->client,
            SiteCRUDController::class,
            $site->getId(),
            UtilsAdminSelector::EDIT_BUTTON_REDIRECT_SELECTOR
        );
        $updateForm = $crawler->filter('#edit-Site-form')->form([
            'Site[title]' => ''
        ]);
        $editFormUrl = $this->client->getCurrentURL();
        $crawler = $this->submitFormAndReturn($this->client);

        //assert error messages
        $this->assertEquals(
            $editFormUrl,
            $this->client->getCurrentURL(),
            'Expected to display the admin site update page but another is displayed.'
        );
    }

    protected function tearDown(): void
    {
        /** @var Site $site */
        $site = $this->fixtureRepository->getReference('site');
        if (is_file(dirname(__FILE__) . '/../../../../public/uploads/icon/' . $site->getIcon())) {
            unlink(dirname(__FILE__) . '/../../../../public/uploads/icon/' . $site->getIcon());
        }
        $this->adminLogout($this->client, $this->client->getCrawler());
    }
}
