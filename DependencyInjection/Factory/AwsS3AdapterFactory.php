<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

class AwsS3AdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $childDefinition = class_exists('\Symfony\Component\DependencyInjection\ChildDefinition')
            ? new ChildDefinition('knp_gaufrette.adapter.aws_s3')
            : new DefinitionDecorator('knp_gaufrette.adapter.aws_s3');

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
    public function getKey()
    {
        return 'aws_s3';
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
                ->booleanNode('detect_content_type')->defaultFalse()->end()
                ->arrayNode('options')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('directory')->defaultValue('')->end()
                        ->booleanNode('create')->defaultFalse()->end()
                        ->scalarNode('acl')->defaultValue('private')->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
