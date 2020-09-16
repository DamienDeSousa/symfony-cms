<?php

namespace App\Twig\Admin;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Extension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('sidebar_sections', [SidebarSection::class, 'getSections']),
        ];
    }
}
