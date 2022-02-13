<?php

/**
 * File that defines the GroupedByRepositoryInterface interface.
 *
 * @author    Damien DE SOUSA
 * @copyright 2022
 */

declare(strict_types=1);

namespace App\Repository;

/**
 * Interface wich declares a findGroupedBy method for repositories.
 */
interface GroupedByRepositoryInterface
{
    public function findGroupedBy(array $criteria, array $groupedByCriteria): array;
}
