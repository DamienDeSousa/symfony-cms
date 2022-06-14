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
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Gregwar\CaptchaBundle\Generator\CaptchaGenerator;

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

    protected CaptchaGenerator $captchaGenerator;

    private array $gregwarCaptchaOptions;

    public function __construct(
        CaptchaGenerator $captchaGenerator,
        CsrfTokenManagerInterface $tokenManager,
        AuthError $authError,
        LastUsername $lastUsername,
        Captcha $captcha,
        array $gregwarCaptchaOptions
    ) {
        $this->tokenManager = $tokenManager;
        $this->authError = $authError;
        $this->lastUsername = $lastUsername;
        $this->captcha = $captcha;
        $this->captchaGenerator = $captchaGenerator;
        $this->gregwarCaptchaOptions = $gregwarCaptchaOptions;
    }

    public function __invoke(Request $request): Response
    {
        //Add LoginUserType
        $error = $this->authError->getError($request);
        $lastUsername = $this->lastUsername->getLastUserName($request);
        $csrfToken = $this->tokenManager
            ? $this->tokenManager->getToken('authenticate')->getValue()
            : null;
        $viewParameters = [
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
        ];

        $activateCaptcha = $this->captcha->activate($request);
        $viewParameters['enable_captcha'] = $activateCaptcha;
        if ($activateCaptcha) {
            $code = $this->captchaGenerator->getCaptchaCode($this->gregwarCaptchaOptions);
            $viewParameters['code'] = $code;
            $viewParameters['width'] = $this->gregwarCaptchaOptions['width'];
            $viewParameters['height'] = $this->gregwarCaptchaOptions['height'];
        }

        return $this->render('admin/security/login.html.twig', $viewParameters);
    }
}
