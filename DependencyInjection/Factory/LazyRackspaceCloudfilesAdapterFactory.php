<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class LazyRackspaceCloudfilesAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    function create(ContainerBuilder $container, $id, array $config)
    {
        $definition = $container
            ->setDefinition($id, new DefinitionDecorator('knp_gaufrette.adapter.lazy_rackspace_cloudfiles'))
            ->addArgument(new Reference($config['rackspace_authentication_id']))
            ->addArgument($config['container_name']);

        $create = NULL;
        if (isset($config['options']) && isset($config['options']['create']))
            $create = $config['options']['create'];
        elseif (isset($config['create']))
            $create = $config['create'];

        if($create !== NULL)
            $definition->addArgument($create);
    }

    /**
     * {@inheritDoc}
     */
    function getKey()
    {
        return 'lazy_rackspace_cloudfiles';
    }

    /**
     * {@inheritDoc}
     */
    function addConfiguration(NodeDefinition $builder)
    {
        $builder
            ->children()
                ->scalarNode('rackspace_authentication_id')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('container_name')->isRequired()->cannotBeEmpty()->end()
                ->booleanNode('create')->end()
                ->arrayNode('options')
                    ->children()
                        ->booleanNode('create')
                            ->defaultFalse()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}