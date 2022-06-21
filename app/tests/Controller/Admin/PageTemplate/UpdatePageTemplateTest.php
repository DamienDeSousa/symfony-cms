<?php

/**
 * File that defines the UpdatePageTemplateTest class.
 *
 * @author Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use Dades\CmsBundle\Entity\PageTemplate;
use Dades\EasyAdminExtensionBundle\Controller\Admin\PageTemplate\PageTemplateCRUDController;
use Dades\TestUtils\LoginPantherTestCase;
use Dades\TestUtils\Provider\AssertMessageProvider;
use Dades\TestUtils\Provider\Selector\Admin\UtilsAdminSelector;
use ReflectionException;

/**
 * Class used to test the update page template form.
 */
class UpdatePageTemplateTest extends LoginPantherTestCase
{
    private const EXPECTED_ROWS_COUNT = 1;

    private const EXPECTED_ALERT_MESSAGES = 2;

    /**
     * @throws ReflectionException
     * @throws \Exception
     */
    public function testUpdatePageTemplate()
    {
        /** @var PageTemplate $pageTemplate */
        $pageTemplate = $this->fixtureRepository->getReference('page_template');
        $crawler = $this->navigateToActionPage(
            $this->client,
            PageTemplateCRUDController::class,
            $pageTemplate->getId(),
            UtilsAdminSelector::EDIT_BUTTON_REDIRECT_SELECTOR
        );
        $updateForm = $crawler->filter(
            sprintf(
                UtilsAdminSelector::ENTITY_FORM_SELECTOR,
                UtilsAdminSelector::ENTITY_FORM_EDIT,
                UtilsAdminSelector::getShortClassName(PageTemplate::class)
            )
        )->form([
            'PageTemplate[name]' => 'Obiwan Kenobi',
            'PageTemplate[layout]' => 'another/file/path/file.html.twig',
        ]);
        $crawler = $this->submitFormAndReturn($this->client);
        $datagridRow = UtilsAdminSelector::findRowInDatagrid($crawler, $pageTemplate->getId())->count();

        $this->assertEquals(
            self::EXPECTED_ROWS_COUNT,
            $datagridRow,
            sprintf(AssertMessageProvider::EXPECTED_ROWS_NUMBER_ERROR_MESSAGE, self::EXPECTED_ROWS_COUNT, $datagridRow)
        );
    }

    /**
     * @throws ReflectionException
     * @throws \Exception
     */
    public function testUpdatePageTemplateWithSameData()
    {
        /** @var PageTemplate $pageTemplate */
        $pageTemplate = $this->fixtureRepository->getReference('page_template');
        /** @var PageTemplate $pageTemplate2 */
        $pageTemplate2 = $this->fixtureRepository->getReference('page_template2');
        $crawler = $this->navigateToActionPage(
            $this->client,
            PageTemplateCRUDController::class,
            $pageTemplate->getId(),
            UtilsAdminSelector::EDIT_BUTTON_REDIRECT_SELECTOR
        );
        $updateForm = $crawler->filter(
            sprintf(
                UtilsAdminSelector::ENTITY_FORM_SELECTOR,
                UtilsAdminSelector::ENTITY_FORM_EDIT,
                UtilsAdminSelector::getShortClassName(PageTemplate::class)
            )
        )->form([
            'PageTemplate[name]' => $pageTemplate2->getName(),
            'PageTemplate[layout]' => $pageTemplate2->getLayout(),
        ]);
        $crawler = $this->submitFormAndReturn($this->client);
        $alertDangerNodes = $crawler->filter(UtilsAdminSelector::ALERT_FORM_MESSAGE_SELECTOR)->count();

        $this->assertEquals(
            self::EXPECTED_ALERT_MESSAGES,
            $alertDangerNodes,
            sprintf(
                'Expected %s alert messages, got %s',
                self::EXPECTED_ALERT_MESSAGES,
                $alertDangerNodes
            )
        );
    }
}
