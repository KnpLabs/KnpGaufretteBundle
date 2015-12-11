<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

class BackblazeB2StorageAdapterFactory implements AdapterFactoryInterface
{

    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $container
            ->setDefinition($id, new DefinitionDecorator('knp_gaufrette.adapter.backblaze_b2_storage'))
            ->addArgument(new Reference($config['service_id']))
            ->addArgument($config['bucket_id'])
            ->addArgument($config['options'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'backblaze_b2_storage';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $builder)
    {
        $builder
            ->children()
                ->scalarNode('service_id')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('bucket_id')->isRequired()->cannotBeEmpty()->end()
                ->arrayNode('options')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('directory')->defaultValue('')->end()
                        ->booleanNode('private')->defaultFalse()->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
