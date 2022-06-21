<?php

/**
 * File that defines the CantCreatePageTemplateTest class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use Dades\CmsBundle\Entity\PageTemplate;
use Dades\EasyAdminExtensionBundle\Controller\Admin\PageTemplate\PageTemplateCRUDController;
use Dades\TestUtils\LoginPantherTestCase;
use Dades\TestUtils\Provider\AssertMessageProvider;
use Dades\TestUtils\Provider\Selector\Admin\UtilsAdminSelector;
use Exception;
use ReflectionException;

/**
 * This class is used to test the impossibility to create a new page template.
 */
class CantCreatePageTemplateTest extends LoginPantherTestCase
{
    private const EXPECTED_ALERT_MESSAGES = 2;

    /**
     * @throws ReflectionException
     * @throws Exception
     */
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
            sprintf(
                AssertMessageProvider::EXPECTED_ERROR_ALERT_MESSAGE,
                self::EXPECTED_ALERT_MESSAGES,
                $alertDangerNodes
            )
        );
    }
}
