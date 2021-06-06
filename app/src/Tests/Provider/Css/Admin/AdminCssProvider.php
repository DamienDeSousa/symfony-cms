<?php

/**
 * File that defines the Admin css provider trait.
 * This trait is used to provide admin css selectors for tests.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Provider\Css\Admin;

trait AdminCssProvider
{
    public function provideUsernameLoginId(): string
    {
        return '#username';
    }

    public function providePasswdLoginId(): string
    {
        return '#password';
    }

    public function provideSubmitLoginName(): string
    {
        return '_submit';
    }

    public function provideUsernameLoginName(): string
    {
        return '_username';
    }

    public function providePasswdLoginName(): string
    {
        return '_password';
    }

    public function provideErrorMsgClass(): string
    {
        return '.text-danger';
    }
}
