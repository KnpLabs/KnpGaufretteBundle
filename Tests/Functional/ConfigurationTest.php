<?php

namespace Knp\Bundle\GaufretteBundle\Tests\Functional;

use Symfony\Component\HttpKernel\Util\Filesystem;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    private $cacheDir;
    private $kernel;

    public function setUp()
    {
        $this->cacheDir = __DIR__.'/Resources/cache';
        if (file_exists($this->cacheDir)) {
            $filesystem = new Filesystem();
            $filesystem->remove($this->cacheDir);
        }

        mkdir($this->cacheDir, 0777, true);

        $this->kernel = new TestKernel('test', false);
        $this->kernel->boot();
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
        $this->assertInstanceOf('Gaufrette\Filesystem', $this->kernel->getContainer()->get('foo_filesystem'));
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
        $this->assertInstanceOf('Knp\Bundle\GaufretteBundle\FilesystemMap', $this->kernel->getContainer()->get('knp_gaufrette.filesystem_map'));
    }

    /**
     * @test
     */
    public function shouldAllowAccessToFilesystemThoughFilesystemMap()
    {
        $this->assertInstanceOf('Gaufrette\Filesystem', $this->kernel->getContainer()->get('knp_gaufrette.filesystem_map')->get('foo'));
    }

    /**
     * @test
     */
    public function shouldAllowAccessToLocalFilesystem()
    {
        $this->assertInstanceOf('Gaufrette\Adapter\Local', $this->kernel->getContainer()->get('foo_filesystem')->getAdapter());
    }

    /**
     * @test
     */
    public function shouldAllowAccessToCacheFilesystem()
    {
        $this->assertInstanceOf('Gaufrette\Adapter\Cache', $this->kernel->getContainer()->get('cache_filesystem')->getAdapter());
    }

    /**
     * @test
     */
    public function shouldAllowAccessToFtpFilesystem()
    {
        $this->assertInstanceOf('Gaufrette\Adapter\Ftp', $this->kernel->getContainer()->get('ftp_filesystem')->getAdapter());
    }
}
