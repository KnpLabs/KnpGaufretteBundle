<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

class GoogleCloudStorageAdapterFactory implements AdapterFactoryInterface
{

    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $container
            ->setDefinition($id, new DefinitionDecorator('knp_gaufrette.adapter.google_cloud_storage'))
            ->addArgument(new Reference($config['service_id']))
            ->addArgument($config['bucket_name'])
            ->addArgument($config['options'])
            ->addArgument($config['detect_content_type'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'google_cloud_storage';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $builder)
    {
        $builder
            ->children()
                ->scalarNode('service_id')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('bucket_name')->isRequired()->cannotBeEmpty()->end()
                ->booleanNode('detect_content_type')->defaultTrue()->end()
                ->arrayNode('options')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('directory')->defaultValue('')->end()
                        ->scalarNode('acl')->defaultValue('private')->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
