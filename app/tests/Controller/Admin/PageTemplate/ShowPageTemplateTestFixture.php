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
class ShowPageTemplateTestFixture extends Fixture
{
    use PageTemplateProvider;

    use UserProvider;

    public function load(ObjectManager $manager)
    {
        $pageTemplate = $this->providePageTemplate();
        $manager->persist($pageTemplate);
        $user = $this->provideSuperAdminUser();
        $manager->persist($user);
        $manager->flush();
        $this->referenceRepository->addReference('user', $user);
        $this->referenceRepository->addReference('page_template', $pageTemplate);
    }
}
