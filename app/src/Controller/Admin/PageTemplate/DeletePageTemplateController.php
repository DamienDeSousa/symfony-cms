<?php

/**
 * File that defines the DeletePageTemplateController class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Controller\Admin\PageTemplate;

use App\Entity\Structure\PageTemplate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Security\Admin\Voter\PageTemplateVoter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\Structure\PageTemplate\PageTemplateDeleterService;

/**
 * This class is used to delete a page template page.
 *
 * @Route("/admin/page-template/delete/{id}", name="admin_page_template_delete", requirements={"id"="\d+"})
 */
class DeletePageTemplateController extends AbstractController
{
    public const DELETE_PAGE_TEMPLATE_ROUTE_URI = '/admin/page-template/delete/';

    public const DELETE_PAGE_TEMPLATE_ROUTE_NAME = 'admin_page_template_delete';

    /** @var PageTemplateDeleterService */
    private $pageTemplateDeleterService;

    public function __construct(PageTemplateDeleterService $pageTemplateDeleterService)
    {
        $this->pageTemplateDeleterService = $pageTemplateDeleterService;
    }

    public function __invoke(Request $request, PageTemplate $pageTemplate): Response
    {
        $this->denyAccessUnlessGranted(PageTemplateVoter::PAGE_TEMPLATE_DELETE, $pageTemplate);
        $this->pageTemplateDeleterService->delete($pageTemplate);
        $this->addFlash('success', 'page-template.delete.flash-message.success');

        return $this->redirectToRoute(GridPageTemplateController::GRID_PAGE_TEMPLATE_ROUTE_NAME);
    }
}
