<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Main configuration for the Gaufrette DIC extension
 *
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class MainConfiguration implements ConfigurationInterface
{
    private $factories;

    /**
     * Constructor
     *
     * @param  array $factories
     */
    public function __construct(array $factories)
    {
        $this->factories = $factories;
    }

    /**
     * Generates the configuration tree builder
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('knp_gaufrette');

        $this->addAdaptersSection($rootNode, $this->factories);
        $this->addFilesystemsSection($rootNode);
        $this->addStreamWrapperSection($rootNode);

        $rootNode
            // add a faux-entry for factories, so that no validation error is thrown
            ->fixXmlConfig('factory', 'factories')
            ->children()
                ->arrayNode('factories')->ignoreExtraKeys()->end()
            ->end()
        ;

        return $treeBuilder;
    }

    private function addAdaptersSection(ArrayNodeDefinition $node, array $factories)
    {
        $adapterNodeBuilder = $node
            ->fixXmlConfig('adapter')
            ->children()
                ->arrayNode('adapters')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                    ->performNoDeepMerging()
                    ->children()
        ;

        foreach ($factories as $name => $factory) {
            $factoryNode = $adapterNodeBuilder->arrayNode($name)->canBeUnset();

            $factory->addConfiguration($factoryNode);
        }
    }

    private function addFilesystemsSection(ArrayNodeDefinition $node)
    {
        $node
            ->fixXmlConfig('filesystem')
            ->children()
                ->arrayNode('filesystems')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                    ->children()
                        ->scalarNode('adapter')->isRequired()->end()
                        ->scalarNode('alias')->defaultNull()->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addStreamWrapperSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('stream_wrapper')
                    ->children()
                        ->scalarNode('protocol')->defaultValue('gaufrette')->end()
                        ->arrayNode('filesystems')
                            ->beforeNormalization()
                                ->ifTrue(function ($array) {
                                    return !(bool)count(array_filter(array_keys($array), 'is_string'));
                                })
                                ->then(function ($array) {
                                    return array_combine($array, $array);
                                })
                            ->end()
                            ->useAttributeAsKey('key')
                            ->prototype('scalar')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
