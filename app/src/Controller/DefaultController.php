<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function number()
    {

        return new Response(
            '<html><body></body></html>'
        );
    }

    /**
     * @Route("/admin/", name="admin-home")
     */
    public function admin()
    {
        return $this->render('admin/admin_layout.html.twig');
    }
}
