<?php

/**
 * Define Captcha class that indicates when the captcha must be displayed on admin login page.
 *
 * @author    Damien DE SOUSA <dades@gmail.com>
 * @copyright 2020 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Security\Admin\Login;

use Symfony\Component\HttpFoundation\Request;

class Captcha
{
    /**
     * Session variable name containing the number of times the login was submitted.
     */
    private const LOGIN_PAGE_SUBMITTED = 'admin_login_page_submitted';

    /**
     * Reach this limit will display the captcha on login admin page.
     */
    private const LIMIT_DISPLAY_CAPTCHA = 3;

    /**
     * Return true if the captcha must be activated.
     *
     * @param Request $request
     *
     * @return boolean
     */
    public function activate(Request $request): bool
    {
        $session = $request->getSession();
        $nbTimesLoginPageDisplayed = ($session->get(static::LOGIN_PAGE_SUBMITTED) !== null)
            ? $session->get(static::LOGIN_PAGE_SUBMITTED)
            : 0;
        
        return $nbTimesLoginPageDisplayed >= static::LIMIT_DISPLAY_CAPTCHA;
    }

    public function isCaptchaDisplayed(Request $request): bool
    {
        $session = $request->getSession();
        $nbTimesLoginPageDisplayed = ($session->get(static::LOGIN_PAGE_SUBMITTED) !== null)
            ? $session->get(static::LOGIN_PAGE_SUBMITTED)
            : 0;
        
        return $nbTimesLoginPageDisplayed > static::LIMIT_DISPLAY_CAPTCHA;
    }

    /**
     * Set the number of times that the login page if displayed.
     *
     * @param Request $request
     *
     * @return void
     */
    public function setLoginPageDisplayed(Request $request): void
    {
        $session = $request->getSession();

        $loginPageDisplayed = $session->get(static::LOGIN_PAGE_SUBMITTED);
        $nbLoginPageDisplayed = 1;
        if (isset($loginPageDisplayed)) {
            $nbLoginPageDisplayed += $loginPageDisplayed;
        }
        $session->set(static::LOGIN_PAGE_SUBMITTED, $nbLoginPageDisplayed);
        $request->setSession($session);
    }
}
