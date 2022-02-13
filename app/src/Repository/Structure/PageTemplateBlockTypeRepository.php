<?php

/**
 * File that defines the PageTemplateBlockTypeRepository class.
 *
 * @author Damien DE SOUSA
 * @copyright 2021
 */

namespace App\Repository\Structure;

use Doctrine\ORM\QueryBuilder;
use App\Entity\Structure\BlockType;
use App\Repository\RepositoryTrait;
use App\Entity\Structure\PageTemplate;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Structure\PageTemplateBlockType;
use App\Repository\GroupedByRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * Class used to request PageTemplateBlockType entity.
 *
 * @method PageTemplateBlockType|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageTemplateBlockType|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageTemplateBlockType[]    findAll()
 * @method PageTemplateBlockType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageTemplateBlockTypeRepository extends ServiceEntityRepository implements GroupedByRepositoryInterface
{
    use RepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageTemplateBlockType::class);
    }

    public function findGroupedBy(array $criteria, array $groupedByCriteria): array
    {
        $queryBuilder = $this->_em->createQueryBuilder()->from($this->_entityName, 'ptbt');

        if ($groupedByCriteria && !empty($groupedByCriteria)) {
            $this->fillGroupBySelect($groupedByCriteria, $queryBuilder);
        }

        /**
         * TODO:
         * manage the case if criteria contains objects
         */
        if ($criteria && !empty($criteria)) {
            foreach ($criteria as $attribute => $value) {
                $this->addOrWhere($queryBuilder, 'ptbt.' . $attribute . '= :' . $attribute, $attribute, $value);
            }
        }
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    private function fillGroupBySelect(array $groupedByCriteria, QueryBuilder $queryBuilder): void
    {
        foreach ($groupedByCriteria as $groupedByAttribute => $groupedByValue) {
            $addSelectAlias = 'ptbt';
            $selectGroupedByAttribute = $groupedByAttribute;
            if ($groupedByValue instanceof PageTemplate) {
                $queryBuilder->join('ptbt.' . $groupedByAttribute, 'pt');
                $addSelectAlias = 'pt';
                $selectGroupedByAttribute = 'id';
            } elseif ($groupedByValue instanceof BlockType) {
                $queryBuilder->join('ptbt.' . $groupedByAttribute, 'bt');
                $addSelectAlias = 'bt';
                $selectGroupedByAttribute = 'id';
            }
            $this->addSelect($queryBuilder, $addSelectAlias, $selectGroupedByAttribute);
            $this->addGroupBy($queryBuilder, 'ptbt', $groupedByAttribute);
        }
    }
}
