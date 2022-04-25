<?php

/**
 * File that defines the ShowPageTemplateBlockTypeController class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2022 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Controller\Admin\PageTemplateBlockType;

use App\Entity\Structure\PageTemplateBlockType;
use Symfony\Component\Routing\Annotation\Route;
use App\Security\Admin\Voter\PageTemplateBlockTypeVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * This class is used to display the show page template block type page.
 *
 * @Route(
 *  "/admin/page-template-block-type/{id}",
 *  name="admin_page_template_block_type_show",
 *  requirements={"id"="\d+"}
 * )
 */
class ShowPageTemplateBlockTypeController extends AbstractController
{
    public const SHOW_PAGE_TEMPLATE_ROUTE_NAME = 'admin_page_template_block_type_show';

    public const SHOW_PAGE_TEMPLATE_ROUTE_URI = '/admin/page-template-block-type/';

    public function __invoke(PageTemplateBlockType $pageTemplateBlockType)
    {
        $this->denyAccessUnlessGranted(
            PageTemplateBlockTypeVoter::PAGE_TEMPLATE_BLOCK_TYPE_READ,
            $pageTemplateBlockType
        );

        return $this->render(
            'admin/structure/page_template_block_type/page_template_block_type_show.html.twig',
            ['page_template_block_type' => $pageTemplateBlockType->toArray()]
        );
    }
}
