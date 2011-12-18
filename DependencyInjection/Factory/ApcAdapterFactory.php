<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

/**
 * Apc adapter factory
 *
 * @author Alexander Deruwe <alexander.deruwe@gmail.com>
 */
class ApcAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $container
            ->setDefinition($id, new DefinitionDecorator('knp_gaufrette.adapter.apc'))
            ->replaceArgument(0, $config['prefix'])
            ->replaceArgument(1, $config['ttl'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'apc';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('prefix')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('ttl')->defaultValue(0)->end()
            ->end()
        ;
    }
}
