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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class CaptchaLoginFormDecorator extends LoginFormAuthenticator
{
    private LoginFormAuthenticator $loginFormAuthenticator;

    private Captcha $captcha;

    private Captcha $captchaEnabler;

    private CaptchaValidator $captchaValidator;

    private bool $isCaptchaValid;

    public function __construct(
        CaptchaValidator $captchaValidator,
        Captcha $captchaEnabler,
        EntityManagerInterface $entityManager,
        UrlGeneratorInterface $urlGenerator,
        CsrfTokenManagerInterface $csrfTokenManager,
        UserPasswordEncoderInterface $passwordEncoder,
        AuthSecurizer $authSecurizer,
        LoginFormAuthenticator $loginFormAuthenticator,
        Captcha $captcha
    ) {
        parent::__construct($entityManager, $urlGenerator, $csrfTokenManager, $passwordEncoder, $authSecurizer);

        $this->captchaEnabler = $captchaEnabler;
        $this->loginFormAuthenticator = $loginFormAuthenticator;
        $this->captcha = $captcha;
        $this->captchaValidator = $captchaValidator;
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
    public function getCredentials(Request $request)
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
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $this->captcha->unsetSessionPageDisplayed($request);
        $this->captcha->removeSessionCaptchaPhrase($request->getSession());

        return $this->loginFormAuthenticator->onAuthenticationSuccess($request, $token, $providerKey);
    }
}
