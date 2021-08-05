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
use App\Controller\Admin\Security\Login;
use App\Controller\Admin\Site\ShowSiteController;
use App\Controller\Admin\Site\UpdateSiteController;

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
}
