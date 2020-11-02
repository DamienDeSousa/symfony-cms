<?php

/**
 * Define the Captcha login form decorator which calculate the number of time that the admin login form is submitted.
 *
 * @author    Damien DE SOUSA <dades@gmail.com>
 * @copyright 2020 Damien DE SOUSA
 */

namespace App\Decorator\Security\Admin;

use App\Security\Admin\AuthSecurizer;
use App\Security\Admin\Login\Captcha;
use App\Security\Admin\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Captcha\Bundle\CaptchaBundle\Security\Core\Exception\InvalidCaptchaException;
use Captcha\Bundle\CaptchaBundle\Integration\BotDetectCaptcha;

class CaptchaLoginFormDecorator extends LoginFormAuthenticator
{
    /**
     * @var LoginFormAuthenticator
     */
    private $loginFormAuthenticator;

    /**
     * @var Captcha
     */
    private $captcha;

    /**
     * @var bool
     */
    private $isCaptchaValid;

    /**
     * @var BotDetectCaptcha
     */
    private $botDetectCaptcha;

    /**
     * @var Captcha
     */
    private $captchaEnabler;

    /**
     * CaptchaLoginFormDecorator constructor.
     *
     * @param EntityManagerInterface       $entityManager
     * @param UrlGeneratorInterface        $urlGenerator
     * @param CsrfTokenManagerInterface    $csrfTokenManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param AuthSecurizer                $authSecurizer
     * @param LoginFormAuthenticator       $loginFormAuthenticator
     * @param Captcha                      $captcha
     */
    public function __construct(
        Captcha $captchaEnabler,
        BotDetectCaptcha $botDetectCaptcha,
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
        $this->botDetectCaptcha = $botDetectCaptcha;
        $this->loginFormAuthenticator = $loginFormAuthenticator;
        $this->captcha = $captcha;
        $this->isCaptchaValid = true;
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request)
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
    public function checkCredentials($credentials, UserInterface $user)
    {
        $isCredentialsValid = $this->loginFormAuthenticator->checkCredentials($credentials, $user);

        if (isset($credentials['captchaCode'])) {
            $captcha = $this->botDetectCaptcha->setConfig('LoginCaptcha');
            $captchaCode = $credentials['captchaCode'];
            $this->isCaptchaValid = $captcha->Validate($captchaCode);
            $isCredentialsValid = $isCredentialsValid && $this->isCaptchaValid;
        }

        return $isCredentialsValid;
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        if (!$this->isCaptchaValid) {
            $exception = new InvalidCaptchaException('CAPTCHA validation failed, try again.');
        }

        return $this->loginFormAuthenticator->onAuthenticationFailure($request, $exception);
    }
}
