<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
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
    function create(ContainerBuilder $container, $id, array $config)
    {
        $definition = $container
            ->setDefinition($id, new DefinitionDecorator('knp_gaufrette.adapter.doctrine_dbal'))
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
    function getKey()
    {
        return 'doctrine_dbal';
    }

    /**
     * {@inheritDoc}
     */
    function addConfiguration(NodeDefinition $builder)
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
