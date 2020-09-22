<?php

namespace App\Controller\Admin\Site;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that render the site page.
 *
 * @Route("/admin/site/update", name="admin_site_update")
 */
class Update extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('admin/site/update.html.twig');
    }
}
