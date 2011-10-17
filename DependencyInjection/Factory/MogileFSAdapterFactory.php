<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\Reference;
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
        $container
            ->setDefinition($id, new DefinitionDecorator('knp_gaufrette.adapter.mogilefs'))
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
