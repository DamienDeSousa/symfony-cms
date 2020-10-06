<?php

namespace App\Override\Fos\UserBundle\Command;

use App\Security\UserRoles;
use FOS\UserBundle\Command\PromoteUserCommand as FOSPromoteUserCommand;
use FOS\UserBundle\Command\RoleCommand;
use FOS\UserBundle\Util\UserManipulator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PromoteUserCommand extends FOSPromoteUserCommand
{
    /**
     * Undocumented variable
     *
     * @var UserRoles
     */
    protected $userRoles;

    /**
     * Undocumented variable
     *
     * @var FOSPromoteUserCommand
     */
    protected $fosPromotedUserCommand;

    /**
     * Constructor.
     *
     * @param UserManipulator       $manipulator
     * @param FOSPromoteUserCommand $fosPromotedUserCommand
     * @param UserRoles             $userRoles
     */
    public function __construct(
        UserManipulator $manipulator,
        FOSPromoteUserCommand $fosPromotedUserCommand,
        UserRoles $userRoles
    ) {
        parent::__construct($manipulator);

        $this->userRoles = $userRoles;
        $this->fosPromotedUserCommand = $fosPromotedUserCommand;
    }

    /**
     * {@inheritDoc}
     */
    protected function executeRoleCommand(
        UserManipulator $manipulator,
        OutputInterface $output,
        $username,
        $super,
        $role
    ) {
        $availableRoles = $this->userRoles->getDefinedRoles();
        if (!isset($availableRoles[$role])) {
            $output->writeln('The role ROLE_TEST is not available.');
            $output->writeln('Available roles are :' . print_r($this->userRoles->getDefinedRoles(), true));

            return;
        }

        $this->fosPromotedUserCommand->executeRoleCommand($manipulator, $output, $username, $super, $role);
    }
}
