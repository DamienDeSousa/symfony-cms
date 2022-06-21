<?php

/**
 * File that defines the DeleteLinkedPageTemplateTestFixture class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use Dades\TestUtils\Provider\Data\BlockTypeProvider;
use Dades\TestUtils\Provider\Data\PageTemplateBlockTypeProvider;
use Dades\TestUtils\Provider\Data\PageTemplateProvider;
use Dades\TestUtils\Provider\Data\UserProvider;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 * This class is used to load fixtures for the UpdatePageTemplateTest class.
 */
class DeleteLinkedPageTemplateTestFixture extends Fixture
{
    use PageTemplateProvider;

    use UserProvider;

    use BlockTypeProvider;

    use PageTemplateBlockTypeProvider;

    public function load(ObjectManager $manager)
    {
        $user = $this->provideSuperAdminUser();
        $pageTemplate = $this->providePageTemplate();
        $blockType = $this->provideBlockType();
        $pageTemplateBlockType = $this->providePageTemplateBlockType();

        $pageTemplateBlockType
            ->setPageTemplate($pageTemplate)
            ->setBlockType($blockType);

        $manager->persist($user);
        $manager->persist($pageTemplate);
        $manager->persist($blockType);
        $manager->persist($pageTemplateBlockType);

        $manager->flush();

        $this->referenceRepository->addReference('user', $user);
        $this->referenceRepository->addReference('page_template', $pageTemplate);
        $this->referenceRepository->addReference('block_type', $blockType);
        $this->referenceRepository->addReference('page_template_block_type', $pageTemplateBlockType);
    }
}
