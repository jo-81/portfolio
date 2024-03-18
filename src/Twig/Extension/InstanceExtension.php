<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\InstanceExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class InstanceExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('filter_name', [InstanceExtensionRuntime::class, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('isInstance', [InstanceExtensionRuntime::class, 'doInstance']),
        ];
    }
}
