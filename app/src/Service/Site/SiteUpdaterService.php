<?php

/**
 * This file defines the Site updater service.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Service\Site;

use Throwable;
use LogicException;
use App\Entity\Site;
use InvalidArgumentException;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\File\FileUploaderService;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Mime\Exception\LogicException as ExceptionLogicException;

/**
 * This class is used to update a site.
 */
class SiteUpdaterService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var Filesystem */
    private $filesystem;

    /** @var FileUploaderService */
    private $fileUploaderService;

    /** @var string */
    private $fullIconDirectoryPath;

    public function __construct(
        string $fullIconDirectoryPath,
        FileUploaderService $fileUploaderService,
        EntityManagerInterface $entityManager,
        Filesystem $filesystem
    ) {
        $this->fullIconDirectoryPath = $fullIconDirectoryPath;
        $this->fileUploaderService = $fileUploaderService;
        $this->entityManager = $entityManager;
        $this->filesystem = $filesystem;
    }

    /**
     * @param Site              $site
     * @param null|UploadedFile $uploadedFile
     *
     * @param string $title
     *
     * @return void
     *
     * @throws LogicException
     * @throws InvalidArgumentException
     * @throws ExceptionLogicException
     * @throws FileException
     * @throws Throwable
     * @throws IOException
     */
    public function updateSite(Site $site, ?UploadedFile $uploadedFile, string $title): void
    {
        $site->setTitle($title);
        if ($uploadedFile) {
            $newFilename = $this->fileUploaderService->uploadFile($uploadedFile, $this->fullIconDirectoryPath);
            $oldIconName = $site->getIcon();
            if (isset($oldIconName)) {
                $this->filesystem->remove($this->fullIconDirectoryPath . $oldIconName);
            }
            $site->setIcon($newFilename);
        }
        $this->entityManager->persist($site);
        $this->entityManager->flush();
    }
}
