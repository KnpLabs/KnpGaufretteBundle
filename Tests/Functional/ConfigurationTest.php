<?php

namespace Knp\Bundle\GaufretteBundle\Tests\Functional;

use Symfony\Component\HttpKernel\Util\Filesystem;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    private $cacheDir;

    public function setUp()
    {
        $this->cacheDir = __DIR__.'/Resources/cache';
        if (file_exists($this->cacheDir)) {
            $filesystem = new Filesystem();
            $filesystem->remove($this->cacheDir);
        }

        mkdir($this->cacheDir, 0777, true);
    }

    public function tearDown()
    {
        if (file_exists($this->cacheDir)) {
            $filesystem = new Filesystem();
            $filesystem->remove($this->cacheDir);
        }
    }

    /**
     * @test
     */
    public function shouldAllowForFilesystemAlias()
    {
        $kernel = new TestKernel('test', false);
        $kernel->boot();

        $container = $kernel->getContainer();

        $this->assertInstanceOf('Gaufrette\Filesystem', $container->get('foo_filesystem'));
    }

    /**
     * @test
     */
    public function shouldWorkForOtherEnv()
    {
        $kernel = new TestKernel('dev', false);
        $kernel->boot();

        $container = $kernel->getContainer();
        $this->assertInstanceOf('Gaufrette\Filesystem', $container->get('foo_filesystem'));
    }

    /**
     * @test
     */
    public function shouldAllowAccessToAllPublicServices()
    {
        $kernel = new TestKernel('dev', false);
        $kernel->boot();

        $container = $kernel->getContainer();
        $this->assertInstanceOf('Gaufrette\Filesystem', $container->get('foo_filesystem'));
        $this->assertInstanceOf('Knp\Bundle\GaufretteBundle\FilesystemMap', $container->get('knp_gaufrette.filesystem_map'));
    }

    /**
     * @test
     */
    public function shouldAllowAccessToFilesystemThoughFilesystemMap()
    {
        $kernel = new TestKernel('test', false);
        $kernel->boot();

        $container = $kernel->getContainer();
        $this->assertInstanceOf('Gaufrette\Filesystem', $container->get('knp_gaufrette.filesystem_map')->get('foo'));
    }
}
