<?php

/**
 * File that defines the Admin url provider trait.
 * This trait provides admin url for tests.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Provider\Url;

trait AdminUrlProvider
{
    public function provideAdminBaseUrl(): string
    {
        return getenv('CUSTOM_PANTHER_BASE_URL');
    }
}
