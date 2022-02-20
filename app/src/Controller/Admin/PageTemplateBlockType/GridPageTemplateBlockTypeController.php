<?php

/**
 * File that defines the GridPageTemplateBlockType class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2022
 */

declare(strict_types=1);

namespace App\Controller\Admin\PageTemplateBlockType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Security\Admin\Voter\PageTemplateBlockTypeVoter;
use App\Repository\Structure\PageTemplateBlockTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * This class is used to render the page template grid.
 *
 * @Route("/admin/page-template-block-type", name="admin_page_template_block_type_grid")
 */
class GridPageTemplateBlockTypeController extends AbstractController
{
    public const GRID_PAGE_TEMPLATE_BLOCK_TYPE_ROUTE_URI = '/admin/page-template-block-type';

    public const GRID_PAGE_TEMPLATE_BLOCK_TYPE_ROUTE_NAME = 'admin_page_template_block_type_grid';

    /** @var PageTemplateBlockTypeRepository */
    private $pageTemplateBlockTypeRepository;

    public function __construct(PageTemplateBlockTypeRepository $pageTemplateBlockTypeRepository)
    {
        $this->pageTemplateBlockTypeRepository = $pageTemplateBlockTypeRepository;
    }

    public function __invoke(Request $request): Response
    {
        $pageTemplateBlockTypes = $this->pageTemplateBlockTypeRepository->findAll();
        $this->denyAccessUnlessGranted(
            PageTemplateBlockTypeVoter::PAGE_TEMPLATE_BLOCK_TYPE_READ,
            $pageTemplateBlockTypes
        );
        $pageTemplateBlockTypesHeader = [
            'page-template-block-type.grid.id',
            'page-template-block-type.grid.slug',
            'page-template-block-type.grid.page-template-name',
            'page-template-block-type.grid.block-type-name',
        ];
        $formattedPageTemplateBlockTypes = [];
        foreach ($pageTemplateBlockTypes as $pageTemplateBlockType) {
            $formattedPageTemplateBlockTypes[] = [
                'page-template-block-type.grid.id' => $pageTemplateBlockType->getId(),
                'page-template-block-type.grid.slug' => $pageTemplateBlockType->getSlug(),
                'page-template-block-type.grid.page-template-name'
                    => $pageTemplateBlockType->getPageTemplate()->getName(),
                'page-template-block-type.grid.block-type-name' => $pageTemplateBlockType->getBlockType()->getType(),
                'meta_data' => [
                    'id' => $pageTemplateBlockType->getId(),
                    'route_name' => '',
                    'route_name_update' => '',
                    'route_name_delete' => '',
                ],
            ];
        }

        return $this->render(
            'admin/structure/page_template_block_type/page_template_block_type_grid.html.twig',
            [
                'page_template_block_type_header' => $pageTemplateBlockTypesHeader,
                'page_template_block_types' => $formattedPageTemplateBlockTypes,
            ]
        );
    }
}
