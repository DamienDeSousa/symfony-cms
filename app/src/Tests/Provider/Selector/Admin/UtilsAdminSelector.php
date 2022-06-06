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

    public const CREATE_BUTTON_SELECTOR = 'a.action-new';

    public const DELETE_ENTITY_BUTTON_SELECTOR = '#modal-delete-button';

    public const ENTITY_ACTIONS_DROPDOWN = '#main > table > tbody > tr > td.actions.actions-as-dropdown > div > a';

    public const ALERT_FORM_MESSAGE_SELECTOR = 'div.invalid-feedback';

    public const DATA_ID_ATTR_TAG_SELECTOR = 'data-id';


    // ----------------   Use it together   ---------------- //
    /**
     * First element is the kind of form (edit, new, ...).
     * Second element is the short entity class name.
     */
    public const ENTITY_FORM_SELECTOR = '#%s-%s-form';

    /**
     * Constant to use inside the ENTITY_FORM_SELECTOR constant.
     */
    public const ENTITY_FORM_EDIT = 'edit';

    /**
     * Constant to use inside the ENTITY_FORM_SELECTOR constant.
     */
    public const ENTITY_FORM_NEW = 'new';
    // ----------------------------------------------------- //


    // ----------------   Use it together   ---------------- //
    public const ENTITY_ACTION_DROPDOWN = '#main > table > tbody > tr > td.actions.actions-as-dropdown > div > a > %s';

    /**
     * Constant to use inside the ENTITY_ACTION_DROPDOWN constant.
     */
    public const DELETE_BUTTON_MODAL_SELECTOR = 'a.action-delete';

    /**
     * Constant to use inside the ENTITY_ACTION_DROPDOWN constant.
     */
    public const EDIT_BUTTON_REDIRECT_SELECTOR = 'a.action-edit';
    // ----------------------------------------------------- //

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
