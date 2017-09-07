<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Cache adapter factory
 *
 * @author Robin van der Vleuten <robinvdvleuten@gmail.com>
 */
class CacheAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $definition = class_exists('\Symfony\Component\DependencyInjection\ChildDefinition')
            ? new ChildDefinition('knp_gaufrette.adapter.cache')
            : new DefinitionDecorator('knp_gaufrette.adapter.cache');

        $container
            ->setDefinition($id, $definition)
            ->addArgument(new Reference('gaufrette.' . $config['source'] . '_adapter'))
            ->addArgument(new Reference('gaufrette.' . $config['cache'] . '_adapter'))
            ->addArgument($config['ttl'])
            ->addArgument($config['serialize'] ? new Reference('gaufrette.' . $config['serialize'] . '_adapter') : null)
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'cache';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('source')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('cache')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('ttl')->defaultValue(0)->end()
                ->scalarNode('serialize')->defaultNull()->end()
            ->end()
        ;
    }
}
