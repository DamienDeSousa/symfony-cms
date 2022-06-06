<?php

/**
 * File that defines the CantCreatePageTemplateTest class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use App\Fixture\FixtureAttachedTrait;
use Symfony\Component\Panther\Client;
use App\Entity\Structure\PageTemplate;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Uri\AdminUriProvider;
use Symfony\Component\Panther\PantherTestCase;
use App\Tests\Provider\Actions\NavigationAction;
use App\Tests\Provider\Selector\Admin\UtilsAdminSelector;
use App\Controller\Admin\PageTemplate\PageTemplateCRUDController;

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

    use NavigationAction;

    public const EXPECTED_ALERT_MESSAGES = 2;

    public const ERROR_MESSAGE = 'Expected %s alert messages, got %s';

    /** @var Client */
    private $client;

    protected function setUp(): void
    {
        $this->initUserConnection();
    }


    public function testCreateNewPageTemplateWithDataAlreadyUsed()
    {
        /** @var PageTemplate $pageTemplate */
        $pageTemplate = $this->fixtureRepository->getReference('page_template');
        $crawler = $this->navigateToCreatePage($this->client, PageTemplateCRUDController::class);
        $updateForm = $crawler->filter(
            sprintf(
                UtilsAdminSelector::ENTITY_FORM_SELECTOR,
                UtilsAdminSelector::ENTITY_FORM_NEW,
                UtilsAdminSelector::getShortClassName(PageTemplate::class)
            )
        )->form([
            'PageTemplate[name]' => $pageTemplate->getName(),
            'PageTemplate[layout]' => $pageTemplate->getLayout(),
        ]);
        $crawler = $this->submitFormAndReturn($this->client);
        $alertDangerNodes = $crawler->filter('div.invalid-feedback')->count();

        $this->assertEquals(
            self::EXPECTED_ALERT_MESSAGES,
            $alertDangerNodes,
            sprintf(self::ERROR_MESSAGE, self::EXPECTED_ALERT_MESSAGES, $alertDangerNodes)
        );
    }

    protected function tearDown(): void
    {
        $this->adminLogout($this->client, $this->client->refreshCrawler());
    }
}
