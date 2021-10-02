<?php

/**
 * File that defines the SiteVoter class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Security\Admin\Voter;

use App\Entity\Site;
use App\Entity\User;
use App\Security\UserRoles;
use ClosedGeneratorException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * This class tels if a user can access the read and update site page.
 */
class SiteVoter extends Voter
{
    public const SITE_READ = 'site_read';

    public const SITE_UPDATE = 'site_update';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        $pageTemplateCrud = [
            self::SITE_READ,
            self::SITE_UPDATE,
        ];
        $isSupported = false;

        //check if subject is null in case of we have to display the "No site" page
        if (in_array($attribute, $pageTemplateCrud) && ($subject instanceof Site || is_null($subject))) {
            $isSupported = true;
        }

        return $isSupported;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        switch ($attribute) {
            case self::SITE_READ:
                return $this->security->isGranted(UserRoles::ROLE_ADMIN);
            case self::SITE_UPDATE:
                return $this->security->isGranted(UserRoles::ROLE_ADMIN);
        }

        throw new \LogicException('This code should not be reached!');
    }
}
