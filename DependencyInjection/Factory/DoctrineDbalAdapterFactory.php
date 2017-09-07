<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

/**
 * doctrine dbal adapter factory
 *
 * @author Falk Doering <falk.doering@marktjagd.de>
 */
class DoctrineDbalAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $childDefinition = class_exists('\Symfony\Component\DependencyInjection\ChildDefinition')
            ? new ChildDefinition('knp_gaufrette.adapter.doctrine_dbal')
            : new DefinitionDecorator('knp_gaufrette.adapter.doctrine_dbal');

        $definition = $container
            ->setDefinition($id, $childDefinition)
            ->addArgument(new Reference('doctrine.dbal.' . $config['connection_name'] . '_connection'))
            ->addArgument($config['table'])
        ;

        if (isset($config['columns'])) {
            $definition->addArgument($config['columns']);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'doctrine_dbal';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $builder)
    {
        $builder
            ->children()
                ->scalarNode('connection_name')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('table')->isRequired()->cannotBeEmpty()->end()
                ->arrayNode('columns')
                    ->children()
                        ->scalarNode('key')->end()
                        ->scalarNode('content')->end()
                        ->scalarNode('mtime')->end()
                        ->scalarNode('checksum')->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
