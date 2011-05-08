<?php
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InactiveScopeException;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Parameter;
class ResourcesTestProjectContainer extends Container
{
    public function __construct()
    {
        $this->parameters = $this->getDefaultParameters();
        $this->services =
        $this->scopedServices =
        $this->scopeStacks = array();
        $this->set('service_container', $this);
        $this->scopes = array();
        $this->scopeChildren = array();
    }
    protected function getGaufrette_FooFilesystemService()
    {
        return $this->services['gaufrette.foo_filesystem'] = new \Gaufrette\Filesystem\Filesystem($this->get('knplabs_gaufrette.adapter.local.foo'));
    }
    protected function getKnplabsGaufrette_Adapter_Local_FooService()
    {
        return $this->services['knplabs_gaufrette.adapter.local.foo'] = new \Gaufrette\Filesystem\Adapter\InMemory(array());
    }
    protected function getFooFilesystemService()
    {
        return $this->get('gaufrette.foo_filesystem');
    }
    public function getParameter($name)
    {
        $name = strtolower($name);
        if (!array_key_exists($name, $this->parameters)) {
            throw new \InvalidArgumentException(sprintf('The parameter "%s" must be defined.', $name));
        }
        return $this->parameters[$name];
    }
    public function hasParameter($name)
    {
        return array_key_exists(strtolower($name), $this->parameters);
    }
    public function setParameter($name, $value)
    {
        throw new \LogicException('Impossible to call set() on a frozen ParameterBag.');
    }
    protected function getDefaultParameters()
    {
        return array(
            'kernel.root_dir' => '/home/antoine/htdocs/symfony/vendor/bundles/Knplabs/Bundle/GaufretteBundle/Tests/Resources',
            'kernel.environment' => 'test',
            'kernel.debug' => false,
            'kernel.name' => 'Resources',
            'kernel.cache_dir' => '/home/antoine/htdocs/symfony/vendor/bundles/Knplabs/Bundle/GaufretteBundle/Tests/Resources/cache/test',
            'kernel.logs_dir' => '/home/antoine/htdocs/symfony/vendor/bundles/Knplabs/Bundle/GaufretteBundle/Tests/Resources/logs',
            'kernel.bundles' => array(
                'KnplabsGaufretteBundle' => 'Knplabs\\Bundle\\GaufretteBundle\\KnplabsGaufretteBundle',
            ),
            'kernel.charset' => 'UTF-8',
            'kernel.container_class' => 'ResourcesTestProjectContainer',
            'knplabs_gaufrette.filesystem.class' => 'Gaufrette\\Filesystem\\Filesystem',
            'knplabs_gaufrette.adapter.in_memory.class' => 'Gaufrette\\Filesystem\\Adapter\\InMemory',
            'knplabs_gaufrette.adapter.local.class' => 'Gaufrette\\Filesystem\\Adapter\\Local',
            'knplabs_gaufrette.adapter.safe_local.class' => 'Gaufrette\\Filesystem\\Adapter\\SafeLocal',
            'kernel.compiled_classes' => array(
            ),
        );
    }
}
