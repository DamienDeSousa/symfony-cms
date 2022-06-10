<?php

/**
 * File that defines the DeletePageTemplateTest class.
 *
 * @author Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use App\Controller\Admin\PageTemplate\PageTemplateCRUDController;
use App\Tests\LoginPantherTestCase;
use App\Entity\Structure\PageTemplate;
use App\Tests\Provider\AssertMessageProvider;
use App\Tests\Provider\Selector\Admin\UtilsAdminSelector;

/**
 * Class used to test the delete page template.
 */
class DeletePageTemplateTest extends LoginPantherTestCase
{
    public function testDeletePageTemplate()
    {
        /** @var PageTemplate $pageTemplate */
        $pageTemplate = $this->fixtureRepository->getReference('page_template');
        $crawler = $this->navigateToActionPage(
            $this->client,
            PageTemplateCRUDController::class,
            $pageTemplate->getId(),
            UtilsAdminSelector::DELETE_BUTTON_MODAL_SELECTOR
        );
        $crawler = $this->clickElement($this->client, UtilsAdminSelector::DELETE_ENTITY_BUTTON_SELECTOR);
        $emptyResult = $crawler->filter(UtilsAdminSelector::NO_DATAGRID_RESULT_SELECTOR)->count();

        $this->assertEquals(
            AssertMessageProvider::COUNT_EXPECTED_NO_RESULT_MESSAGE,
            $emptyResult,
            AssertMessageProvider::EXPECTED_NO_RESULT_ERROR_MESSAGE
        );
    }
}
