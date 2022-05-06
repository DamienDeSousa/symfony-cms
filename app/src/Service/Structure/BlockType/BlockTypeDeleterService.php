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
use App\Exception\Entity\DeleteEntityException;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * This class is used to delete block type entity.
 */
class BlockTypeDeleterService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var TranslatorInterface */
    private $translator;

    public function __construct(EntityManagerInterface $entityManager, TranslatorInterface $translator)
    {
        $this->entityManager = $entityManager;
        $this->translator = $translator;
    }

    /**
     * @param BlockType $blockType
     *
     * @return void
     *
     * @throws DeleteEntityException
     */
    public function delete(BlockType $blockType): void
    {
            $this->entityManager->remove($blockType);
            $this->entityManager->flush();
    }
}
