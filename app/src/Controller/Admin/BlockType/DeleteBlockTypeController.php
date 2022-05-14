<?php

/**
 * File that defines the DeleteBlockTypeController class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Controller\Admin\BlockType;

use Psr\Log\LoggerInterface;
use App\Entity\Structure\BlockType;
use App\Security\Admin\Voter\BlockTypeVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Exception\Entity\DeleteEntityException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Service\Structure\BlockType\BlockTypeDeleterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * This class is used to delete a block type.
 *
 * @Route("/admin/block-type/delete/{id}", name="admin_block_type_delete", requirements={"id"="\d+"})
 */
class DeleteBlockTypeController extends AbstractController
{
    public const DELETE_BLOCK_TYPE_ROUTE_URI = '/admin/block-type/delete/';

    public const DELETE_BLOCK_TYPE_ROUTE_NAME = 'admin_block_type_delete';

    /** @var BlockTypeDeleterService */
    private $blockTypeDeleterService;

    /** @var TranslatorInterface */
    private $translator;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        BlockTypeDeleterService $blockTypeDeleterService,
        TranslatorInterface $translator,
        LoggerInterface $logger
    ) {
        $this->blockTypeDeleterService = $blockTypeDeleterService;
        $this->translator = $translator;
        $this->logger = $logger;
    }

    public function __invoke(Request $request, BlockType $blockType): Response
    {
        $this->denyAccessUnlessGranted(BlockTypeVoter::BLOCK_TYPE_DELETE, $blockType);
        $flashMessageType = 'success';
        $flashMessage = 'block-type.delete.flash-message.success';
        try {
            $this->blockTypeDeleterService->delete($blockType);
        } catch (DeleteEntityException $exception) {
            $flashMessageType = 'danger';
            $flashMessage = $exception->getTransMessage();
            $flashMessage = $this->translator->trans(
                $exception->getTransMessage(),
                $exception->getTransMessageParams()
            );
            $this->logger->error($exception->getMessage());
        }
        $this->addFlash($flashMessageType, $flashMessage);

        return $this->redirectToRoute(GridBlockTypeController::BLOCK_TYPE_ROUTE_NAME);
    }
}
