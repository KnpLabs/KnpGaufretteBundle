<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

/**
 * Sftp Adapter Factory
 */
class SftpAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    function create(ContainerBuilder $container, $id, array $config)
    {
        $container
            ->setDefinition($id, new DefinitionDecorator('knp_gaufrette.adapter.sftp'))
            ->addArgument(new Reference($config['sftp_id']))
            ->addArgument($config['directory'])
            ->addArgument($config['create'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    function getKey()
    {
        return 'sftp';
    }

    /**
     * {@inheritDoc}
     */
    function addConfiguration(NodeDefinition $builder)
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
