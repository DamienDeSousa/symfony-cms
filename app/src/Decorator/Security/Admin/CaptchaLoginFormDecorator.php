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
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

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
        EntityManagerInterface $entityManager,
        UrlGeneratorInterface $urlGenerator,
        CsrfTokenManagerInterface $csrfTokenManager,
        UserPasswordEncoderInterface $passwordEncoder,
        AuthSecurizer $authSecurizer,
        LoginFormAuthenticator $loginFormAuthenticator,
        Captcha $captcha
    ) {
        parent::__construct($entityManager, $urlGenerator, $csrfTokenManager, $passwordEncoder, $authSecurizer);

        $this->loginFormAuthenticator = $loginFormAuthenticator;
        $this->captcha = $captcha;
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request)
    {
        if ($this->loginFormAuthenticator->supports($request)) {
            $this->captcha->setLoginPageDisplayed($request);
        }
    }
}
