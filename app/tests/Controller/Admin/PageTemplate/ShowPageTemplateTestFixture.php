<?php

/**
 * File that defines the ShowPageTemplateTestFixture class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use Dades\TestUtils\Provider\Data\PageTemplateProvider;
use Dades\TestUtils\Provider\Data\UserProvider;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 * This class is used to load fixtures for the ShowPageTemplateTest class.
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
