<?php

/**
 * File that defines the DeletePageTemplateBlockTypeTestFixture fixture class.
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplateBlockType;

use Doctrine\Persistence\ObjectManager;
use App\Tests\Provider\Data\UserProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Tests\Provider\Data\BlockTypeProvider;
use App\Tests\Provider\Data\PageTemplateProvider;
use App\Tests\Provider\Data\PageTemplateBlockTypeProvider;

/**
 * Class that provides fixtures for DeletePageTemplateBlockTypeTest.
 */
class DeletePageTemplateBlockTypeTestFixture extends Fixture
{
    use UserProvider;

    use PageTemplateProvider;

    use BlockTypeProvider;

    use PageTemplateBlockTypeProvider;

    public function load(ObjectManager $manager)
    {
        $user = $this->provideSuperAdminUser();
        $pageTemplate = $this->providePageTemplate();
        $pageTemplateBlockType = $this->providePageTemplateBlockType();
        $blockType = $this->provideBlockType();

        $pageTemplateBlockType->setBlockType($blockType)
            ->setPageTemplate($pageTemplate);
        $pageTemplate->addPageTemplateBlockType($pageTemplateBlockType);
        $blockType->addPageTemplateBlockType($pageTemplateBlockType);

        $manager->persist($user);
        $manager->persist($pageTemplate);
        $manager->persist($pageTemplateBlockType);
        $manager->persist($blockType);
        $manager->flush();

        $this->referenceRepository->addReference('user', $user);
        $this->referenceRepository->addReference('page_template_block_type', $pageTemplateBlockType);
    }
}
