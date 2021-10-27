<?php

/**
 * File that defines the GridBlockTypeControllerTestFixture class.
 *
 * @author Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\BlockType;

use App\Tests\Provider\Data\BlockTypeProvider;
use App\Tests\Provider\Data\UserProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class used to provide fixtures for GridBlockTypeControllerTest class.
 */
class GridBlockTypeControllerTestFixture extends Fixture
{
    use BlockTypeProvider;

    use UserProvider;

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 2; $i++) {
            $blockType = $this->provideBlockType();
            $blockType->setType($blockType->getType() . '_' . $i);
            $manager->persist($blockType);
            $manager->flush();
            $this->referenceRepository->addReference('block_type_' . $i, $blockType);
        }

        $user = $this->provideSuperAdminUser();
        $manager->persist($user);
        $manager->flush();
        $this->referenceRepository->addReference('user', $user);
    }
}
