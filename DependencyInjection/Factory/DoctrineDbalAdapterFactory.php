<?php
/**
 * Created by JetBrains PhpStorm.
 * User: falk
 * Date: 07.08.13
 * Time: 14:25
 * To change this template use File | Settings | File Templates.
 */

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;


use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

class DoctrineDbalAdapterFactory implements AdapterFactoryInterface
{
    /**
     * Creates the adapter, registers it and returns its id
     *
     * @param  ContainerBuilder $container  A ContainerBuilder instance
     * @param  string $id         The id of the service
     * @param  array $config     An array of configuration
     */
    function create(ContainerBuilder $container, $id, array $config)
    {
        $definition = $container
            ->setDefinition($id, new DefinitionDecorator('knp_gaufrette.adapter.doctrine_dbal'))
            ->addArgument(new Reference($config['doctrine_dbal_id']))
            ->addArgument($config['table']);

        if (isset($config['columns'])) {
            $definition->addArgument($config['columns']);
        }
    }

    /**
     * Returns the key for the factory configuration
     *
     * @return string
     */
    function getKey()
    {
        return 'doctrine_dbal';
    }

    /**
     * Adds configuration nodes for the factory
     *
     * @param  NodeDefinition $builder
     */
    function addConfiguration(NodeDefinition $builder)
    {
        $builder
            ->children()
                ->scalarNode('doctrine_dbal_id')->isRequired()->cannotBeEmpty()->end()
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
