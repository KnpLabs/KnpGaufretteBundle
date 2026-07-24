<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
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
    public function create(ContainerBuilder $container, string $id, array $config): void
    {
        $childDefinition = new ChildDefinition('knp_gaufrette.adapter.gridfs');

        $container
            ->setDefinition($id, $childDefinition)
            ->addArgument(new Reference($config['mongogridfs_id']))
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey(): string
    {
        return 'gridfs';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(ArrayNodeDefinition $node): void
    {
        $node
        ->children()
            ->scalarNode('mongogridfs_id')->isRequired()->cannotBeEmpty()->end()
        ->end()
        ;
    }
}
