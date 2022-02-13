<?php

/**
 * File defined the RepositoryTrait.
 *
 * @author    Damien DE SOUSA
 * @copyright 2022
 */

namespace App\Repository;

use Doctrine\ORM\QueryBuilder;

/**
 * Trait providing method to facilitate the builder of a query with the query builder.
 */
trait RepositoryTrait
{
    private function addOrWhere(
        QueryBuilder $queryBuilder,
        string $condition,
        string $parameter,
        string $parameterValue
    ): void {
        $queryBuilder->getDQLPart('where') === [] ?
            $queryBuilder->where($condition)
            : $queryBuilder->orWhere($condition);

        if (isset($parameter) && isset($parameterValue)) {
            $queryBuilder->setParameter($parameter, $parameterValue);
        }
    }

    private function addSelect(QueryBuilder $queryBuilder, string $alias, string $attribute): void
    {
        $fullAttributePath = $alias . '.' . $attribute;
        $queryBuilder->getDQLPart('select') === [] ?
            $queryBuilder->select($fullAttributePath)
            : $queryBuilder->addSelect($fullAttributePath);
    }

    private function addGroupBy(QueryBuilder $queryBuilder, string $alias, string $attribute): void
    {
        $fullAttributePath = $alias . '.' . $attribute;
        $queryBuilder->getDQLPart('groupBy') === [] ?
            $queryBuilder->groupBy($fullAttributePath)
            : $queryBuilder->addGroupBy($fullAttributePath);
    }
}
