<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

/**
 * Ftp Adapter Factory
 */
class FtpAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    function create(ContainerBuilder $container, $id, array $config)
    {
        $container
            ->setDefinition($id, new DefinitionDecorator('knp_gaufrette.adapter.ftp'))
            ->addArgument($config['directory'])
            ->addArgument($config['host'])
            ->addArgument($config)
        ;
    }

    /**
     * {@inheritDoc}
     */
    function getKey()
    {
        return 'ftp';
    }

    /**
     * {@inheritDoc}
     */
    function addConfiguration(NodeDefinition $builder)
    {
        $builder
            ->children()
                ->scalarNode('directory')->isRequired()->end()
                ->scalarNode('host')->isRequired()->end()
                ->scalarNode('port')->defaultValue(21)->end()
                ->scalarNode('username')->defaultNull()->end()
                ->scalarNode('password')->defaultNull()->end()
                ->booleanNode('passive')->defaultFalse()->end()
                ->booleanNode('create')->defaultFalse()->end()
                ->booleanNode('ssl')->defaultFalse()->end()
                ->scalarNode('mode')
                    ->defaultValue(defined('FTP_ASCII') ? FTP_ASCII : null)
                    ->beforeNormalization()
                    ->ifString()
                    ->then(function($v) { return constant($v); })
                ->end()
            ->end()
        ;
    }
}
