<?php

/**
 * File that define the Index class.
 *
 * @author    Damien DE SOUSA <email@email.com>
 * @copyright 2020 Damien DE SOUSA
 */

declare(strict_types=1);

namespace Dades\CmsBundle\Controller\Admin;

use Dades\CmsBundle\Entity\BlockType;
use App\Entity\Structure\PageTemplate;
use App\Entity\Structure\PageTemplateBlockType;
use Dades\CmsBundle\Entity\Site;
use Dades\CmsBundle\Service\Site\SiteReaderInterface;
use App\Security\Admin\Voter\HomePageVoter;
use Symfony\Component\HttpFoundation\Response;
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

    public function __construct(
        private TranslatorInterface $translator,
        private SiteReaderInterface $siteReaderService,
        private string $iconDirectory,
    ) {
    }

    public function index(): Response
    {
        //TODO: to remove
        $this->denyAccessUnlessGranted(HomePageVoter::HOMEPAGE);

        return parent::index();
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
