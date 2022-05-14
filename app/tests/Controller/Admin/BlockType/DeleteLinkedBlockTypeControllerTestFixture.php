<?php

/**
 * File that defines the DeleteLinkedBlockTypeControllerTestFixture class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2022
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\BlockType;

use Doctrine\Persistence\ObjectManager;
use App\Tests\Provider\Data\UserProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Tests\Provider\Data\BlockTypeProvider;
use App\Tests\Provider\Data\PageTemplateProvider;
use App\Tests\Provider\Data\PageTemplateBlockTypeProvider;

/**
 * This class is used to load fixtures for the DeleteLinkedBlockTypeControllerTest class.
 */
class DeleteLinkedBlockTypeControllerTestFixture extends Fixture
{
    use BlockTypeProvider;

    use UserProvider;

    use PageTemplateProvider;

    use PageTemplateBlockTypeProvider;

    public function load(ObjectManager $manager)
    {
        $user = $this->provideSuperAdminUser();
        $manager->persist($user);
        $pageTemplateBlockType = $this->providePageTemplateBlockType();
        $linkedBlockType = $this->provideBlockType();
        $linkedBlockType->setType('linked-block-type');
        $linkedBlockType->addPageTemplateBlockType($pageTemplateBlockType);
        $pageTemplate = $this->providePageTemplate();
        $pageTemplate->addPageTemplateBlockType($pageTemplateBlockType);
        $pageTemplateBlockType->setPageTemplate($pageTemplate);
        $pageTemplateBlockType->setBlockType($linkedBlockType);
        $manager->persist($linkedBlockType);
        $manager->persist($pageTemplate);
        $manager->persist($pageTemplateBlockType);
        $manager->flush();
        $this->referenceRepository->addReference('user', $user);
        $this->referenceRepository->addReference('linked_block_type', $linkedBlockType);
    }
}
