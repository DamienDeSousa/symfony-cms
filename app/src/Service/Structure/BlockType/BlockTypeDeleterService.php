<?php

/**
 * File that defines the BlockTypeDeleterService class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Service\Structure\BlockType;

use App\Entity\Structure\BlockType;
use Doctrine\ORM\EntityManagerInterface;

/**
 * This class is used to delete block type entity.
 */
class BlockTypeDeleterService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function delete(BlockType $blockType): void
    {
        $this->entityManager->remove($blockType);
        $this->entityManager->flush();
    }
}
