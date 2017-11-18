<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * The Gaufrette DIC extension
 *
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class KnpGaufretteExtension extends Extension
{
    private $factories;

    /**
     * Loads the extension
     *
     * @param  array            $configs
     * @param  ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration($this->getConfiguration($configs, $container), $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('gaufrette.xml');

        $adapters = array();

        foreach ($config['adapters'] as $name => $adapter) {
            $adapters[$name] = $this->createAdapter($name, $adapter, $container, $this->factories);
        }

        $map = array();
        foreach ($config['filesystems'] as $name => $filesystem) {
            $map[$name] = $this->createFilesystem($name, $filesystem, $container, $adapters);
        }

        $container->getDefinition('knp_gaufrette.filesystem_map')
            ->setPublic(true)
            ->replaceArgument(0, $map);

        if (isset($config['stream_wrapper'])) {
            $container->setParameter('knp_gaufrette.stream_wrapper.protocol', $config['stream_wrapper']['protocol']);
            $container->setParameter('knp_gaufrette.stream_wrapper.filesystems', $config['stream_wrapper']['filesystems']);
        }
    }

    public function getConfiguration(array $configs, ContainerBuilder $container)
    {
        // first assemble the adapter factories
        $factoryConfig = new FactoryConfiguration();
        $config        = $this->processConfiguration($factoryConfig, $configs);
        $factories     = $this->createAdapterFactories($config, $container);

        // then normalize the configs
        return new MainConfiguration($factories);
    }

    private function createAdapter($name, array $config, ContainerBuilder $container, array $factories)
    {
        $adapter = null;
        foreach ($config as $key => $adapter) {
            if (array_key_exists($key, $factories)) {
                $id = sprintf('gaufrette.%s_adapter', $name);
                $factories[$key]->create($container, $id, $adapter);

                return $id;
            }
        }

        throw new \LogicException(sprintf('The adapter \'%s\' is not configured.', $name));
    }

    /**
     * @return Reference a reference to the created filesystem
     */
    private function createFilesystem($name, array $config, ContainerBuilder $container, array $adapters)
    {
        if (!array_key_exists($config['adapter'], $adapters)) {
            throw new \LogicException(sprintf('The adapter \'%s\' is not defined.', $config['adapter']));
        }

        $adapter = $adapters[$config['adapter']];
        $id      = sprintf('gaufrette.%s_filesystem', $name);

        $definition = class_exists('\Symfony\Component\DependencyInjection\ChildDefinition')
            ? new ChildDefinition('knp_gaufrette.filesystem')
            : new DefinitionDecorator('knp_gaufrette.filesystem');

        $container
            ->setDefinition($id, $definition)
            ->replaceArgument(0, new Reference($adapter))
        ;

        if (!empty($config['alias'])) {
            $container->getDefinition($id)->setPublic(false);
            $container->setAlias($config['alias'], new Alias($id, true));
        }

        return new Reference($id);
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
