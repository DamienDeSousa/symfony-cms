<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin\Security;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LoginCheckTestFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('test@dades.fr')
            ->setPassword('test')
            ->setRoles(['ROLE_SUPER_ADMIN'])
            ->setUsername('test');

        $manager->persist($user);
        $manager->flush();

        $this->referenceRepository->addReference('user', $user);
    }
}
