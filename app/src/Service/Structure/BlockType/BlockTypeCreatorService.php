<?php

/**
 * File that defines the BlockTypeCreatorService class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Service\Structure\BlockType;

use App\Entity\Structure\BlockType;
use Doctrine\ORM\EntityManagerInterface;

/**
 * This class is used to create and save block type entity.
 */
class BlockTypeCreatorService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(string $type = ''): BlockType
    {
        $blockType = new BlockType();
        $blockType->setType($type);

        return $blockType;
    }

    public function save(BlockType $blockType): void
    {
        $this->entityManager->persist($blockType);
        $this->entityManager->flush();
    }
}
