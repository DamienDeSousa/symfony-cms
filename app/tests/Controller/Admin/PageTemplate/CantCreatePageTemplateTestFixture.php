<?php

/**
 * File that defines the CantCreatePageTemplateTestFixture class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\PageTemplate;

use Doctrine\Persistence\ObjectManager;
use App\Tests\Provider\Data\UserProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Tests\Provider\Data\PageTemplateProvider;

/**
 * This class is used to load fixture before running CantCreatePageTemplateTest tests.
 */
class CantCreatePageTemplateTestFixture extends Fixture
{
    use UserProvider;

    use PageTemplateProvider;

    public function load(ObjectManager $manager)
    {
        $user = $this->provideSuperAdminUser();
        $pageTemplate = $this->providePageTemplate();

        $manager->persist($user);
        $manager->persist($pageTemplate);
        $manager->flush();
        $this->referenceRepository->addReference('user', $user);
        $this->referenceRepository->addReference('page_template', $pageTemplate);
    }
}
