<?php

/**
 * Defines the NavigationAction trait.
 *
 * @author Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Provider\Actions;

use App\Controller\Admin\Index;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\DomCrawler\Crawler;
use App\Tests\Provider\Selector\Admin\UtilsAdminSelector;

/**
 * Used to provide navigation methods for tests.
 */
trait NavigationAction
{
    public function navigateLeftMenu(Crawler $crawler, string $crudController): ?string
    {
        $siteLink = null;
        $crawler
            ->filter(UtilsAdminSelector::LEFT_MENU_LINKS_SELECTOR)
            ->each(function ($node) use (&$siteLink, $crudController) {
                if (str_contains($node->attr('href'), $crudController)) {
                    $siteLink = $node->attr('href');
                }
            });

        return $siteLink;
    }

    public function navigateLeftMenuLink(Client $client, string $fullClassName): Crawler
    {
        $crawler = $client->request('GET', Index::ADMIN_HOME_PAGE_URI);
        $itemLink = $this->navigateLeftMenu($crawler, UtilsAdminSelector::getShortClassName($fullClassName));

        return $client->request('GET', $itemLink);
    }

    public function navigateToActionPage(Client $client, string $fullClassName, int $entityId): Crawler
    {
        $crawler = $this->navigateLeftMenuLink($client, $fullClassName);
        $crawler = UtilsAdminSelector::findRowInDatagrid($crawler, $entityId);
        $this->clickElement($client, '#main > table > tbody > tr > td.actions.actions-as-dropdown > div > a');
        $this->clickElement($client, '#main > table > tbody > tr > td.actions.actions-as-dropdown > div > div > a');
        $this->client->refreshCrawler();

        return $this->client->getCrawler();
    }

    public function submitFormAndReturn(Client $client): Crawler
    {
        $this->clickElement($client, UtilsAdminSelector::SAVE_AND_RETURN_BUTTON_SELECTOR);
        $client->refreshCrawler();

        return $this->client->getCrawler();
    }

    public function clickElement(Client $client, string $elementCssSelector)
    {
        $client->executeScript(
            sprintf(
                "document.querySelector('%s').click()",
                $elementCssSelector
            )
        );
    }
}
