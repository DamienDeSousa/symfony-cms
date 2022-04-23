<?php

/**
 * File that defines the DeletePageTemplateBlockTypeController class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Controller\Admin\PageTemplateBlockType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Structure\PageTemplateBlockType;
use Symfony\Component\Routing\Annotation\Route;
use App\Security\Admin\Voter\PageTemplateBlockTypeVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\Structure\PageTemplateBlockType\PageTemplateBlockTypeDeleterService;

/**
 * This class is used to delete a page template block type page.
 *
 * @Route("/admin/page-template-block-type/delete/{id}",
 *  name="admin_page_template_block_type_delete",
 *  requirements={"id"="\d+"}
 * )
 */
class DeletePageTemplateBlockTypeController extends AbstractController
{
    public const DELETE_PAGE_TEMPLATE_BLOCK_TYPE_ROUTE_URI = '/admin/page-template-block-type/delete/';

    public const DELETE_PAGE_TEMPLATE_BLOCK_TYPE_ROUTE_NAME = 'admin_page_template_block_type_delete';

    /** @var PageTemplateBlockTypeDeleterService */
    private $pageTemplateBlockTypeDeleterService;

    public function __construct(PageTemplateBlockTypeDeleterService $pageTemplateBlockTypeDeleterService)
    {
        $this->pageTemplateBlockTypeDeleterService = $pageTemplateBlockTypeDeleterService;
    }

    public function __invoke(Request $request, PageTemplateBlockType $pageTemplateBlockType): Response
    {
        $this->denyAccessUnlessGranted(
            PageTemplateBlockTypeVoter::PAGE_TEMPLATE_BLOCK_TYPE_DELETE,
            $pageTemplateBlockType
        );
        $this->pageTemplateBlockTypeDeleterService->delete($pageTemplateBlockType);
        $this->addFlash('success', 'page-template-block-type.delete.flash-message.success');

        return $this->redirectToRoute(GridPageTemplateBlockTypeController::GRID_PAGE_TEMPLATE_BLOCK_TYPE_ROUTE_NAME);
    }
}
