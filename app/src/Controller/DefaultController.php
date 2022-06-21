<?php

namespace App\Controller;

use Dades\FosUserExtensionBundle\Security\UserRolesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    public function __construct(private UserRolesInterface $userRoles)
    {
    }

    /**
     * @Route("/", name="index")
     */
    public function number(): Response
    {
        return new Response(
            '<html><body>' . print_r($this->userRoles->getDefinedRoles(), true) . '</body></html>'
        );
    }

    /**
     * @Route("/test", name="test")
     */
    public function test(): Response
    {
        return new Response(
            'Test page'
        );
    }
}
