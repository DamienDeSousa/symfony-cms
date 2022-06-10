<?php

/**
 * File that defines the Site reader service class. This class is used to read a site.
 * Site must be unique.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Service\Site;

use App\Entity\Site;
use App\Repository\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class SiteReaderService
{
    private SiteRepository $siteRepository;

    public function __construct(SiteRepository $siteRepository)
    {
        $this->siteRepository = $siteRepository;
    }

    public function read(): ?Site
    {
        $uniqueSite = null;
        $sites = $this->siteRepository->findAll();
        foreach ($sites as $site) {
            $uniqueSite = $site;
            break;
        }

        return $uniqueSite;
    }
}
