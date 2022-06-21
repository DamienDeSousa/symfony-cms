<?php

/**
 * File that defines the ShowPageTemplateTest class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use Dades\CmsBundle\Entity\PageTemplate;
use Dades\EasyAdminExtensionBundle\Controller\Admin\PageTemplate\PageTemplateCRUDController;
use Dades\TestUtils\LoginPantherTestCase;
use Dades\TestUtils\Provider\AssertMessageProvider;
use Dades\TestUtils\Provider\Selector\Admin\UtilsAdminSelector;

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
