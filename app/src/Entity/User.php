<?php

/**
 * Define the User entity class.
 *
 * @author    Damien DE SOUSA <email@email.com>
 * @copyright 2020 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use JetBrains\PhpStorm\Pure;

/**
 * User entity that represents users over all the application.
 */
#[ORM\Entity]
#[ORM\Table(name: "fos_user")]
class User extends BaseUser
{
    #[ORM\Id, ORM\Column(type: "integer"), ORM\GeneratedValue]
    protected $id;

    #[Pure]
    public function __construct()
    {
        parent::__construct();
    }
}
