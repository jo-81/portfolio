<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class InstanceExtensionRuntime implements RuntimeExtensionInterface
{
    public function doInstance(object $object, string $className): bool
    {
        return $object instanceof $className;
    }
}
