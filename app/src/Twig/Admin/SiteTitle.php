<?php

/**
 * File that defines the Site title class.
 * This class defines the twig function which gets the title of the site.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Twig\Admin;

use App\Service\Site\SiteReaderService;
use Twig\Extension\RuntimeExtensionInterface;

class SiteTitle implements RuntimeExtensionInterface
{
    private const DEFAULT_TITLE = 'Symfony CMS';

    private SiteReaderService $siteReaderService;

    public function __construct(SiteReaderService $siteReaderService)
    {
        $this->siteReaderService = $siteReaderService;
    }

    public function getTitle(): string
    {
        $title = static::DEFAULT_TITLE;
        $site = $this->siteReaderService->read();
        if ($site && $site->getTitle()) {
            $title = $site->getTitle();
        }

        return $title;
    }
}
