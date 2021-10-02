<?php

/**
 * File that defines the CreatePageTemplateTestFixture class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use Doctrine\Persistence\ObjectManager;
use App\Tests\Provider\Data\UserProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 * This file is used to load fixtures before running CreatePageTemplateTest tests.
 */
class CreatePageTemplateTestFixture extends Fixture
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
