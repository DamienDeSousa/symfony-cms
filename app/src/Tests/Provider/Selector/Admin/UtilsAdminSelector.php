<?php

/**
 * Defines the UtilsAdminSelector class.
 *
 * @author Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Provider\Selector\Admin;

use ReflectionClass;
use Symfony\Component\Panther\DomCrawler\Crawler;

/**
 * Used to provide selectors for tests.
 */
abstract class UtilsAdminSelector
{
    public const USER_DETAIL_SELECTOR = 'a.user-details';

    public const USER_LOGOUT_LINK_SELECTOR = 'div.navbar-custom-menu > div > ul > li > a.user-action';

    public const LEFT_MENU_LINKS_SELECTOR = '#main-menu > ul > li > a';

    public const NO_DATAGRID_RESULT_SELECTOR = '#main > table > tbody > tr.no-results';

    public const DATAGRID_ROWS_SELECTOR = '#main > table > tbody > tr';

    public const SAVE_AND_RETURN_BUTTON_SELECTOR = 'button.action-saveAndReturn';

    public static function getShortClassName(string $fullClassName): string
    {
        $reflectionClass = new ReflectionClass($fullClassName);

        return $reflectionClass->getShortName();
    }

    public static function findRowInDatagrid(Crawler $crawler, int $id): ?Crawler
    {
        $searchNode = null;
        $crawler
            ->filter(UtilsAdminSelector::DATAGRID_ROWS_SELECTOR)
            ->each(function ($node) use (&$searchNode, $id) {
                if ($node->attr('data-id') == $id) {
                    $searchNode = $node;
                }
            });

        return $searchNode;
    }
}
