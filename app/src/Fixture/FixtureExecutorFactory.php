<?php

/**
 * File that define the Fixture Executor factory trait.
 * This trait is used to execute the fixtures.
 *
 * @author Damien DE SOUSA <dades@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Fixture;

use Doctrine\Common\DataFixtures\Executor\AbstractExecutor;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;

class FixtureExecutorFactory
{
    public static function createManagerExecutor(EntityManagerInterface $manager): AbstractExecutor
    {
        return new ORMExecutor($manager, new ORMPurger($manager));
    }
}
