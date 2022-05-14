<?php

/**
 * File that defines the unaccessible admin page test.
 * This class is used to test that non admin users can't access admin pages.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\SmokeTest\UrlAccess;

use App\Tests\Provider\Uri\AdminUriProvider;
use App\Tests\Provider\Url\AdminUrlProvider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UnaccessAdminPageTest extends WebTestCase
{
    use AdminUriProvider;

    use AdminUrlProvider;

    public function provideUrls()
    {
        return [
            [$this->provideAdminHomePageUri()],
            [$this->provideAdminSiteShowUri()],
            [$this->provideAdminPageTemplateGridUri()],
            [$this->provideAdminBlockTypeCreateUri()],
            [$this->provideAdminGridBlockTypeGridUri()],
            [$this->provideAdminGridPageTemplateBlockTypeUri()],
            [$this->provideAdminPageTemplateBlockTypeCreateUri()],
        ];
    }

    /**
     * @dataProvider provideUrls
     */
    public function testPageIsUnaccessible($url)
    {
        $client = static::createClient();
        $crawler = $client->request('GET', $url);

        $this->assertResponseStatusCodeSame(404);
    }
}
