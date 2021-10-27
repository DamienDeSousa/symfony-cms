<?php

/**
 * File that defines the GridPageTemplateController class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Controller\Admin\PageTemplate;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Security\Admin\Voter\PageTemplateVoter;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Structure\PageTemplateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * This class is used to render the page template grid.
 *
 * @Route("/admin/page-template", name="admin_page_template_grid")
 */
class GridPageTemplateController extends AbstractController
{
    public const GRID_PAGE_TEMPLATE_ROUTE_NAME = 'admin_page_template_grid';

    public const GRID_PAGE_TEMPLATE_ROUTE_URI = '/admin/page-template';

    /** @var PageTemplateRepository */
    private $pageTemplateRepository;

    public function __construct(PageTemplateRepository $pageTemplateRepository)
    {
        $this->pageTemplateRepository = $pageTemplateRepository;
    }

    public function __invoke(Request $request): Response
    {
        $pageTemplates = $this->pageTemplateRepository->findAll();
        $this->denyAccessUnlessGranted(PageTemplateVoter::PAGE_TEMPLATE_READ, $pageTemplates);
        $pageTemplatesHeader = [
            'page-template.grid.id',
            'page-template.grid.name',
            'page-template.grid.layout',
        ];
        $formattedPageTemplates = [];
        foreach ($pageTemplates as $pageTemplate) {
            $formattedPageTemplates[] = [
                'page-template.grid.id' => $pageTemplate->getId(),
                'page-template.grid.name' => $pageTemplate->getName(),
                'page-template.grid.layout' => $pageTemplate->getLayout(),
                'meta_data' => [
                    'id' => $pageTemplate->getId(),
                    'route_name' => ShowPageTemplateController::SHOW_PAGE_TEMPLATE_ROUTE_NAME,
                    'route_name_update' => UpdatePageTemplateController::UPDATE_PAGE_TEMPLATE_ROUTE_NAME,
                    'route_name_delete' => DeletePageTemplateController::DELETE_PAGE_TEMPLATE_ROUTE_NAME,
                ],
            ];
        }

        return $this->render(
            'admin/structure/page_template/page_template_grid.html.twig',
            [
                'page_template_header' => $pageTemplatesHeader,
                'page_templates' => $formattedPageTemplates,
            ]
        );
    }
}
