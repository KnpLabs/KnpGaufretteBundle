<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Dropbox Adapter Factory
 */
class DropboxAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $childDefinition = class_exists('\Symfony\Component\DependencyInjection\ChildDefinition')
            ? new ChildDefinition('knp_gaufrette.adapter.dropbox')
            : new DefinitionDecorator('knp_gaufrette.adapter.dropbox');

        $container
            ->setDefinition($id, $childDefinition)
            ->addArgument(new Reference($config['api_id']))
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'dropbox';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $builder)
    {
        $builder
            ->children()
                ->scalarNode('api_id')->cannotBeEmpty()->end()
            ->end()
        ;
    }
}
