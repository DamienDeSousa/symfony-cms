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

use App\Entity\Site;
use App\Entity\User;
use App\Fixture\FixtureAttachedTrait;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Css\Admin\AdminSiteCssProvider;
use App\Tests\Provider\Uri\AdminUriProvider;
use Symfony\Component\Panther\PantherTestCase;

class ShowSiteControllerTest extends PantherTestCase
{
    use FixtureAttachedTrait;

    use AdminUriProvider;

    use LogAction;

    use AdminSiteCssProvider;

    public function testDisplaySitePage()
    {
        /** @var User $user */
        $user = $this->fixtureRepository->getReference('user');
        /** @var Site $site */
        $site = $this->fixtureRepository->getReference('site');

        $client = static::createPantherClient();
        $crawler = $this->login($user, $this->provideAdminLoginUri(), $client);
        $crawler = $client->request('GET', $this->provideAdminSiteShowUri());

        $this->assertSelectorTextSame($this->provideCardHeaderClass(), 'Informations');

        $crawler = $this->adminLogout($client, $crawler);
    }
}
