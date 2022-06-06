<?php

/**
 * Defines the CantUpdateBlockTypeTestFixture class.
 *
 * @author Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\BlockType;

use Doctrine\Persistence\ObjectManager;
use App\Tests\Provider\Data\UserProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Tests\Provider\Data\BlockTypeProvider;

/**
 * Provide data for CantUpdateBlockTypeTest tests.
 */
class CantUpdateBlockTypeTestFixture extends Fixture
{
    use BlockTypeProvider;

    use UserProvider;

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 2; $i++) {
            $blockType = $this->provideBlockType();
            $blockType->setType($blockType->getType() . '_' . $i);
            $blockType->setLayout($blockType->getLayout() . '_' . $i);
            $manager->persist($blockType);
            $manager->flush();
            $this->referenceRepository->addReference('block_type_' . $i, $blockType);
        }

        $superAdmin = $this->provideSuperAdminUser();
        $manager->persist($superAdmin);
        $manager->flush();
        $this->referenceRepository->addReference('user', $superAdmin);
    }
}
