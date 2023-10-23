<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

class GoogleCloudStorageAdapterFactory implements AdapterFactoryInterface
{

    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config): void
    {
        $childDefinition = class_exists('\Symfony\Component\DependencyInjection\ChildDefinition')
            ? new ChildDefinition('knp_gaufrette.adapter.google_cloud_storage')
            : new DefinitionDecorator('knp_gaufrette.adapter.google_cloud_storage');

        $container
            ->setDefinition($id, $childDefinition)
            ->addArgument(new Reference($config['service_id']))
            ->addArgument($config['bucket_name'])
            ->addArgument($config['options'])
            ->addArgument($config['detect_content_type'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey(): string
    {
        return 'google_cloud_storage';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $builder): void
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
                        ->scalarNode('project_id')->end()
                        ->scalarNode('bucket_location')->end()
                        ->booleanNode('create')->defaultFalse()->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
