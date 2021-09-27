<?php

/**
 * File that define the Update site controller class.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Controller\Admin\Site;

use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormError;
use App\Service\Site\SiteReaderService;
use App\Service\Site\SiteUpdaterService;
use App\Form\Type\Admin\Site\UpdateSiteType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Controller that render the update site form page and treat the submission of this form.
 *
 * @Route("/admin/site/update", name="admin_site_update")
 */
class UpdateSiteController extends AbstractController
{
    public const SITE_UPDATE_URI = '/admin/site/update';

    /** @var SiteReaderService */
    private $siteReaderService;

    /** @var LoggerInterface */
    private $logger;

    /** @var SiteUpdaterService */
    private $siteUpdaterService;

    /** @var TranslatorInterface */
    private $translator;

    public function __construct(
        TranslatorInterface $translator,
        SiteReaderService $siteReaderService,
        LoggerInterface $logger,
        SiteUpdaterService $siteUpdaterService
    ) {
        $this->translator = $translator;
        $this->siteUpdaterService = $siteUpdaterService;
        $this->logger = $logger;
        $this->siteReaderService = $siteReaderService;
    }

    public function __invoke(Request $request): Response
    {
        $site = $this->siteReaderService->read();
        $form = $this->createForm(UpdateSiteType::class, $site);
        $form->handleRequest($request);
        $response = null;
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->siteUpdaterService->updateSite(
                    $site,
                    $form->get('icon')->getData(),
                    $form->get('title')->getData()
                );
                $response = $this->redirectToRoute(ShowSiteController::SITE_SHOW_ROUTE_NAME);
            } catch (\Exception $exception) {
                //Translate the custom form error here because it can't be done automatically in twig template
                //or in validator files.
                $formError = new FormError($this->translator->trans('site.update.error'));
                $form->addError($formError);
                $logMessage = 'An error occured when trying to update the site.' . $exception->getMessage() . PHP_EOL
                    . $exception->getTraceAsString();
                $this->logger->error($logMessage);
            }
        }

        if (!$response) {
            $response = $this->render(
                'admin/site/update.html.twig',
                ['form' => $form->createView()]
            );
        }

        return $response;
    }
}
