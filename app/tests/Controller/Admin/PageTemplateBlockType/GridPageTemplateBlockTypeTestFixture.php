<?php

/**
 * File that defines the GridPageTemplateBlockTypeTestFixture class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2022
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
 * This class is used to load fixtures for the GridPageTemplateBlockTypeTest class.
 */
class GridPageTemplateBlockTypeTestFixture extends Fixture
{
    use PageTemplateProvider;

    use UserProvider;

    use BlockTypeProvider;

    use PageTemplateBlockTypeProvider;

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 2; $i++) {
            $pageTemplate = $this->providePageTemplate();
            $pageTemplate->setName($pageTemplate->getName() . '_' . $i);
            $pageTemplate->setLayout($pageTemplate->getLayout() . '_' . $i);

            $blockType = $this->provideBlockType();

            $pageTemplateBlockType = $this->providePageTemplateBlockType();
            $pageTemplateBlockType->setBlockType($blockType);
            $pageTemplateBlockType->setPageTemplate($pageTemplate);
            $pageTemplateBlockType->setSlug('slug_' . $i);

            $pageTemplate->addPageTemplateBlockType($pageTemplateBlockType);
            $blockType->addPageTemplateBlockType($pageTemplateBlockType);

            $manager->persist($pageTemplate);
            $manager->persist($blockType);
            $manager->persist($pageTemplateBlockType);
            $manager->flush();

            $this->referenceRepository->addReference('page_template_' . $i, $pageTemplate);
            $this->referenceRepository->addReference('block_type_' . $i, $blockType);
            $this->referenceRepository->addReference('page_template_block_type_' . $i, $pageTemplateBlockType);
        }

        $user = $this->provideSuperAdminUser();
        $manager->persist($user);
        $manager->flush();
        $this->referenceRepository->addReference('user', $user);
    }
}
