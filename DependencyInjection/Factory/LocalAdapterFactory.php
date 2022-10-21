<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

/**
 * Local adapter factory
 *
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class LocalAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config): void
    {
        $childDefinition = class_exists('\Symfony\Component\DependencyInjection\ChildDefinition')
            ? new ChildDefinition('knp_gaufrette.adapter.local')
            : new DefinitionDecorator('knp_gaufrette.adapter.local');

        $container
            ->setDefinition($id, $childDefinition)
            ->replaceArgument(0, $config['directory'])
            ->replaceArgument(1, $config['create'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey(): string
    {
        return 'local';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $node): void
    {
        $node
            ->children()
                ->scalarNode('directory')->isRequired()->end()
                ->booleanNode('create')->defaultTrue()->end()
            ->end()
        ;
    }
}
