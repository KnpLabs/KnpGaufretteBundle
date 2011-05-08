<?php

namespace Knplabs\Bundle\GaufretteBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * The Gaufrette DIC extension
 *
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class KnplabsGaufretteExtension extends Extension
{
    private $factories = null;

    /**
     * Loads the extension
     *
     * @param  array            $configs
     * @param  ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();

        // first assemble the adapter factories
        $factoryConfig = new FactoryConfiguration();
        $config        = $processor->processConfiguration($factoryConfig, $configs);
        $factories     = $this->createAdapterFactories($config, $container);

        // then normalize the configs
        $mainConfig = new MainConfiguration($factories);
        $config     = $processor->processConfiguration($mainConfig, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('gaufrette.xml');

        foreach ($config['adapters'] as $name => $adapter) {
            $adapters[$name] = $this->createAdapter($name, $adapter, $container, $factories);
        }

        foreach ($config['filesystems'] as $name => $filesystem) {
            $this->createFilesystem($name, $filesystem, $container, $adapters);
        }
    }

    private function createAdapter($name, array $config, ContainerBuilder $container, array $factories)
    {
        $adapter = null;
        foreach ($config as $key => $adapter) {
            if (array_key_exists($key, $factories)) {
                return $factories[$key]->create($container, $name, $adapter);
            }
        }

        throw new \LogicException(sprintf('The adapter \'%s\' is not configured.', $name));
    }

    private function createFilesystem($name, array $config, ContainerBuilder $container, array $adapters)
    {
        if (!array_key_exists($config['adapter'], $adapters)) {
            throw new \LogicException(sprintf('The adapter \'%s\' is not defined.', $config['adapter']));
        }

        $adapter = $adapters[$config['adapter']];
        $id      = sprintf('gaufrette.%s_filesystem', $name);

        $container
            ->setDefinition($id, new DefinitionDecorator('knplabs_gaufrette.filesystem'))
            ->replaceArgument(0, new Reference($adapter))
        ;

        if (!empty($config['alias'])) {
            $container->setAlias($config['alias'], $id);
        }
    }

    /**
     * Creates the adapter factories
     *
     * @param  array            $config
     * @param  ContainerBuilder $container
     */
    private function createAdapterFactories($config, ContainerBuilder $container)
    {
        if (null !== $this->factories) {
            return $this->factories;
        }

        // load bundled adapter factories
        $tempContainer = new ContainerBuilder();
        $parameterBag  = $container->getParameterBag();
        $loader        = new XmlFileLoader($tempContainer, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('adapter_factories.xml');

        // load user-created adapter factories
        foreach ($config['factories'] as $factory) {
            $loader->load($parameterBag->resolveValue($factory));
        }

        $services  = $tempContainer->findTaggedServiceIds('gaufrette.adapter.factory');
        $factories = array();
        foreach (array_keys($services) as $id) {
            $factory = $tempContainer->get($id);
            $factories[str_replace('-', '_', $factory->getKey())] = $factory;
        }

        return $this->factories = $factories;
    }
}
