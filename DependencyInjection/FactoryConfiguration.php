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
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('knp_gaufrette');
        $rootNode = $treeBuilder->getRootNode();
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
