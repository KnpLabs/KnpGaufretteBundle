<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

/**
 * GridFS adapter factory
 *
 * @author Mikko Tarvainen 2011 <mtarvainen@gmail.com>
 */
class MogileFSAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $childDefinition = class_exists('\Symfony\Component\DependencyInjection\ChildDefinition')
            ? new ChildDefinition('knp_gaufrette.adapter.mogilefs')
            : new DefinitionDecorator('knp_gaufrette.adapter.mogilefs');

        $container
            ->setDefinition($id, $childDefinition)
            ->replaceArgument(0, $config['domain'])
            ->replaceArgument(1, $config['hosts'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'mogilefs';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        $node
        ->children()
            ->scalarNode('domain')->isRequired()->cannotBeEmpty()->end()
            ->arrayNode('hosts')
                ->requiresAtLeastOneElement()
                ->prototype('scalar')->end()
            ->end()
        ->end()
        ;
    }
}
