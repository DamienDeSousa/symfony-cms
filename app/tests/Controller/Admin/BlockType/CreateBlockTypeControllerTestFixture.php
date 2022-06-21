<?php

/**
 * File that defines the CreateBlockTypeControllerTestFixture class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\BlockType;

use Dades\TestUtils\Provider\Data\UserProvider;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 * This file is used to load fixtures before running CreateBlockTypeControllerTest tests.
 */
class CreateBlockTypeControllerTestFixture extends Fixture
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
