<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Service adapter factory
 *
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class ServiceAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config): void
    {
        $container->setAlias($id, $config['id']);
    }

    /**
     * {@inheritDoc}
     */
    public function getKey(): string
    {
        return 'service';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $builder): void
    {
        $builder
            ->children()
                ->scalarNode('id')->isRequired()->end()
            ->end()
        ;
    }
}
