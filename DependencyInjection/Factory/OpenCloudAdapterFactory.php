<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

/**
 * OpenCloud adapter factory
 *
 * @author Mammino Luciano 2013 <lmammino@oryzone.com>
 */
class OpenCloudAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $lazy = isset($config['connection_factory_id']);

        $container
            ->setDefinition($id, new DefinitionDecorator($lazy ? 'knp_gaufrette.adapter.lazy_opencloud' : 'knp_gaufrette.adapter.opencloud'))
            ->replaceArgument(0, new Reference($lazy ? $config['connection_factory_id'] : $config['object_store_id']))
            ->replaceArgument(1, $config['container_name'])
            ->replaceArgument(2, $config['create_container'])
            ->replaceArgument(3, $config['detect_content_type'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'opencloud';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        $node
        ->beforeNormalization()
            ->ifTrue(function($v){
                return empty($v['object_store_id']) && empty($v['connection_factory_id']);
            })
            ->thenInvalid('You have to configure either "object_store_id" or "connection_factory_id" (for lazy-loading).')
        ->end()
        ->children()
            ->scalarNode('object_store_id')->cannotBeEmpty()->end()
            ->scalarNode('connection_factory_id')->cannotBeEmpty()->end()
            ->scalarNode('container_name')->isRequired()->cannotBeEmpty()->end()
            ->booleanNode('create_container')->defaultFalse()->end()
            ->booleanNode('detect_content_type')->defaultTrue()->end()
        ->end()
        ;
    }
}
