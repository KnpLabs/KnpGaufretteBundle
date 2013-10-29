<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AmazonS3AdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $definition = $container
            ->setDefinition($id, new DefinitionDecorator('knp_gaufrette.adapter.amazon_s3'))
            ->addArgument(new Reference($config['amazon_s3_id']))
            ->addArgument($config['bucket_name']);

        if (isset($config['options'])) {
            $definition->addArgument($config['options']);
        } elseif (isset($config['create'])) {
            $definition->addArgument(array('create' => $config['create']));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'amazon_s3';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $builder)
    {
        $builder
            ->children()
                ->scalarNode('amazon_s3_id')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('bucket_name')->isRequired()->cannotBeEmpty()->end()
                ->booleanNode('create')->end()
                ->arrayNode('options')
                    ->children()
                        ->booleanNode('create')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('region')->end()
                        ->scalarNode('directory')->end()
                        ->scalarNode('acl')->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
