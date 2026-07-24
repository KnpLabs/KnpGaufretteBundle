<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * In memory adapter factory
 *
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class InMemoryAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, string $id, array $config): void
    {
        $childDefinition = new ChildDefinition('knp_gaufrette.adapter.in_memory');

        $container
            ->setDefinition($id, $childDefinition)
            ->replaceArgument(0, $config['files'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey(): string
    {
        return 'in_memory';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('files')
                    ->fixXmlConfig('file')
                    ->useAttributeAsKey('filename')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('content')->end()
                            ->scalarNode('checksum')->end()
                            ->scalarNode('mtime')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
