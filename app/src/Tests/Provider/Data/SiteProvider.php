<?php

/**
 * File that defines the site provider trait.
 * This trait is used to provide sites for tests.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Provider\Data;

use App\Entity\Site;

trait SiteProvider
{
    public function provideSite(): Site
    {
        $site = new Site();
        $site->setTitle('Site Title');

        return $site;
    }
}
