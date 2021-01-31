<?php

/**
 * Define the logic of the sidebar_sections() twig function. Twig extension that get the admin sidebar sections.
 *
 * @see       config/services.yaml
 * @author    Damien DE SOUSA <email@email.com>
 * @copyright 2020 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Twig\Admin;

use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\RuntimeExtensionInterface;

class SidebarSection implements RuntimeExtensionInterface
{
    /**
     * Routes defined and injected.
     * @see config/services.yaml
     *
     * @var array
     */
    protected $routes;

    /**
     * @var UrlGeneratorInterface
     */
    protected $router;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger, UrlGeneratorInterface $router, array $routes = [])
    {
        $this->logger = $logger;
        $this->router = $router;
        $this->routes = $routes;
    }

    /**
     * Get sections to display in the sidebar.
     *
     * @return array
     */
    public function getSections(): array
    {
        $sections = [];
        foreach ($this->routes as $route) {
            if (!$this->isRouteValid($route)) {
                $this->logger->error(
                    'The route ' . json_encode($route) . ' is not valid. Please check the config file.'
                );
                continue;
            }

            (isset($route['args'])) ?
                $section['route'] = $this->router->generate($route['name'], $route['args'])
                : $section['route'] = $this->router->generate($route['name']);

            $section['name'] = $route['section_name'];
            $sections[] = $section;
        }

        return $sections;
    }

    /**
     * Check if the given route is valid.
     *
     * @param array $route
     *
     * @return boolean
     */
    protected function isRouteValid(array $route): bool
    {
        $isValid = false;

        if (isset($route['name']) && isset($route['section_name'])) {
            $isValid = true;
        }

        return $isValid;
    }
}
