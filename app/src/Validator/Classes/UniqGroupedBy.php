<?php

/**
 * File that define the UniqGroupedBy constraint class.
 */

declare(strict_types=1);

namespace App\Validator\Classes;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqGroupedBy extends Constraint
{
    /** @var string */
    public $message = 'Value of fields %s are not uniq grouped by %s.';

    /** @var array */
    public $attributesGroupedBy = [];

    /** @var array */
    public $uniqAttributes = [];

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
