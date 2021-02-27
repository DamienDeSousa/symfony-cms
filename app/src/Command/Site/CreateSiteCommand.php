<?php

/**
 * File that defines the Create site command. This command creates a new site if no site exists.
 *
 * @author Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Command\Site;

use App\Service\Site\SiteCreatorHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateSiteCommand extends Command
{
    /**
     * @var string
     */
    private const ARGUMENT_TITLE_NAME = 'title';

    /**
     * the name of the command (the part after "bin/console")
     *
     * @var string
     */
    protected static $defaultName = 'cms:site:create';

    /**
     * @var SiteCreatorHelper
     */
    private $siteCreator;

    public function __construct(SiteCreatorHelper $siteCreator)
    {
        parent::__construct();

        $this->siteCreator = $siteCreator;
    }

    protected function configure()
    {
        $this->setDescription('Create a new Site instance');
        $this->addArgument(self::ARGUMENT_TITLE_NAME, InputArgument::REQUIRED, 'The site title');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $title = $input->getArgument(self::ARGUMENT_TITLE_NAME);
        $site = $this->siteCreator->create($title);
        $message = 'Site created successfully';
        if (!$site) {
            $message = 'Can\'t create site, a site should already exist';
        }
        $output->writeln($message);

        return 0;
    }
}
