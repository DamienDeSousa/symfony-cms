<?php

/**
 * File that defines the Bloc reader service class. This class is used to read a bloc.
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

class BlocReaderService
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
        BlocRepository $blocRepository,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger
    ) {
        $this->blocRepository = $blocRepository;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function read($name): ?Bloc
    {
        $bloc = $this->blocRepository->findOneByName($name);

        if (!$bloc) {
            $this->logger->warning('Bloc entity ["' . $name . '"] does not exists and could not be found.');
        }

        return $bloc;
    }
}
