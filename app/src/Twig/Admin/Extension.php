<?php

/**
 * Define the Twig admin extensions.
 *
 * @author    Damien DE SOUSA <email@email.com>
 * @copyright 2020 Damien DE SOUSA
 */

namespace App\Twig\Admin;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Declare admin Twig extensions.
 */
class Extension extends AbstractExtension
{
    /**
     * @inheritDoc
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('sidebar_sections', [SidebarSection::class, 'getSections']),
        ];
    }
}