<?php

/**
 * File that defines the show site controller test.
 * This class is used to the page when a site is created.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\Site;

use App\Controller\Admin\Site\SiteCRUDController;
use App\Entity\Site;
use App\Tests\LoginPantherTestCase;
use App\Tests\Provider\AssertMessageProvider;
use App\Tests\Provider\Selector\Admin\UtilsAdminSelector;

class ShowSiteControllerTest extends LoginPantherTestCase
{
    public function testDisplaySitePage()
    {
        /** @var Site $site */
        $site = $this->fixtureRepository->getReference('site');
        $crawler = $this->navigateLeftMenuLink($this->client, SiteCRUDController::class);
        $node = UtilsAdminSelector::findRowInDatagrid($crawler, $site->getId());

        $this->assertEquals(
            $site->getId(),
            $node->attr(UtilsAdminSelector::DATA_ID_ATTR_TAG_SELECTOR),
            sprintf(
                AssertMessageProvider::EXPECTED_ROW_ENTITY_ID_ERROR_MESSAGE,
                $site->getId(),
                $node->attr(UtilsAdminSelector::DATA_ID_ATTR_TAG_SELECTOR)
            )
        );
    }
}
