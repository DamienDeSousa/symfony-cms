<?php

/**
 * File that defines the GridPageTemplateTestFixture class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use Doctrine\Persistence\ObjectManager;
use App\Tests\Provider\Data\UserProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Tests\Provider\Data\PageTemplateProvider;

/**
 * This class is used to load fixtures for the GridPageTemplateTest class.
 */
class GridPageTemplateTestFixture extends Fixture
{
    use PageTemplateProvider;

    use UserProvider;

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 2; $i++) {
            $pageTemplate = $this->providePageTemplate();
            $pageTemplate->setName($pageTemplate->getName() . '_' . $i);
            $pageTemplate->setLayout($pageTemplate->getLayout() . '_' . $i);
            $manager->persist($pageTemplate);
            $manager->flush();
            $this->referenceRepository->addReference('page_template_' . $i, $pageTemplate);
        }

        $user = $this->provideSuperAdminUser();
        $manager->persist($user);
        $manager->flush();
        $this->referenceRepository->addReference('user', $user);
    }
}
