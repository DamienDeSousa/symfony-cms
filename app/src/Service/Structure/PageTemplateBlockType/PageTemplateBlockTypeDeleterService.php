<?php

/**
 * File that defines the PageTemplateBlockTypeDeleterService class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2022 Damien DE SOUSA
 */

namespace App\Service\Structure\PageTemplateBlockType;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Structure\PageTemplateBlockType;

/**
 * This class is used to delete page template block type entity.
 */
class PageTemplateBlockTypeDeleterService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function delete(PageTemplateBlockType $pageTemplateBlockType): void
    {
        $this->entityManager->remove($pageTemplateBlockType);
        $this->entityManager->flush();
    }
}
