<?php

/**
 * Define the role user class.
 *
 * @author    Damien DE SOUSA <email@email.com>
 * @copyright 2020 Damien DE SOUSA
 */

namespace App\Security;

use FOS\UserBundle\Model\UserInterface;

/**
 * Display user roles.
 */
class UserRoles
{
    /**
     * Name of the admin role.
     */
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * Name of the super admin role.
     */
    public const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    /**
     * Defined user roles.
     *
     * @var array
     */
    protected $roles;

    /**
     * Constructor.
     *
     * @param array $roles
     */
    public function __construct(array $roles = [])
    {
        $this->roles = $roles;
        $this->roles[UserInterface::ROLE_DEFAULT] = [];
    }

    /**
     * Get user roles defined in the application.
     *
     * @return array
     */
    public function getDefinedRoles(): array
    {
        return $this->roles;
    }
}
