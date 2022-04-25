<?php

/**
 * File that defines the ShowPageTemplateBlockTypeTestFixture fixture class.
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
 * Class that provides fixtures for ShowPageTemplateBlockTypeTest.
 */
class ShowPageTemplateBlockTypeTestFixture extends Fixture
{
    use PageTemplateProvider;

    use UserProvider;

    use BlockTypeProvider;

    use PageTemplateBlockTypeProvider;

    public function load(ObjectManager $manager)
    {
        $pageTemplate = $this->providePageTemplate();
        $blockType = $this->provideBlockType();
        $pageTemplateBlockType = $this->providePageTemplateBlockType();
        $pageTemplateBlockType->setBlockType($blockType);
        $pageTemplateBlockType->setPageTemplate($pageTemplate);
        $pageTemplate->addPageTemplateBlockType($pageTemplateBlockType);
        $blockType->addPageTemplateBlockType($pageTemplateBlockType);
        $user = $this->provideSuperAdminUser();

        $manager->persist($user);
        $manager->persist($pageTemplate);
        $manager->persist($blockType);
        $manager->persist($pageTemplateBlockType);
        $manager->flush();

        $this->referenceRepository->addReference('page_template', $pageTemplate);
        $this->referenceRepository->addReference('block_type', $blockType);
        $this->referenceRepository->addReference('page_template_block_type', $pageTemplateBlockType);
        $this->referenceRepository->addReference('user', $user);
    }
}
