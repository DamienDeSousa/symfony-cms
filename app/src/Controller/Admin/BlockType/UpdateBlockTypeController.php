<?php

/**
 * File that defines the UpdateBlockTypeController class.
 *
 * @author Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Controller\Admin\BlockType;

use Psr\Log\LoggerInterface;
use App\Entity\Structure\BlockType;
use Symfony\Component\Form\FormError;
use App\Security\Admin\Voter\BlockTypeVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\Admin\BlockType\CreateBlockTypeType;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Service\Structure\BlockType\BlockTypeCreatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class used to render and manage the updating block type.
 *
 * @Route("/admin/block-type/update/{id}", name="admin_block_type_update", requirements={"id"="\d+"})
 */
class UpdateBlockTypeController extends AbstractController
{
    public const UPDATE_BLOCK_TYPE_ROUTE_URI = '/admin/block-type/update/';

    public const UPDATE_BLOCK_TYPE_ROUTE_NAME = 'admin_block_type_update';

    /** @var BlockTypeCreatorService */
    private $blockTypeCreatorService;

    /** @var LoggerInterface */
    private $logger;

    /** @var TranslatorInterface */
    private $translator;

    public function __construct(
        BlockTypeCreatorService $blockTypeCreatorService,
        LoggerInterface $logger,
        TranslatorInterface $translator
    ) {
        $this->logger = $logger;
        $this->translator = $translator;
        $this->blockTypeCreatorService = $blockTypeCreatorService;
    }

    public function __invoke(Request $request, BlockType $blockType): Response
    {
        $this->denyAccessUnlessGranted(BlockTypeVoter::BLOCK_TYPE_UPDATE, $blockType);
        $form = $this->createForm(CreateBlockTypeType::class, $blockType);
        $response = null;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $blockType = $form->getData();
            try {
                $this->blockTypeCreatorService->save($blockType);
                $this->addFlash('success', 'block-type.update.flash-message.success');
                $response = $this->redirectToRoute(GridBlockTypeController::BLOCK_TYPE_ROUTE_NAME);
            } catch (\Exception $exception) {
                //Translate the custom form error here because it can't be done automatically in twig template
                //or in validator files.
                $formError = new FormError($this->translator->trans('page-template.update.error'));
                $form->addError($formError);
                $logMessage = 'An error occured when trying to update the page template.'
                    . $exception->getMessage() . PHP_EOL . $exception->getTraceAsString();
                $this->logger->error($logMessage);
            }
        }

        if (!$response) {
            $response = $this->render(
                'admin/structure/block_type/block_type_update.html.twig',
                ['form' => $form->createView()]
            );
        }

        return $response;
    }
}
