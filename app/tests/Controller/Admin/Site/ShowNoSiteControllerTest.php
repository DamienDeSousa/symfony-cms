<?php

/**
 * File that defines the Show no site controller test. This class is used to test the page when a site is not created.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\Site;

use App\Fixture\FixtureAttachedTrait;
use App\Entity\User;
use App\Tests\Provider\Actions\LogAction;
use App\Tests\Provider\Uri\AdminUriProvider;
use Symfony\Component\Panther\PantherTestCase;

class ShowNoSiteControllerTest extends PantherTestCase
{
    use FixtureAttachedTrait;

    use AdminUriProvider;

    use LogAction;

    public function testDisplayNoSitePage()
    {
        /** @var User $user */
        $user = $this->fixtureRepository->getReference('user');
        $client = static::createPantherClient();
        $crawler = $this->login($user, $this->provideAdminLoginUri(), $client);
        $crawler = $client->request('GET', $this->provideAdminSiteShowUri());

        $this->assertSelectorTextSame('.card-title', 'Le site n\'existe pas !');

        $crawler = $this->adminLogout($client, $crawler);
    }
}
