<?php

/**
 * Define the login admin controller.
 *
 * @author    Damien DE SOUSA <email@email.com>
 * @copyright 2020 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Controller\Admin\Security;

use App\Security\Admin\AuthError;
use App\Security\Admin\LastUsername;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Login admin controller.
 *
 * Render the login admin page.
 *
 * @Route("/admin-GC2NeDwu26y6pred", name="admin_login")
 */
class Login extends AbstractController
{
    /**
     * Admin login route name.
     */
    public const LOGIN_PAGE_ROUTE = 'admin_login';

    /**
     * Csrf token manager.
     *
     * @var CsrfTokenManagerInterface
     */
    protected $tokenManager;

    /**
     * @var AuthError
     */
    protected $authError;

    /**
     * @var LastUsername
     */
    protected $lastUsername;

    /**
     * Constructor.
     *
     * @param CsrfTokenManagerInterface $tokenManager
     * @param AuthError                 $authError
     * @param LastUsername              $lastUsername
     */
    public function __construct(
        CsrfTokenManagerInterface $tokenManager,
        AuthError $authError,
        LastUsername $lastUsername
    ) {
        $this->tokenManager = $tokenManager;
        $this->authError = $authError;
        $this->lastUsername = $lastUsername;
    }

    /**
     * Render the admin login page.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $error = $this->authError->getError($request);
        $lastUsername = $this->lastUsername->getLastUserName($request);
        $csrfToken = $this->tokenManager
            ? $this->tokenManager->getToken('authenticate')->getValue()
            : null;

        // $session->set('', '');
        // $session->get(''); // retourne null si non trouvé

        return $this->render('admin/security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
        ]);
    }
}
