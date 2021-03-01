<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin\Security;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class LoginCheckTestFixture extends Fixture
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
