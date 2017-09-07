<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Phpseclib Sftp Adapter Factory
 */
class PhpseclibSftpAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $childDefinition = class_exists('\Symfony\Component\DependencyInjection\ChildDefinition')
            ? new ChildDefinition('knp_gaufrette.adapter.phpseclib_sftp')
            : new DefinitionDecorator('knp_gaufrette.adapter.phpseclib_sftp');

        $container
            ->setDefinition($id, $childDefinition)
            ->addArgument(new Reference($config['phpseclib_sftp_id']))
            ->addArgument($config['directory'])
            ->addArgument($config['create'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'phpseclib_sftp';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $builder)
    {
        $builder
            ->children()
                ->scalarNode('phpseclib_sftp_id')->isRequired()->end()
                ->scalarNode('directory')->defaultNull()->end()
                ->booleanNode('create')->defaultFalse()->end()
            ->end()
        ;
    }
}
