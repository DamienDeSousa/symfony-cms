<?php

/**
 * File that defines the Admin uri provider trait.
 * This trait provides admin uri for tests.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Provider\Uri;

use App\Controller\Admin\Index;
use App\Controller\Admin\BlockType\CreateBlockTypeController;
use App\Controller\Admin\BlockType\GridBlockTypeController;
use App\Controller\Admin\BlockType\UpdateBlockTypeController;
use App\Controller\Admin\PageTemplate\CreatePageTemplateController;
use App\Controller\Admin\PageTemplate\GridPageTemplateController;
use App\Controller\Admin\PageTemplate\ShowPageTemplateController;
use App\Controller\Admin\PageTemplateBlockType\CreatePageTemplateBlockTypeController;
use App\Controller\Admin\PageTemplateBlockType\GridPageTemplateBlockTypeController;
use App\Controller\Admin\Security\Login;
use App\Controller\Admin\Site\ShowSiteController;
use App\Controller\Admin\Site\UpdateSiteController;

/**
 * Trait that provides uri for tests.
 */
trait AdminUriProvider
{
    public function provideAdminLoginUri(): string
    {
        return Login::LOGIN_PAGE_URI;
    }

    public function provideAdminHomePageUri(): string
    {
        return Index::ADMIN_HOME_PAGE_URI;
    }

    public function provideAdminSiteShowUri(): string
    {
        return ShowSiteController::SITE_SHOW_URI;
    }

    public function provideAdminSiteUpdateUri(): string
    {
        return UpdateSiteController::SITE_UPDATE_URI;
    }

    public function provideAdminPageTemplateGridUri(): string
    {
        return GridPageTemplateController::GRID_PAGE_TEMPLATE_ROUTE_URI;
    }

    public function provideAdminPageTemplateCreateUri(): string
    {
        return CreatePageTemplateController::CREATE_PAGE_TEMPLATE_ROUTE_URI;
    }

    public function provideAdminPageTemplateShowUri(): string
    {
        return ShowPageTemplateController::SHOW_PAGE_TEMPLATE_ROUTE_URI;
    }

    public function provideAdminBlockTypeCreateUri(): string
    {
        return CreateBlockTypeController::CREATE_PAGE_TEMPLATE_ROUTE_URI;
    }

    public function provideAdminBlockTypeUpdateUri(): string
    {
        return UpdateBlockTypeController::UPDATE_BLOCK_TYPE_ROUTE_URI;
    }

    public function provideAdminGridBlockTypeGridUri(): string
    {
        return GridBlockTypeController::BLOCK_TYPE_ROUTE_URI;
    }

    public function provideAdminGridPageTemplateBlockTypeUri(): string
    {
        return GridPageTemplateBlockTypeController::GRID_PAGE_TEMPLATE_BLOCK_TYPE_ROUTE_URI;
    }

    public function provideAdminPageTemplateBlockTypeCreateUri(): string
    {
        return CreatePageTemplateBlockTypeController::CREATE_PAGE_TEMPLATE_BLOCK_TYPE_ROUTE_URI;
    }
}
