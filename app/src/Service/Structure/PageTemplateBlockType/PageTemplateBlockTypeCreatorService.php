<?php

/**
 * File that defines the PageTemplateBlockTypeCreatorService class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2022
 */

declare(strict_types=1);

namespace App\Service\Structure\PageTemplateBlockType;

use App\Entity\Structure\BlockType;
use App\Entity\Structure\PageTemplate;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Structure\PageTemplateBlockType;

/**
 * Class used to create and save PageTemplateBlockType.
 */
class PageTemplateBlockTypeCreatorService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(
        string $slug = '',
        ?PageTemplate $pageTemplate = null,
        ?BlockType $blockType = null
    ): PageTemplateBlockType {
        $pageTemplateBlockType = new PageTemplateBlockType();
        $pageTemplateBlockType->setSlug($slug)
            ->setPageTemplate($pageTemplate)
            ->setBlockType($blockType);

        if ($pageTemplate) {
            $pageTemplate->addPageTemplateBlockType($pageTemplateBlockType);
        }

        if ($blockType) {
            $blockType->addPageTemplateBlockType($pageTemplateBlockType);
        }

        return $pageTemplateBlockType;
    }

    public function save(PageTemplateBlockType $pageTemplateBlockType): void
    {
        $this->entityManager->persist($pageTemplateBlockType);
        $this->entityManager->flush();
    }
}
