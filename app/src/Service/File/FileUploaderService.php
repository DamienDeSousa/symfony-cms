<?php

/**
 * File that defines the File uploeader service class.
 *
 * @author    Damien DE SOUSA <desousadamien@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Service\File;

use LogicException;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Mime\Exception\LogicException as ExceptionLogicException;

/**
 * This class is used to to store an uploaded file on the server file system.
 */
class FileUploaderService
{
    /**
     * @param UploadedFile $uploadedFile
     * @param string       $destinationDirectory
     *
     * @return string
     *
     * @throws LogicException
     * @throws InvalidArgumentException
     * @throws ExceptionLogicException
     * @throws FileException
     */
    public function uploadFile(UploadedFile $uploadedFile, string $destinationDirectory): string
    {
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = transliterator_transliterate(
            'Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()',
            $originalFilename
        );
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
        $uploadedFile->move(
            $destinationDirectory,
            $newFilename
        );

        return $newFilename;
    }
}
