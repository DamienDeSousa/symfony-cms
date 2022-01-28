<?php

/**
 * File that defines the PageTemplateBlockTypeProvider class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2022
 */

declare(strict_types=1);

namespace App\Tests\Provider\Data;

use App\Entity\Structure\PageTemplateBlockType;

/**
 * Trait is used to provide page template block type entity for tests.
 */
trait PageTemplateBlockTypeProvider
{
    public function providePageTemplateBlockType(): PageTemplateBlockType
    {
        return new PageTemplateBlockType();
    }
}
