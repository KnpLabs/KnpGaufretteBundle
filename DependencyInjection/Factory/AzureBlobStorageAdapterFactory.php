<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;


class AzureBlobStorageAdapterFactory implements AdapterFactoryInterface
{
/**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $definition = $container
            ->setDefinition($id, new DefinitionDecorator('knp_gaufrette.adapter.azure_blob_storage'))
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
            ->children()
                ->scalarNode('blob_proxy_factory_id')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('container_name')->isRequired()->cannotBeEmpty()->end()
                ->booleanNode('create_container')->defaultValue(false)->end()
                ->booleanNode('detect_content_type')->defaultValue(true)->end()
            ->end()
        ;
    }
}