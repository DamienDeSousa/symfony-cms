<?php

/**
 * File that defines the Site title class.
 * This class defines the twig function which gets the icon of the site.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Twig\Admin;

use App\Service\Site\SiteReaderService;
use Twig\Extension\RuntimeExtensionInterface;

class SiteIcon implements RuntimeExtensionInterface
{
    public function __construct(private SiteReaderService $siteReaderService, private string $iconDirectory)
    {
    }

    public function getIcon(): ?string
    {
        $path = null;
        $icon = null;
        $site = $this->siteReaderService->read();
        if ($site && $site->getIcon()) {
            $icon = $site->getIcon();
            $path = $this->iconDirectory . $icon;
        }

        return $path;
    }
}
