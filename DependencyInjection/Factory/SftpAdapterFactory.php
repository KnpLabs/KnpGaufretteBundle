<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Sftp Adapter Factory
 */
class SftpAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $definition = class_exists('\Symfony\Component\DependencyInjection\ChildDefinition')
            ? new ChildDefinition('knp_gaufrette.adapter.sftp')
            : new DefinitionDecorator('knp_gaufrette.adapter.sftp');

        $container
            ->setDefinition($id, $definition)
            ->addArgument(new Reference($config['sftp_id']))
            ->addArgument($config['directory'])
            ->addArgument($config['create'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'sftp';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $builder)
    {
        $builder
            ->children()
                ->scalarNode('sftp_id')->isRequired()->end()
                ->scalarNode('directory')->defaultNull()->end()
                ->booleanNode('create')->defaultFalse()->end()
            ->end()
        ;
    }
}
