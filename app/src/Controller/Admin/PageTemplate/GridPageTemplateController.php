<?php

/**
 * File that defines the GridPageTemplateController class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Controller\Admin\PageTemplate;

use LogicException;
use UnexpectedValueException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    /** @var PageTemplateRepository */
    private $pageTemplateRepository;

    public function __construct(PageTemplateRepository $pageTemplateRepository)
    {
        $this->pageTemplateRepository = $pageTemplateRepository;
    }

    public function __invoke(Request $request): Response
    {
        $pageTemplates = $this->pageTemplateRepository->findAll();
        $formatedPageTemplates = [
            'page-template.grid.id' => [],
            'page-template.grid.name' => [],
            'page-template.grid.layout' => [],
        ];

        foreach ($pageTemplates as $pageTemplate) {
            $formatedPageTemplates['page-template.grid.id'][] = $pageTemplate->getId();
            $formatedPageTemplates['page-template.grid.name'][] = $pageTemplate->getName();
            $formatedPageTemplates['page-template.grid.layout'][] = $pageTemplate->getLayout();
        }

        return $this->render(
            'admin/structure/page_template/page_template_grid.html.twig',
            ['page_templates' => $formatedPageTemplates]
        );
    }
}
