<?php

namespace Knp\Bundle\GaufretteBundle\Tests;

use Symfony\Component\HttpKernel\Util\Filesystem;

class FunctionalTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->cacheDir = __DIR__.'/Resources/cache';
        if (file_exists($this->cacheDir)) {
            $filesystem = new Filesystem();
            $filesystem->remove($this->cacheDir);
        }

        mkdir($this->cacheDir, 0777, true);
    }

    /**
     * @dataProvider getConfigurationData
     */
    public function testConfiguration($env, array $filesystems)
    {
        $kernel = new TestKernel($env, false);
        $kernel->boot();

        $container = $kernel->getContainer();

        foreach ($filesystems as $id => $adapterClass) {
            $this->assertTrue($container->has($id), sprintf('Filesystem service \'%s\' exists.', $id));

            $filesystem = $container->get($id);
            $this->assertInstanceOf('Gaufrette\Filesystem\Filesystem', $filesystem);

            $reflProperty = new \ReflectionProperty($filesystem, 'adapter');
            $reflProperty->setAccessible(true);

            $adapter = $reflProperty->getValue($filesystem);

            $reflProperty->setAccessible(false);

            $this->assertInstanceOf($adapterClass, $adapter);
        }
    }

    public function getConfigurationData()
    {
        return array(
            array(
                'dev',
                array(
                    'gaufrette.foo_filesystem'  => 'Gaufrette\Filesystem\Adapter\Local',
                    'foo_filesystem'            => 'Gaufrette\Filesystem\Adapter\Local',
                )
            ),
            array(
                'test',
                array(
                    'gaufrette.foo_filesystem'  => 'Gaufrette\Filesystem\Adapter\InMemory',
                    'foo_filesystem'            => 'Gaufrette\Filesystem\Adapter\InMemory',
                )
            )
        );
    }
}
