<?php

/**
 * File that defines the CreateBlockTypeController class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Controller\Admin\BlockType;

use Psr\Log\LoggerInterface;
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
 * This class is used to display the create block type page and manage the block type creation.
 *
 * @Route("/admin/block-type/create", name="admin_block_type_create")
 */
class CreateBlockTypeController extends AbstractController
{
    public const CREATE_PAGE_TEMPLATE_ROUTE_URI = '/admin/block-type/create';

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

    public function __invoke(Request $request): Response
    {
        $blockType = $this->blockTypeCreatorService->create();
        $this->denyAccessUnlessGranted(BlockTypeVoter::BLOCK_TYPE_CREATE, $blockType);
        $form = $this->createForm(CreateBlockTypeType::class, $blockType);
        $response = null;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $blockType = $form->getData();
            try {
                $this->blockTypeCreatorService->save($blockType);
                $this->addFlash('success', 'block-type.create.flash-message.success');
                $response = $this->redirectToRoute(GridBlockTypeController::BLOCK_TYPE_ROUTE_NAME);
            } catch (\Exception $exception) {
                //Translate the custom form error here because it can't be done automatically in twig template
                //or in validator files.
                $formError = new FormError($this->translator->trans('block-type.create.error'));
                $form->addError($formError);
                $logMessage = 'An error occured when trying to create the block type.'
                    . $exception->getMessage() . PHP_EOL . $exception->getTraceAsString();
                $this->logger->error($logMessage);
            }
        }

        if (!$response) {
            $response = $this->render(
                'admin/structure/block_type/block_type_create.html.twig',
                ['form' => $form->createView()]
            );
        }

        return $response;
    }
}
