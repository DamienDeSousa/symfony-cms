<?php

/**
 * File that defines the UpdatePageTemplateBlockTypeTestFixture fixture class.
 */

namespace App\Tests\Controller\Admin\PageTemplateBlockType;

use Doctrine\Persistence\ObjectManager;
use App\Tests\Provider\Data\UserProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Tests\Provider\Data\BlockTypeProvider;
use App\Tests\Provider\Data\PageTemplateProvider;
use App\Tests\Provider\Data\PageTemplateBlockTypeProvider;

/**
 * Class that provides fixtures for UpdatePageTemplateBlockTypeTest.
 */
class UpdatePageTemplateBlockTypeTestFixture extends Fixture
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

        $newPageTemplate = $this->providePageTemplate();
        $newPageTemplate->setName('New page template');
        $newPageTemplate->setLayout('new/path/to/twig/file.html.twig');
        $newBlockType = $this->provideBlockType();
        $newBlockType->setType('footer');
        $newBlockType->setLayout('path/to/footer/layout.html.twig');
        $newPageTemplateBlockType = $this->providePageTemplateBlockType()->setSlug('my_new_slug');
        $newPageTemplateBlockType->setBlockType($newBlockType);
        $newPageTemplateBlockType->setPageTemplate($newPageTemplate);

        $manager->persist($user);
        $manager->persist($pageTemplate);
        $manager->persist($blockType);
        $manager->persist($pageTemplateBlockType);
        $manager->persist($newPageTemplate);
        $manager->persist($newBlockType);
        $manager->persist($newPageTemplateBlockType);
        $manager->flush();

        $this->referenceRepository->addReference('page_template', $pageTemplate);
        $this->referenceRepository->addReference('block_type', $blockType);
        $this->referenceRepository->addReference('page_template_block_type', $pageTemplateBlockType);
        $this->referenceRepository->addReference('user', $user);
        $this->referenceRepository->addReference('new_page_template', $newPageTemplate);
        $this->referenceRepository->addReference('new_block_type', $newBlockType);
        $this->referenceRepository->addReference('new_page_template_block_type', $newPageTemplateBlockType);
    }
}
