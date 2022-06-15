<?php

/**
 * Define the Captcha login form decorator which calculate the number of time that the admin login form is submitted.
 *
 * @author    Damien DE SOUSA <dades@gmail.com>
 * @copyright 2020 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Decorator\Security\Admin;

use App\Security\Admin\AuthSecurizer;
use App\Security\Admin\Login\Captcha;
use App\Security\Admin\LoginFormAuthenticator;
use App\Validator\Captcha\CaptchaValidator;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class CaptchaLoginFormDecorator extends LoginFormAuthenticator
{
    private bool $isCaptchaValid;

    #[Pure]
    public function __construct(
        private CaptchaValidator $captchaValidator,
        private Captcha $captchaEnabler,
        EntityManagerInterface $entityManager,
        UrlGeneratorInterface $urlGenerator,
        CsrfTokenManagerInterface $csrfTokenManager,
        UserPasswordEncoderInterface $passwordEncoder,
        AuthSecurizer $authSecurizer,
        private LoginFormAuthenticator $loginFormAuthenticator,
        private Captcha $captcha
    ) {
        parent::__construct($entityManager, $urlGenerator, $csrfTokenManager, $passwordEncoder, $authSecurizer);

        $this->isCaptchaValid = true;
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request): bool
    {
        $isSupportedRequest = $this->loginFormAuthenticator->supports($request);
        if ($isSupportedRequest) {
            $this->captcha->setLoginPageDisplayed($request);
        }

        return $isSupportedRequest;
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape([
        'username' => "string",
        'password' => "string",
        'csrf_token' => "string",
        'captchaCode' => "string"
    ])]
    public function getCredentials(Request $request): array
    {
        $credentials = $this->loginFormAuthenticator->getCredentials($request);
        if ($this->captchaEnabler->isCaptchaDisplayed($request)) {
            $credentials['captchaCode'] = $request->request->get('captchaCode');
        }

        return $credentials;
    }

    /**
     * @inheritDoc
     */
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        $isCredentialsValid = $this->loginFormAuthenticator->checkCredentials($credentials, $user);

        if (isset($credentials['captchaCode'])) {
            $captchaCode = $credentials['captchaCode'];
            $this->isCaptchaValid = $this->captchaValidator->validate($captchaCode);
            $isCredentialsValid = $isCredentialsValid && $this->isCaptchaValid;
        }

        return $isCredentialsValid;
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): RedirectResponse
    {
        if (!$this->isCaptchaValid) {
            $exception = new CustomUserMessageAuthenticationException('security.captcha.error.message');
        }

        return $this->loginFormAuthenticator->onAuthenticationFailure($request, $exception);
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): ?Response
    {
        $this->captcha->unsetSessionPageDisplayed($request);
        $this->captcha->removeSessionCaptchaPhrase($request->getSession());

        return $this->loginFormAuthenticator->onAuthenticationSuccess($request, $token, $providerKey);
    }
}
