<?php

/**
 * File that defines the Show no site controller test. This class is used to test the page when a site is not created.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\Site;

use Dades\EasyAdminExtensionBundle\Controller\Admin\Site\SiteCRUDController;
use Dades\TestUtils\LoginPantherTestCase;
use Dades\TestUtils\Provider\AssertMessageProvider;
use Dades\TestUtils\Provider\Selector\Admin\UtilsAdminSelector;

class ShowNoSiteControllerTest extends LoginPantherTestCase
{
    public function testDisplayNoSitePage()
    {
        $crawler = $this->navigateLeftMenuLink($this->client, SiteCRUDController::class);
        $emptyResult = $crawler->filter(UtilsAdminSelector::NO_DATAGRID_RESULT_SELECTOR)->count();

        $this->assertEquals(
            AssertMessageProvider::COUNT_EXPECTED_NO_RESULT_MESSAGE,
            $emptyResult,
            AssertMessageProvider::EXPECTED_NO_RESULT_ERROR_MESSAGE
        );
    }
}
