<?php

/**
 * Define the admin login check.
 *
 * @author Damien DE SOUSa <email@email.com>
 * @copyright 2020 Damien DE SOUSA
 */

namespace App\Controller\Admin\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Login admin controller.
 *
 * Render the login admin page.
 *
 * @Route("/admin-login-check", name="admin_login_check")
 */
class LoginCheck extends AbstractController
{
    /**
     * Admin login check route name.
     */
    public const LOGIN_ROUTE = 'admin_login_check';

    /**
     * Admin login check.
     * @see config/packages/security.yaml
     *
     * @return void
     */
    public function __invoke()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }
}
