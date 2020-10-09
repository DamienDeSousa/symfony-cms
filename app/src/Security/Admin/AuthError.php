<?php

namespace App\Security\Admin;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthError
{
    public function getError(Request $request): ?AuthenticationException
    {
        /** @var Session $session */
        $session = $request->getSession();
        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $error = null;
        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        return $error;
    }
}
