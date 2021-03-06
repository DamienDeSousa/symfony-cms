<?php

/**
 * File that defines the Bloc updater service class. This class is used to update a bloc.
 * Bloc must be unique.
 *
 * @author    Adrian SALAS <adrian.salas84@gmail.com>
 * @copyright 2021 Adrian SALAS
 */
declare(strict_types=1);

namespace App\Service\Bloc;

use App\Entity\Bloc;
use App\Repository\BlocRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class BlocUpdaterService
{
    /**
     * @var BlocRepository
     */
    private $blocRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        LoggerInterface $logger,
        BlocRepository $blocRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->blocRepository = $blocRepository;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function update(int $identifier, string $name, string $layout): ?Bloc
    {
        $bloc = $this->blocRepository->findOneById($identifier);

        $bloc->setName($name);
        $bloc->setLayout($layout);
        $this->entityManager->persist($bloc);
        $this->entityManager->flush();

        return $bloc;
    }
}
