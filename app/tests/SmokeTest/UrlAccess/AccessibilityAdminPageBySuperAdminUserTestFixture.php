<?php

/**
 * File that defines the GridPageTemplateTestFixture class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Tests\SmokeTest\UrlAccess;

use Doctrine\Persistence\ObjectManager;
use App\Tests\Provider\Data\SiteProvider;
use App\Tests\Provider\Data\UserProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 * This class is used to load fixtures for the GridPageTemplateTest class.
 */
class AccessibilityAdminPageBySuperAdminUserTestFixture extends Fixture
{
    use UserProvider;

    use SiteProvider;

    public function load(ObjectManager $manager)
    {
        $site = $this->provideSite();
        $user = $this->provideSuperAdminUser();
        $manager->persist($user);
        $manager->persist($site);
        $manager->flush();
        $this->referenceRepository->addReference('user', $user);
        $this->referenceRepository->addReference('site', $site);
    }
}
