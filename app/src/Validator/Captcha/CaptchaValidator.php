<?php

/**
 * Defines CaptchaValidator class.
 *
 * @author Damien DE SOUSA
 */

namespace App\Validator\Captcha;

use App\Security\Admin\Login\Captcha;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Validate if a given captcha code correspond to the generated one.
 */
class CaptchaValidator
{
    private SessionInterface $session;

    private Captcha $captcha;

    public function __construct(SessionInterface $session, Captcha $captcha)
    {
        $this->session = $session;
        $this->captcha = $captcha;
    }

    public function validate($value): bool
    {
        return $this->captcha->getSessionCaptchaPhrase($this->session) === $value;
    }
}
