<?php

/**
 * File that defines the ShowPageTemplateTest class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use App\Tests\LoginPantherTestCase;
use App\Entity\Structure\PageTemplate;
use App\Tests\Provider\AssertMessageProvider;
use App\Tests\Provider\Selector\Admin\UtilsAdminSelector;
use App\Controller\Admin\PageTemplate\PageTemplateCRUDController;

/**
 * This class is used to test the page template data grid.
 */
class ShowPageTemplateTest extends LoginPantherTestCase
{
    public function testShowPageTemplatePage()
    {
        /** @var PageTemplate $pageTemplate */
        $pageTemplate = $this->fixtureRepository->getReference('page_template');
        $crawler = $this->navigateLeftMenuLink($this->client, PageTemplateCRUDController::class);
        $node = UtilsAdminSelector::findRowInDatagrid($crawler, $pageTemplate->getId());

        $this->assertEquals(
            $pageTemplate->getId(),
            $node->attr(UtilsAdminSelector::DATA_ID_ATTR_TAG_SELECTOR),
            sprintf(
                AssertMessageProvider::EXPECTED_ROW_ENTITY_ID_ERROR_MESSAGE,
                $pageTemplate->getId(),
                $node->attr(UtilsAdminSelector::DATA_ID_ATTR_TAG_SELECTOR)
            )
        );
    }
}
