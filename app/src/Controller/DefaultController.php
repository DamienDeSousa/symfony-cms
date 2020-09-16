<?php

namespace App\Controller;

use App\Security\UserRoles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    protected $userRoles;

    public function __construct(UserRoles $userRoles)
    {
        $this->userRoles = $userRoles;
    }
    /**
     * @Route("/", name="index")
     */
    public function number()
    {

        return new Response(
            '<html><body>' . print_r($this->userRoles->getDefinedRoles(), true) . '</body></html>'
        );
    }
}
