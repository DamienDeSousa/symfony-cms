<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DisplayHomePageTestFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('dades@dades.fr')
            ->setPassword('dades')
            ->setRoles(['ROLE_SUPER_ADMIN'])
            ->setUsername('dades');

        $manager->persist($user);
        $manager->flush();

        $this->referenceRepository->addReference('user', $user);
    }
}
