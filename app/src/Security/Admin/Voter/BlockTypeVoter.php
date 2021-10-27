<?php

/**
 * File that defines BlockTypeVoter class.
 *
 * @author Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Security\Admin\Voter;

use App\Entity\Structure\BlockType;
use App\Entity\User;
use App\Security\UserRoles;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

/**
 * class used to give or not access to crud operation on block type.
 */
class BlockTypeVoter extends Voter
{
    public const BLOCK_TYPE_CREATE = 'page_template_create';

    public const BLOCK_TYPE_READ = 'page_template_read';

    public const BLOCK_TYPE_UPDATE = 'page_template_update';

    public const BLOCK_TYPE_DELETE = 'page_template_delete';

    /** @var Security */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        $pageTemplateCrud = [
            self::BLOCK_TYPE_CREATE,
            self::BLOCK_TYPE_READ,
            self::BLOCK_TYPE_UPDATE,
            self::BLOCK_TYPE_DELETE,
        ];
        $isSupported = false;

        if (
            in_array($attribute, $pageTemplateCrud) &&
            (($subject instanceof BlockType) || ($this->checkArray($subject)))
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
                if (!$element instanceof BlockType) {
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
            case self::BLOCK_TYPE_UPDATE:
            case self::BLOCK_TYPE_DELETE:
            case self::BLOCK_TYPE_CREATE:
                return $this->security->isGranted(UserRoles::ROLE_SUPER_ADMIN);
            case self::BLOCK_TYPE_READ:
                return $this->security->isGranted(UserRoles::ROLE_ADMIN);
        }

        throw new \LogicException('This code should not be reached!');
    }
}
