<?php

/**
 * File that defines the ShowBlockTypeTestFixture class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\BlockType;

use Dades\TestUtils\Provider\Data\BlockTypeProvider;
use Dades\TestUtils\Provider\Data\UserProvider;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 * This class is used to load fixtures for the ShowPageTemplateTest class.
 */
class ShowBlockTypeTestFixture extends Fixture
{
    use BlockTypeProvider;

    use UserProvider;

    public function load(ObjectManager $manager)
    {
        $blockType = $this->provideBlockType();
        $manager->persist($blockType);
        $user = $this->provideSuperAdminUser();
        $manager->persist($user);
        $manager->flush();
        $this->referenceRepository->addReference('user', $user);
        $this->referenceRepository->addReference('block_type', $blockType);
    }
}
