<?php

/**
 * File that defines the PageTemplateDeleterService class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Service\Structure\PageTemplate;

use App\Entity\Structure\PageTemplate;
use Doctrine\ORM\EntityManagerInterface;

/**
 * This class is used to delete page template entity.
 */
class PageTemplateDeleterService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function delete(PageTemplate $pageTemplate): void
    {
        $this->entityManager->remove($pageTemplate);
        $this->entityManager->flush();
    }
}
