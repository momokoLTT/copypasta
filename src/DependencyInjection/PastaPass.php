<?php

declare(strict_types=1);

namespace App\DependencyInjection;

use App\Data\Collection\PastaCollection;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class PastaPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has(PastaCollection::class)) {
            return;
        }

        $definition = $container->findDefinition(PastaCollection::class);

        foreach ($container->findTaggedServiceIds('pasta.data') as $id => $tags) {
            $definition->addMethodCall('add', [new Reference($id)]);
        }
    }
}
