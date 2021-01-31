<?php

declare(strict_types=1);

namespace App\Controller\Admin\Site;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that render the site page.
 *
 * @Route("/admin/site/show", name="admin_site_show")
 */
class Show extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('admin/site/show.html.twig');
    }
}
