<?php

/**
 * File that defines the DeleteLinkedPageTemplateTestFixture class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use Doctrine\Persistence\ObjectManager;
use App\Tests\Provider\Data\UserProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Tests\Provider\Data\BlockTypeProvider;
use App\Tests\Provider\Data\PageTemplateProvider;
use App\Tests\Provider\Data\PageTemplateBlockTypeProvider;

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
        $this->referenceRepository->addReference('pageTemplate', $pageTemplate);
        $this->referenceRepository->addReference('blockType', $blockType);
        $this->referenceRepository->addReference('pageTemplateBlockType', $pageTemplateBlockType);
    }
}
