<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

/**
 * GridFS adapter factory
 *
 * @author Tomi Saarinen <tomi.saarinen@rohea.com>
 */
class GridFSAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $childDefinition = class_exists('\Symfony\Component\DependencyInjection\ChildDefinition')
            ? new ChildDefinition('knp_gaufrette.adapter.gridfs')
            : new DefinitionDecorator('knp_gaufrette.adapter.gridfs');

        $container
            ->setDefinition($id, $childDefinition)
            ->addArgument(new Reference($config['mongogridfs_id']))
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'gridfs';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        $node
        ->children()
            ->scalarNode('mongogridfs_id')->isRequired()->cannotBeEmpty()->end()
        ->end()
        ;
    }
}
