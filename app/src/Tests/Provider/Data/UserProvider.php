<?php

/**
 * File that defines the user provider trait.
 * This trait is used to provide users for tests.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Provider\Data;

use App\Entity\User;

trait UserProvider
{
    public function provideSuperAdminUser(): User
    {
        $user = new User();
        $user->setUsername('dades');
        $user->setEmail('dades@dades.fr');
        $user->setPassword('dades');
        $user->setEnabled(true);
        $user->setSuperAdmin(true);

        return $user;
    }
}
