<?php

/**
 * File that defines the GridBlockTypeController class.
 *
 * @author Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Controller\Admin\BlockType;

use App\Security\Admin\Voter\BlockTypeVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Structure\BlockTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * This class is used to render the block type grid.
 *
 * @Route("/admin/block-type", name="admin_block_type_grid")
 */
class GridBlockTypeController extends AbstractController
{
    public const BLOCK_TYPE_ROUTE_NAME = 'admin_block_type_grid';

    public const BLOCK_TYPE_ROUTE_URI = '/admin/block-type';

    /** @var BlockTypeRepository */
    private $blockTypeRepository;

    public function __construct(BlockTypeRepository $blockTypeRepository)
    {
        $this->blockTypeRepository = $blockTypeRepository;
    }

    public function __invoke(Request $request): Response
    {
        $blockTypes = $this->blockTypeRepository->findAll();
        $this->denyAccessUnlessGranted(BlockTypeVoter::BLOCK_TYPE_READ, $blockTypes);
        $blockTypeHeader = [
            'block-type.grid.id',
            'block-type.grid.type',
        ];
        $formattedBlockTypes = [];
        foreach ($blockTypes as $blockType) {
            $formattedBlockTypes[] = [
                'block-type.grid.id' => $blockType->getId(),
                'block-type.grid.type' => $blockType->getType(),
                'meta_data' => [
                    'id' => $blockType->getId(),
                    'route_name' => ShowBlockTypeController::SHOW_BLOCK_TYPE_ROUTE_NAME,
                    'route_name_update' => UpdateBlockTypeController::UPDATE_BLOCK_TYPE_ROUTE_NAME,
                    'route_name_delete' => '',
                ],
            ];
        }

        return $this->render(
            'admin/structure/block_type/block_type_grid.html.twig',
            [
                'block_type_header' => $blockTypeHeader,
                'block_types' => $formattedBlockTypes,
            ]
        );
    }
}
