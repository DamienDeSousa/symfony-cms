<?php

/**
 * File that defines the PageTemplateCreatorService class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Service\Structure\PageTemplate;

use App\Entity\Structure\PageTemplate;
use Doctrine\ORM\EntityManagerInterface;

/**
 * This class is used to create and save page template entity.
 */
class PageTemplateCreatorService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(string $name = '', string $layout = ''): PageTemplate
    {
        $pageTemplate = new PageTemplate();
        $pageTemplate->setName($name)
            ->setLayout($layout);

        return $pageTemplate;
    }

    public function save(PageTemplate $pageTemplate): void
    {
        $this->entityManager->persist($pageTemplate);
        $this->entityManager->flush();
    }
}
