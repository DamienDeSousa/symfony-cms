<?php

/**
 * File that defines the Update site controller test fixture class.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\Site;

use Dades\TestUtils\Provider\Data\SiteProvider;
use Dades\TestUtils\Provider\Data\UserProvider;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 * This class is used to provide some fixture to the UpdateSiteControllerTest class.
 */
class UpdateSiteControllerTestFixture extends Fixture
{
    use UserProvider;

    use SiteProvider;

    public function load(ObjectManager $manager)
    {
        $user = $this->provideSuperAdminUser();
        $site = $this->provideSite();

        $manager->persist($user);
        $manager->persist($site);

        $manager->flush();

        $this->referenceRepository->addReference('user', $user);
        $this->referenceRepository->addReference('site', $site);
    }
}
