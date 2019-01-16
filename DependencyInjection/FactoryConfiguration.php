<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Factory configuration for the Gaufrette DIC extension
 *
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class FactoryConfiguration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        // Solves Symfony 4.2 TreeBuilder deprecation
        if (method_exists(TreeBuilder::class, 'getRootNode')) {
            $treeBuilder = new TreeBuilder('knp_gaufrette');
            $rootNode    = $treeBuilder->getRootNode();
        } else {
            $treeBuilder = new TreeBuilder();
            $rootNode    = $treeBuilder->root('knp_gaufrette');
        }

        $rootNode
            ->ignoreExtraKeys()
            ->fixXmlConfig('factory', 'factories')
            ->children()
                ->arrayNode('factories')
                    ->prototype('scalar')->end()
                ->end()
            ->end()
        ->end()
        ;

        return $treeBuilder;
    }
}
