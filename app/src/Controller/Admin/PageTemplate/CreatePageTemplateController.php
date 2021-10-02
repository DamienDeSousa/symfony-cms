<?php

/**
 * File that defines the CreatePageTemplateController class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Controller\Admin\PageTemplate;

use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Security\Admin\Voter\PageTemplateVoter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Form\Type\Admin\PageTemplate\CreatePageTemplateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\Structure\PageTemplate\PageTemplateCreatorService;

/**
 * This class is used to display the create page template page and manage the page template creation.
 *
 * @Route("/admin/page-template/create", name="admin_page_template_create")
 */
class CreatePageTemplateController extends AbstractController
{
    public const CREATE_PAGE_TEMPLATE_ROUTE_URI = '/admin/page-template/create';

    /** @var PageTemplateCreatorService */
    private $pageTemplateCreatorService;

    /** @var LoggerInterface */
    private $logger;

    /** @var TranslatorInterface */
    private $translator;

    public function __construct(
        PageTemplateCreatorService $pageTemplateCreatorService,
        LoggerInterface $logger,
        TranslatorInterface $translator
    ) {
        $this->logger = $logger;
        $this->translator = $translator;
        $this->pageTemplateCreatorService = $pageTemplateCreatorService;
    }

    public function __invoke(Request $request): Response
    {
        $pageTemplate = $this->pageTemplateCreatorService->create();
        $this->denyAccessUnlessGranted(PageTemplateVoter::PAGE_TEMPLATE_CREATE, $pageTemplate);
        $form = $this->createForm(CreatePageTemplateType::class, $pageTemplate);
        $response = null;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pageTemplate = $form->getData();
            try {
                $this->pageTemplateCreatorService->save($pageTemplate);
                $this->addFlash('success', 'page-template.create.flash-message.success');
                $response = $this->redirectToRoute(GridPageTemplateController::GRID_PAGE_TEMPLATE_ROUTE_NAME);
            } catch (\Exception $exception) {
                //Translate the custom form error here because it can't be done automatically in twig template
                //or in validator files.
                $formError = new FormError($this->translator->trans('page-template.create.error'));
                $form->addError($formError);
                $logMessage = 'An error occured when trying to create the page template.'
                    . $exception->getMessage() . PHP_EOL . $exception->getTraceAsString();
                $this->logger->error($logMessage);
            }
        }

        if (!$response) {
            $response = $this->render(
                'admin/structure/page_template/page_template_create.html.twig',
                ['form' => $form->createView()]
            );
        }

        return $response;
    }
}
