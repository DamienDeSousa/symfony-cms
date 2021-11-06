<?php

/**
 * File that define the show block type controller class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Controller\Admin\BlockType;

use App\Entity\Structure\BlockType;
use App\Security\Admin\Voter\BlockTypeVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class used to render the page template entity.
 *
 * @Route("/admin/block-type/{id}", name="admin_block_type_show", requirements={"id"="\d+"})
 */
class ShowBlockTypeController extends AbstractController
{
    public const SHOW_BLOCK_TYPE_ROUTE_NAME = 'admin_block_type_show';

    public const SHOW_BLOCK_TYPE_ROUTE_URI = '/admin/block-type/';

    public function __invoke(Request $request, BlockType $blockType): Response
    {
        $this->denyAccessUnlessGranted(BlockTypeVoter::BLOCK_TYPE_READ, $blockType);

        return $this->render(
            'admin/structure/block_type/block_type_show.html.twig',
            ['page_template' => $blockType->toArray()]
        );
    }
}
