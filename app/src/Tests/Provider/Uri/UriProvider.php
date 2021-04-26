<?php

/**
 * File that defines the uri provider trait.
 * This trait provides uri for tests.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Provider\Uri;

trait UriProvider
{
    public function provideHomePageUri(): string
    {
        return '/';
    }
}
