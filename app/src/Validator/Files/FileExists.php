<?php

/**
 * File that define the FileExists constraint class.
 */

declare(strict_types=1);

namespace App\Validator\Files;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class FileExists extends Constraint
{
    public string $message = 'file_exists';

    public string $file;

    public function getTargets()
    {
        return self::PROPERTY_CONSTRAINT;
    }
}
