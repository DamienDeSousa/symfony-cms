<?php

namespace App\Security\Admin\Login;

use Symfony\Component\HttpFoundation\Request;

class Captcha
{
    /**
     * Session variable name containing the number of times the login was submitted.
     */
    protected const LOGIN_PAGE_SUBMITTED = 'login_page_submitted';

    /**
     * Reach this limit will display the captcha on login admin page.
     */
    protected const LIMIT_DISPLAY_CAPTCHA = 3;

    /**
     * Return true if the captcha must be activated.
     *
     * @param Request $request
     *
     * @return boolean
     */
    public function activate(Request $request): bool
    {
        $this->setLoginPageDisplayed($request);
        $session = $request->getSession();
        $nbTimesLoginPageDisplayed = ($session->get(static::LOGIN_PAGE_SUBMITTED) !== null)
            ? $session->get(static::LOGIN_PAGE_SUBMITTED)
            : 0;
        
        return $nbTimesLoginPageDisplayed >= static::LIMIT_DISPLAY_CAPTCHA;
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
