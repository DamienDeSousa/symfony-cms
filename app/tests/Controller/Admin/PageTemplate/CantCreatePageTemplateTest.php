<?php

/**
 * File that defines the CantCreatePageTemplateTest class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use App\Tests\LoginPantherTestCase;
use App\Entity\Structure\PageTemplate;
use App\Tests\Provider\AssertMessageProvider;
use App\Tests\Provider\Selector\Admin\UtilsAdminSelector;
use App\Controller\Admin\PageTemplate\PageTemplateCRUDController;
use ReflectionException;

/**
 * This class is used to test the impossibility to create a new page template.
 */
class CantCreatePageTemplateTest extends LoginPantherTestCase
{
    private const EXPECTED_ALERT_MESSAGES = 2;

    /**
     * @throws ReflectionException
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
