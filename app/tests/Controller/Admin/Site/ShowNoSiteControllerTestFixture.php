<?php

/**
 * File that defines the show no site controller test fixture.
 * This class is used to load data in the ShowNoSiteControllerTest class.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\Site;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ShowNoSiteControllerTestFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('dades@dades.fr')
            ->setPassword('dades')
            ->setRoles(['ROLE_SUPER_ADMIN'])
            ->setEnabled(true)
            ->setUsername('dades');

        $manager->persist($user);
        $manager->flush();

        $this->referenceRepository->addReference('user', $user);
    }
}
