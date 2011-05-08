<?php

namespace Knplabs\Bundle\GaufretteBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Compiler pass that registers the adapter factories
 *
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class AdapterFactoryManagerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('knplabs_gaufrette.adapter_factory_manager')) {
            return;
        }

        $definition = $container->getDefinition('knplabs_gaufrette.adapter_factory_manager');

        $calls = $definition->getMethodCalls();
        $definition->setMethodCalls(array());

        foreach ($container->findTaggedServiceIds('gaufrette.adapter_factory') as $id => $attributes) {
            if (!empty($attributes['type'])) {
                $definition->addMethodCall('set', array($attributes['type'], new Reference($id)));
            }
        }

        $definition->setMethodCalls(array_merge($definition->getMethodCalls(), $calls));
    }
}
