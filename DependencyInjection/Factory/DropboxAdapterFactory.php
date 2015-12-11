<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

/**
 * Dropbox Adapter Factory
 */
class DropboxAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    function create(ContainerBuilder $container, $id, array $config)
    {
        $container
            ->setDefinition($id, new DefinitionDecorator('knp_gaufrette.adapter.dropbox'))
            ->addArgument(new Reference($config['api_id']))
            ->addArgument($config['path'])
            ->addArgument($config['limit'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    function getKey()
    {
        return 'dropbox';
    }

    /**
     * {@inheritDoc}
     */
    function addConfiguration(NodeDefinition $builder)
    {
        $builder
            ->children()
                ->scalarNode('api_id')->cannotBeEmpty()->end()
                ->scalarNode('path')->defaultValue('/')->end()
                ->scalarNode('limit')->defaultValue('10000')->end()
            ->end()
        ;
    }
}
