<?php

/**
 * File that defines the Display Title test fixtures. This class is used to load datas for the display title test.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\SmokeTest\MetaData;

use App\Tests\Provider\Data\SiteProvider;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Tests\Provider\Data\UserProvider;

class DisplayTitleTestFixture extends Fixture
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
