<?php

/**
 * File that defines the Display Title test fixtures. This class is used to load datas for the display title test.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\SmokeTest\MetaData;

use App\Entity\Site;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class DisplayTitleTestFixture extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEnabled(true)
            ->setPassword('dades')
            ->setRoles(['ROLE_SUPER_ADMIN'])
            ->setUsername('dades')
            ->setEmail('dades@dades.fr');

        $site = new Site();
        $site->setTitle('Site Title');

        $manager->persist($user);
        $manager->persist($site);

        $manager->flush();

        $this->referenceRepository->addReference('user', $user);
        $this->referenceRepository->addReference('site', $site);
    }
}
