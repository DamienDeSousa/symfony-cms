<?php

/**
 * Define the index admin page.
 *
 * @author    Damien DE SOUSA <email@email.com>
 * @copyright 2020 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/", name="admin_index")
 */
class Index extends AbstractController
{
    public const INDEX_ROUTE = 'admin_index';

    public const ADMIN_HOME_PAGE_URI = '/admin/';

    public function __invoke(): Response
    {
        return $this->render('admin/index.html.twig');
    }
}
