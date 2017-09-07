<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

/**
 * Safe local adapter factory
 *
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class SafeLocalAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $childDefinition = class_exists('\Symfony\Component\DependencyInjection\ChildDefinition')
            ? new ChildDefinition('knp_gaufrette.adapter.safe_local')
            : new DefinitionDecorator('knp_gaufrette.adapter.safe_local');

        $container
            ->setDefinition($id, $childDefinition)
            ->replaceArgument(0, $config['directory'])
            ->replaceArgument(1, $config['create'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'safe-local';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('directory')->isRequired()->end()
                ->booleanNode('create')->defaultTrue()->end()
            ->end()
        ;
    }
}
