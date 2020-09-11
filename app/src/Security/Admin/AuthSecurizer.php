<?php

/**
 * Define the authorization securizer class.
 *
 * @author    Damien DE SOUSA <email@email.com>
 * @copyright 2020 Damien DE SOUSA
 */

namespace App\Security\Admin;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

/**
 * Verify user role.
 */
class AuthSecurizer
{
    /**
     * Access decision manager.
     *
     * @var AccessDecisionManagerInterface
     */
    protected $accessDecisionManager;

    /**
     * Constructor.
     *
     * @param AccessDecisionManagerInterface $accessDecisionManager
     */
    public function __construct(AccessDecisionManagerInterface $accessDecisionManager)
    {
        $this->accessDecisionManager = $accessDecisionManager;
    }

    /**
     * Check if the given user has equal or better role that given.
     *
     * @param User $user
     * @param string $attribute
     * @param null $object
     *
     * @return boolean
     */
    public function isGranted(User $user, string $attribute, $object = null)
    {
        $token = new UsernamePasswordToken($user, 'none', 'none', $user->getRoles());

        return ($this->accessDecisionManager->decide($token, [$attribute], $object));
    }
}
