<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
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
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $childDefinition = class_exists('\Symfony\Component\DependencyInjection\ChildDefinition')
            ? new ChildDefinition('knp_gaufrette.adapter.ftp')
            : new DefinitionDecorator('knp_gaufrette.adapter.ftp');

        $container
            ->setDefinition($id, $childDefinition)
            ->addArgument($config['directory'])
            ->addArgument($config['host'])
            ->addArgument($config)
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'ftp';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $builder)
    {
        $builder
            ->children()
                ->scalarNode('directory')->isRequired()->end()
                ->scalarNode('host')->isRequired()->end()
                ->scalarNode('port')->defaultValue(21)->end()
                ->scalarNode('username')->defaultNull()->end()
                ->scalarNode('password')->defaultNull()->end()
                ->scalarNode('timeout')->defaultValue(90)->end()
                ->booleanNode('passive')->defaultFalse()->end()
                ->booleanNode('create')->defaultFalse()->end()
                ->booleanNode('ssl')->defaultFalse()->end()
                ->booleanNode('utf8')->defaultFalse()->end()
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
