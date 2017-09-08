<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

class AclAwareAmazonS3AdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $childDefinition = class_exists('\Symfony\Component\DependencyInjection\ChildDefinition')
            ? new ChildDefinition('knp_gaufrette.adapter.amazon_s3')
            : new DefinitionDecorator('knp_gaufrette.adapter.amazon_s3');

        $definition = $container
            ->setDefinition($id.'.delegate', $childDefinition)
            ->addArgument(new Reference($config['amazon_s3_id']))
            ->addArgument($config['bucket_name'])
        ;

        if (isset($config['options'])) {
            $definition->addArgument($config['options']);
        } elseif (isset($config['create'])) {
            $definition->addArgument(array('create' => $config['create']));
        }

        $childDefinition = class_exists('\Symfony\Component\DependencyInjection\ChildDefinition')
            ? new ChildDefinition('knp_gaufrette.adapter.acl_aware_amazon_s3')
            : new DefinitionDecorator('knp_gaufrette.adapter.acl_aware_amazon_s3');

        $def = $container
            ->setDefinition($id, $childDefinition)
            ->addArgument(new Reference($id.'.delegate'))
            ->addArgument(new Reference($config['amazon_s3_id']))
            ->addArgument($config['bucket_name'])
        ;

        if (isset($config['acl'])) {
            $def->addMethodCall('setAclConstant', array($config['acl']));
        }

        if (isset($config['users'])) {
            $def->addMethodCall('setUsers', array($config['users']));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'acl_aware_amazon_s3';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $builder)
    {
        $builder
            ->validate()
                ->always(function($v) {
                    if (!empty($v['acl']) && !empty($v['users'])) {
                        throw new \Exception('"acl", and "users" cannot be set both at the same time.');
                    }

                    return $v;
                })
            ->end()
            ->fixXmlConfig('user')
            ->children()
                ->scalarNode('amazon_s3_id')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('bucket_name')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('acl')->cannotBeEmpty()->end()
                ->arrayNode('users')
                    ->prototype('array')
                        ->validate()
                            ->always(function($v) {
                                if (!empty($v['group']) === !empty($v['id'])) {
                                    throw new \Exception('Either "group", or "id" must be set.');
                                }

                                return $v;
                            })
                        ->end()
                        ->children()
                            ->scalarNode('group')->cannotBeEmpty()->end()
                            ->scalarNode('id')->cannotBeEmpty()->end()
                            ->scalarNode('permission')->isRequired()->cannotBeEmpty()->end()
                        ->end()
                    ->end()
                ->end()
                ->booleanNode('create')->defaultFalse()->end()
                ->arrayNode('options')
                    ->children()
                        ->booleanNode('create')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('region')->end()
                        ->scalarNode('directory')->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
