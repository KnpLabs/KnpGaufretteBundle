<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;


class AzureBlobStorageAdapterFactory implements AdapterFactoryInterface
{
/**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $definition = class_exists('\Symfony\Component\DependencyInjection\ChildDefinition')
            ? new ChildDefinition('knp_gaufrette.adapter.azure_blob_storage')
            : new DefinitionDecorator('knp_gaufrette.adapter.azure_blob_storage');

        $container
            ->setDefinition($id, $definition)
            ->addArgument(new Reference($config['blob_proxy_factory_id']))
            ->addArgument($config['container_name'])
            ->addArgument($config['create_container'])
            ->addArgument($config['detect_content_type']);
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'azure_blob_storage';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $builder)
    {
        $builder
            ->validate()
            ->ifTrue(function ($v) {
                return empty($v['container_name']) && !$v['multi_container_mode'];
            })
                ->thenInvalid('You should either provide a container name or enable the multi container mode.')
            ->end()
            ->children()
                ->scalarNode('blob_proxy_factory_id')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('container_name')->isRequired()->end()
                ->booleanNode('create_container')->defaultValue(false)->end()
                ->booleanNode('detect_content_type')->defaultValue(true)->end()
                ->booleanNode('multi_container_mode')->defaultFalse()->end()
            ->end()
        ;
    }
}
