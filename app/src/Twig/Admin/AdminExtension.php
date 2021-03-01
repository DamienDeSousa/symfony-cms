<?php

/**
 * Define the Twig admin extensions.
 *
 * @author    Damien DE SOUSA <email@email.com>
 * @copyright 2020 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Twig\Admin;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class AdminExtension extends AbstractExtension
{
    /**
     * @inheritDoc
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('sidebar_sections', [SidebarSection::class, 'getSections']),
            new TwigFunction('get_title', [SiteTitle::class, 'getTitle']),
        ];
    }
}
