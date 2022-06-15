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
    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_title', [SiteTitle::class, 'getTitle']),
            new TwigFunction('get_icon', [SiteIcon::class, 'getIcon']),
        ];
    }
}
