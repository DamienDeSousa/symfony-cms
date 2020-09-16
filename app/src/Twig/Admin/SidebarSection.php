<?php

namespace App\Twig\Admin;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\RuntimeExtensionInterface;

class SidebarSection implements RuntimeExtensionInterface
{
    protected $routes;

    protected $router;

    public function __construct(UrlGeneratorInterface $router, array $routes = [])
    {
        $this->router = $router;
        $this->routes = $routes;
    }

    public function getSections()
    {
        $sections = [];
        foreach ($this->routes as $route) {
            (isset($route['args'])) ? $section['route'] = $this->router->generate($route['name'], $route['args'])
                : $section['route'] = $this->router->generate($route['name']);
            $section['name'] = $route['section_name'];
            $sections[] = $section;
        }

        return $sections;
    }
}
