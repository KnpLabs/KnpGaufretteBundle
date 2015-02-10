<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

/**
 * Phpseclib Sftp Adapter Factory
 */
class PhpseclibSftpAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    function create(ContainerBuilder $container, $id, array $config)
    {
        $container
            ->setDefinition($id, new DefinitionDecorator('knp_gaufrette.adapter.phpseclib_sftp'))
            ->addArgument(new Reference($config['phpseclib_sftp_id']))
            ->addArgument($config['directory'])
            ->addArgument($config['create'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    function getKey()
    {
        return 'phpseclib_sftp';
    }

    /**
     * {@inheritDoc}
     */
    function addConfiguration(NodeDefinition $builder)
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
