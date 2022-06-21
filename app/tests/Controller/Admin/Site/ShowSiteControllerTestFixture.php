<?php

/**
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin\Site;

use App\Entity\User;
use Dades\CmsBundle\Entity\Site;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ShowSiteControllerTestFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('dades');
        $user->setEmail('dades@dades.fr');
        $user->setPassword('dades');
        $user->setEnabled(true);
        $user->setSuperAdmin(true);

        $manager->persist($user);

        $site = new Site();
        $site->setTitle('Symfony CMS 2');
        $manager->persist($site);

        $manager->flush();

        $this->referenceRepository->addReference('user', $user);
        $this->referenceRepository->addReference('site', $site);
    }
}
