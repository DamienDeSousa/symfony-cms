<?php

/**
 * File that defines the login check fixture class.
 * This class is used to load a user for the login check test.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\Security;

use Doctrine\Persistence\ObjectManager;
use App\Tests\Provider\Data\UserProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;

class LoginCheckTestFixture extends Fixture
{
    use UserProvider;

    public function load(ObjectManager $manager)
    {
        $user = $this->provideSuperAdminUser();

        $manager->persist($user);
        $manager->flush();

        $this->referenceRepository->addReference('user', $user);
    }
}
