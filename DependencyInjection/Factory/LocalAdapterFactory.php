<?php

namespace Knplabs\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

/**
 * Local adapter factory
 *
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class LocalAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $adapter = sprintf('knplabs_gaufrette.adapter.local.%s', $id);

        $container
            ->setDefinition($adapter, new DefinitionDecorator('knplabs_gaufrette.adapter.local'))
            ->replaceArgument(0, $config['directory'])
            ->replaceArgument(1, $config['create'])
        ;

        return $adapter;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'local';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('directory')->isRequired()->end()
                ->booleanNode('create')->defaultTrue()->end()
            ->end()
        ;
    }
}
