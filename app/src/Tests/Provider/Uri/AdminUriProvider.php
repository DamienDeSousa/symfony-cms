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

    public function provideAdminGridPageTemplateBlockTypeUri(): string
    {
        return GridPageTemplateBlockTypeController::GRID_PAGE_TEMPLATE_BLOCK_TYPE_ROUTE_URI;
    }

    public function provideAdminPageTemplateBlockTypeCreateUri(): string
    {
        return CreatePageTemplateBlockTypeController::CREATE_PAGE_TEMPLATE_BLOCK_TYPE_ROUTE_URI;
    }
}
