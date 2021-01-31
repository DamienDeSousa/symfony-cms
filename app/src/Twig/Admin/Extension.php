<?php

/**
 * Define the Twig admin extensions.
 *
 * @author    Damien DE SOUSA <email@email.com>
 * @copyright 2020 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Twig\Admin;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

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
