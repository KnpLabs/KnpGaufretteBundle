<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

/**
 * RedisAdapterFactory
 */
class RedisAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $container
            ->setDefinition($id, new DefinitionDecorator('knp_gaufrette.adapter.redis'))
            ->replaceArgument(0, new Reference($config['client']))
            ->replaceArgument(1, $config['hash'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'redis';
    }

    /**
     * {@inheritDoc}
     */
    function addConfiguration(NodeDefinition $builder)
    {
        $builder
            ->children()
            ->scalarNode('client')->isRequired()->end()
            ->scalarNode('hash')->isRequired()->end()
            ->end()
        ;
    }
}
