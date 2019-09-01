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
        $treeBuilder = new TreeBuilder('knp_gaufrette');
        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC for symfony/config < 4.2
            $rootNode = $treeBuilder->root('knp_gaufrette');
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
