<?php

declare(strict_types=1);

namespace App\DependencyInjection;

use App\Data\Collection\EnumCollection;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class EnumPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has(EnumCollection::class)) {
            return;
        }

        $definition = $container->findDefinition(EnumCollection::class);

        foreach ($container->findTaggedServiceIds('pasta.enum') as $id => $tags) {
            $definition->addMethodCall('add', [new Reference($id)]);
        }
    }
}
