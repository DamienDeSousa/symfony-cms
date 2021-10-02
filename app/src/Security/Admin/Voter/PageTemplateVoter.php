<?php

/**
 * File that defines the PageTemplateVoter class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Security\Admin\Voter;

use App\Entity\User;
use App\Security\UserRoles;
use ClosedGeneratorException;
use App\Entity\Structure\PageTemplate;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * This class tells if a user can access CRUD template page.
 */
class PageTemplateVoter extends Voter
{
    public const PAGE_TEMPLATE_CREATE = 'page_template_create';

    public const PAGE_TEMPLATE_READ = 'page_template_read';

    public const PAGE_TEMPLATE_UPDATE = 'page_template_update';

    public const PAGE_TEMPLATE_DELETE = 'page_template_delete';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        $pageTemplateCrud = [
            self::PAGE_TEMPLATE_CREATE,
            self::PAGE_TEMPLATE_READ,
            self::PAGE_TEMPLATE_UPDATE,
            self::PAGE_TEMPLATE_DELETE,
        ];
        $isSupported = false;

        if (
            in_array($attribute, $pageTemplateCrud) &&
            (($subject instanceof PageTemplate) || ($this->checkArray($subject)))
        ) {
            $isSupported = true;
        }

        return $isSupported;
    }

    private function checkArray($subject)
    {
        $isSupported = false;
        if (is_array($subject)) {
            $isSupported = true;
            foreach ($subject as $element) {
                if (!$element instanceof PageTemplate) {
                    $isSupported = false;
                    break;
                }
            }
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
            case self::PAGE_TEMPLATE_CREATE:
                return $this->security->isGranted(UserRoles::ROLE_SUPER_ADMIN);
            case self::PAGE_TEMPLATE_READ:
                return $this->security->isGranted(UserRoles::ROLE_ADMIN);
            case self::PAGE_TEMPLATE_UPDATE:
                return $this->security->isGranted(UserRoles::ROLE_SUPER_ADMIN);
            case self::PAGE_TEMPLATE_DELETE:
                return $this->security->isGranted(UserRoles::ROLE_SUPER_ADMIN);
        }

        throw new \LogicException('This code should not be reached!');
    }
}
