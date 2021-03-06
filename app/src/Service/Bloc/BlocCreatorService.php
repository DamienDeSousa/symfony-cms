<?php

/**
 * File that defines the Bloc creator service class. This class is used to create a bloc.
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

class BlocCreatorService
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

    public function create(string $name, string $layout): ?Bloc
    {
        $blocs = $this->blocRepository->findByName($name);
        $bloc = null;

        if (!$blocs) {
            $bloc = new Bloc();
            $bloc->setName($name);
            $bloc->setLayout($layout);
            $this->entityManager->persist($bloc);
            $this->entityManager->flush();
        }

        if ($blocs) {
            $this->logger->warning('Bloc entity ["' . $name . '"] already exists, must be unique');
        }

        return $bloc;
    }
}
