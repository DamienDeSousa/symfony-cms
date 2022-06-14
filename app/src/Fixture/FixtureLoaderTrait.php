<?php

/**
 * File that defines the Fixture loader trait.
 * This trait is used to load fixtures.
 *
 * @author Damien DE SOUSA <dades@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

namespace App\Fixture;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\ReferenceRepository;
use Doctrine\ORM\EntityManagerInterface;

trait FixtureLoaderTrait
{
    protected ReferenceRepository $fixtureRepository;

    private function loadFixture(EntityManagerInterface $manager, FixtureInterface ...$fixtures): void
    {
        $executor = FixtureExecutorFactory::createManagerExecutor($manager);
        $this->fixtureRepository = $executor->getReferenceRepository();

        $loader = new Loader();
        array_map([$loader, 'addFixture'], $fixtures);

        //The $append optional parameter permits to purge or append data in database.
        $executor->execute($loader->getFixtures());
    }
}
