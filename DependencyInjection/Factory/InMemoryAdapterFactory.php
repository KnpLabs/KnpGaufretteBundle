<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

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
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $container
            ->setDefinition($id, new DefinitionDecorator('knp_gaufrette.adapter.in_memory'))
            ->replaceArgument(0, $config['files'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'in_memory';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $node)
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
