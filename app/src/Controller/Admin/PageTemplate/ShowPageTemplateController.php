<?php

/**
 * File that define the show page template controller class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Controller\Admin\PageTemplate;

use App\Entity\Structure\PageTemplate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Security\Admin\Voter\PageTemplateVoter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class used to render the page template entity.
 *
 * @Route("/admin/page-template/{id}", name="admin_page_template_show", requirements={"id"="\d+"})
 */
class ShowPageTemplateController extends AbstractController
{
    public const SHOW_PAGE_TEMPLATE_ROUTE_NAME = 'admin_page_template_show';

    public const SHOW_PAGE_TEMPLATE_ROUTE_URI = '/admin/page-template/';

    public function __invoke(Request $request, PageTemplate $pageTemplate): Response
    {
        $this->denyAccessUnlessGranted(PageTemplateVoter::PAGE_TEMPLATE_READ, $pageTemplate);

        return $this->render(
            'admin/structure/page_template/page_template_show.html.twig',
            ['page_template' => $pageTemplate->toArray()]
        );
    }
}
