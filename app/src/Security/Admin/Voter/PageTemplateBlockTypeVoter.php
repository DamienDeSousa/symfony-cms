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
use Symfony\Component\Security\Core\Security;
use App\Entity\Structure\PageTemplateBlockType;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * This class tells if a user can access CRUD template page block type.
 */
class PageTemplateBlockTypeVoter extends Voter
{
    public const PAGE_TEMPLATE_BLOCK_TYPE_CREATE = 'page_template_block_type_create';

    public const PAGE_TEMPLATE_BLOCK_TYPE_READ = 'page_template_block_type_read';

    public const PAGE_TEMPLATE_BLOCK_TYPE_UPDATE = 'page_template_block_type_update';

    public const PAGE_TEMPLATE_BLOCK_TYPE_DELETE = 'page_template_block_type_delete';

    /** @var Security */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        $pageTemplateCrud = [
            self::PAGE_TEMPLATE_BLOCK_TYPE_CREATE,
            self::PAGE_TEMPLATE_BLOCK_TYPE_READ,
            self::PAGE_TEMPLATE_BLOCK_TYPE_UPDATE,
            self::PAGE_TEMPLATE_BLOCK_TYPE_DELETE,
        ];
        $isSupported = false;

        if (
            in_array($attribute, $pageTemplateCrud) &&
            (($subject instanceof PageTemplateBlockType) || ($this->checkArray($subject)))
        ) {
            $isSupported = true;
        }

        return $isSupported;
    }

    private function checkArray($subject): bool
    {
        $isSupported = false;
        if (is_array($subject)) {
            $isSupported = true;
            foreach ($subject as $element) {
                if (!$element instanceof PageTemplateBlockType) {
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
            case self::PAGE_TEMPLATE_BLOCK_TYPE_UPDATE:
            case self::PAGE_TEMPLATE_BLOCK_TYPE_DELETE:
            case self::PAGE_TEMPLATE_BLOCK_TYPE_CREATE:
                return $this->security->isGranted(UserRoles::ROLE_SUPER_ADMIN);
            case self::PAGE_TEMPLATE_BLOCK_TYPE_READ:
                return $this->security->isGranted(UserRoles::ROLE_ADMIN);
        }

        throw new \LogicException('This code should not be reached!');
    }
}
