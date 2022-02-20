<?php

/**
 * File that defines the PageTemplateRepository class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

 declare(strict_types=1);

namespace App\Repository\Structure;

use App\Entity\Structure\PageTemplate;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * This class is used to query page template entity.
 *
 * @method PageTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageTemplate[]    findAll()
 * @method PageTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageTemplate::class);
    }

    public function findAllBy(array $orderBy = null): array
    {
        $queryBuilder = $this->createQueryBuilder('pt');
        if ($orderBy && !empty($orderBy)) {
            foreach ($orderBy as $attribute => $order) {
                $queryBuilder->orderBy('pt.' . $attribute, $order);
            }
        }
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }
}
