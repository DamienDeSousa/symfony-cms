<?php

/**
 * File that defines the show site controller. This controller is used to display the site.
 *
 * @author Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Controller\Admin\Site;

use App\Service\Site\SiteReaderService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/site/show", name="admin_site_show")
 */
class ShowSiteController extends AbstractController
{
    public const SITE_SHOW_URI = '/admin/site/show';

    public const SITE_SHOW_ROUTE_NAME = 'admin_site_show';

    /**
     * @var SiteReaderService
     */
    private $siteReader;

    public function __construct(SiteReaderService $siteReader)
    {
        $this->siteReader = $siteReader;
    }

    public function __invoke(): Response
    {
        $site = $this->siteReader->read();
        $response = $site ?
            $this->render('admin/site/show_site.html.twig', ['site' => $site])
            : $this->render('admin/site/unavailable_site.html.twig');

        return $response;
    }
}
