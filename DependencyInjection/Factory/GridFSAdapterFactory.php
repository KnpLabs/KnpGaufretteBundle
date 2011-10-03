<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

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
        $container
            ->setDefinition($id, new DefinitionDecorator('knp_gaufrette.adapter.gridfs'))
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
