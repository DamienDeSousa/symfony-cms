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
use App\Security\Admin\Login\Captcha;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Captcha\Bundle\CaptchaBundle\Integration\BotDetectCaptcha;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin-GC2NeDwu26y6pred", name="admin_login")
 */
class Login extends AbstractController
{
    public const LOGIN_PAGE_ROUTE = 'admin_login';

    public const LOGIN_PAGE_URI = '/admin-GC2NeDwu26y6pred';

    protected CsrfTokenManagerInterface $tokenManager;

    protected AuthError $authError;

    protected LastUsername $lastUsername;

    protected Captcha $captcha;

    private BotDetectCaptcha $botDetectCaptcha;

    public function __construct(
        CsrfTokenManagerInterface $tokenManager,
        AuthError $authError,
        LastUsername $lastUsername,
        Captcha $captcha,
        BotDetectCaptcha $botDetectCaptcha
    ) {
        $this->tokenManager = $tokenManager;
        $this->authError = $authError;
        $this->lastUsername = $lastUsername;
        $this->captcha = $captcha;
        $this->botDetectCaptcha = $botDetectCaptcha;
    }

    public function __invoke(Request $request): Response
    {
        //Add LoginUserType
        $error = $this->authError->getError($request);
        $lastUsername = $this->lastUsername->getLastUserName($request);
        $csrfToken = $this->tokenManager
            ? $this->tokenManager->getToken('authenticate')->getValue()
            : null;

        $activateCaptcha = $this->captcha->activate($request);
        $htmlCaptcha = '';
        if ($activateCaptcha) {
            $captcha = $this->botDetectCaptcha->setConfig('LoginCaptcha');
            $htmlCaptcha = $captcha->Html();
        }

        return $this->render('admin/security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'enable_captcha' => $activateCaptcha,
            'captcha_html' => $htmlCaptcha,
        ]);
    }
}
