<?php

/**
 * File that defines the UpdatePageTemplateController class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2022 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Controller\Admin\PageTemplateBlockType;

use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Structure\PageTemplateBlockType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Security\Admin\Voter\PageTemplateBlockTypeVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\Type\Admin\PageTemplateBlockType\CreatePageTemplateBlockTypeType;
use App\Service\Structure\PageTemplateBlockType\PageTemplateBlockTypeCreatorService;

/**
 * This class is used to display the update page template block type page
 * and manage the page template block type updating.
 *
 * @Route(
 *  "/admin/page-template-block-type/update/{id}",
 *  name="admin_page_template_block_type_update",
 *  requirements={"id"="\d+"}
 * )
 */
class UpdatePageTemplateBlockTypeController extends AbstractController
{
    public const UPDATE_PAGE_TEMPLATE_BLOCK_TYPE_ROUTE_URI = '/admin/page-template-block-type/update/';

    public const UPDATE_PAGE_TEMPLATE_BLOCK_TYPE_ROUTE_NAME = 'admin_page_template_block_type_update';

    /** @var PageTemplateCreatorService */
    private $pageTemplateBlockTypeCreatorService;

    /** @var LoggerInterface */
    private $logger;

    /** @var TranslatorInterface */
    private $translator;

    public function __construct(
        PageTemplateBlockTypeCreatorService $pageTemplateBlockTypeCreatorService,
        LoggerInterface $logger,
        TranslatorInterface $translator
    ) {
        $this->logger = $logger;
        $this->translator = $translator;
        $this->pageTemplateBlockTypeCreatorService = $pageTemplateBlockTypeCreatorService;
    }

    public function __invoke(Request $request, PageTemplateBlockType $pageTemplateBlockType): Response
    {
        $this->denyAccessUnlessGranted(
            PageTemplateBlockTypeVoter::PAGE_TEMPLATE_BLOCK_TYPE_UPDATE,
            $pageTemplateBlockType
        );
        $form = $this->createForm(CreatePageTemplateBlockTypeType::class, $pageTemplateBlockType);
        $response = null;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pageTemplateBlockType = $form->getData();
            try {
                $this->pageTemplateBlockTypeCreatorService->save($pageTemplateBlockType);
                $this->addFlash('success', 'page-template-block-type.update.flash-message.success');
                $response = $this->redirectToRoute(
                    GridPageTemplateBlockTypeController::GRID_PAGE_TEMPLATE_BLOCK_TYPE_ROUTE_NAME
                );
            } catch (\Exception $exception) {
                //Translate the custom form error here because it can't be done automatically in twig template
                //or in validator files.
                $formError = new FormError($this->translator->trans('page-template-block-type.update.error'));
                $form->addError($formError);
                $logMessage = 'An error occured when trying to update the page template block type.'
                    . $exception->getMessage() . PHP_EOL . $exception->getTraceAsString();
                $this->logger->error($logMessage);
            }
        }

        if (!$response) {
            $response = $this->render(
                'admin/structure/page_template_block_type/page_template_block_type_update.html.twig',
                ['form' => $form->createView()]
            );
        }

        return $response;
    }
}
