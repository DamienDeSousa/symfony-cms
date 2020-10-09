<?php

namespace App\Security\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class LastUsername
{
    public function getLastUserName(Request $request)
    {
        /** @var Session $session */
        $session = $request->getSession();
        $lastUsernameKey = Security::LAST_USERNAME;

        return (null === $session) ? '' : $session->get($lastUsernameKey);
    }
}
