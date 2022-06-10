<?php

/**
 * File that define the Index class.
 *
 * @author    Damien DE SOUSA <email@email.com>
 * @copyright 2020 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Site;
use App\Entity\Structure\BlockType;
use App\Entity\Structure\PageTemplate;
use App\Entity\Structure\PageTemplateBlockType;
use App\Service\Site\SiteReaderService;
use App\Security\Admin\Voter\HomePageVoter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Contracts\Translation\TranslatorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

/**
 * This class display the index admin page.
 */
class Index extends AbstractDashboardController
{
    public const INDEX_ROUTE = 'admin_index';

    public const ADMIN_HOME_PAGE_URI = '/admin/';

    /** @var TranslatorInterface */
    private $translator;

    /** @var SiteReaderService */
    private $siteReaderService;

    /** @var string */
    private $iconDirectory;

    public function __construct(
        TranslatorInterface $translator,
        SiteReaderService $siteReaderService,
        string $iconDirectory
    ) {
        $this->translator = $translator;
        $this->siteReaderService = $siteReaderService;
        $this->iconDirectory = $iconDirectory;
    }

    /**
     * @Route("/admin", name="admin_index")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted(HomePageVoter::HOMEPAGE);

        return parent::index();

        // return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        $site = $this->siteReaderService->read();
        $dashboard = Dashboard::new()
            ->setTitle($this->translator->trans('cms.name'))
            ->disableUrlSignatures();
        if ($site) {
            $dashboard->setFaviconPath(sprintf('/%s%s', $this->iconDirectory, $site->getIcon()));
        }

        return $dashboard;
    }

    /**
     * @inheritdoc
     */
    public function configureMenuItems(): iterable
    {
        $menuItems = [
            MenuItem::linkToDashboard('admin.sections.dashboard', 'fa fa-home'),

            MenuItem::section('admin.sections.general_parameter'),
            MenuItem::linkToCrud('admin.sections.site', 'fa fa-gear', Site::class),
        ];

        $menuItems[] = MenuItem::section('admin.sections.cms');
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            $menuItems[] = MenuItem::linkToCrud('admin.sections.page_template', 'fa fa-th-large', PageTemplate::class);
            $menuItems[] = MenuItem::linkToCrud('admin.sections.block_type', 'fa fa-square', BlockType::class);
            $menuItems[] = MenuItem::linkToCrud(
                'admin.sections.page_template_block_type',
                'fa fa-link',
                PageTemplateBlockType::class
            );
        }

        return $menuItems;
    }
}
