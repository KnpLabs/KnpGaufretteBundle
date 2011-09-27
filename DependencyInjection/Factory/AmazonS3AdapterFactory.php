<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AmazonS3AdapterFactory implements AdapterFactoryInterface
{
    /**
    * Creates the adapter, registers it and returns its id
    *
    * @param  ContainerBuilder $container  A ContainerBuilder instance
    * @param  string           $id         The id of the service
    * @param  array            $config     An array of configuration
    */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $container
            ->setDefinition($id, new DefinitionDecorator('knp_gaufrette.adapter.amazon_s3'))
            ->addArgument(new Reference($config['amazon_s3_id']))
            ->addArgument($config['bucket_name'])
            ->addArgument($config['create'])
        ;
    }

    /**
     * Returns the key for the factory configuration
     *
     * @return string
     */
    public function getKey()
    {
        return 'amazon_s3';
    }

    /**
     * Adds configuration nodes for the factory
     *
     * @param  NodeBuilder $builder
     */
    public function addConfiguration(NodeDefinition $builder)
    {
        $builder
            ->children()
                ->scalarNode('amazon_s3_id')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('bucket_name')->isRequired()->cannotBeEmpty()->end()
                ->booleanNode('create')->defaultFalse()->end()
            ->end()
        ;
    }
}