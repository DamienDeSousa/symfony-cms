<?php

/**
 * File that defines the admin site css trait.
 * This trait is used to provide admin site css selectors to tests.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Provider\Css\Admin;

trait AdminSiteCssProvider
{
    public function provideCardTitleClass(): string
    {
        return '.card-title';
    }

    public function provideCardHeaderClass(): string
    {
        return '.card-header';
    }
}
