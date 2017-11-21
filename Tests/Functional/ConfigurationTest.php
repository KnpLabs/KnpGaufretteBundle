<?php

namespace Knp\Bundle\GaufretteBundle\Tests\Functional;

use Symfony\Component\Filesystem\Filesystem;
use Gaufrette\StreamWrapper;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
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
     * @functional
     */
    public function shouldAllowForFilesystemAlias()
    {
        $this->assertInstanceOf('Gaufrette\Filesystem', $this->kernel->getContainer()->get('foo_filesystem'));
    }

    /**
     * @test
     * @functional
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
     * @functional
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
     * @functional
     */
    public function shouldAllowAccessToLocalFilesystem()
    {
        $this->assertInstanceOf('Gaufrette\Adapter\Local', $this->kernel->getContainer()->get('foo_filesystem')->getAdapter());
    }

    /**
     * @test
     * @functional
     */
    public function shouldAllowAccessToCacheFilesystem()
    {
        $this->assertInstanceOf('Gaufrette\Adapter\Cache', $this->kernel->getContainer()->get('cache_filesystem')->getAdapter());
    }

    /**
     * @test
     * @functional
     */
    public function shouldAllowAccessToFtpFilesystem()
    {
        $this->assertInstanceOf('Gaufrette\Adapter\Ftp', $this->kernel->getContainer()->get('ftp_filesystem')->getAdapter());
    }

    /**
     * @test
     * @functional
     */
    public function shouldAllowToNotConfigureStreamWrapper()
    {
        $this->assertFalse($this->kernel->getContainer()->hasParameter('knp_gaufrette.stream_wrapper.protocol'));
    }

    /**
     * @test
     * @functional
     */
    public function shouldConfigureStreamWrapperWithDefaultValues()
    {
        $kernel = new TestKernel('wrapper_1', false);
        $kernel->boot();
        $container = $kernel->getContainer();

        $this->assertTrue($container->hasParameter('knp_gaufrette.stream_wrapper.protocol'));
        $this->assertEquals('gaufrette', $container->getParameter('knp_gaufrette.stream_wrapper.protocol'));

        $wrapperFsMap = StreamWrapper::getFilesystemMap();

        $expectedDomains = array(
            'foo',
            'cache',
            'ftp',
        );

        foreach ($expectedDomains as $eachExpectedDomain) {
            $this->assertTrue($wrapperFsMap->has($eachExpectedDomain));
        }
    }

    /**
     * @test
     * @functional
     */
    public function shouldAllowToDefineProtocolOfStreamWrapper()
    {
        $kernel = new TestKernel('wrapper_2', false);
        $kernel->boot();
        $container = $kernel->getContainer();

        $this->assertTrue($container->hasParameter('knp_gaufrette.stream_wrapper.protocol'));
        $this->assertEquals('tada', $container->getParameter('knp_gaufrette.stream_wrapper.protocol'));
    }

    /**
     * @test
     * @functional
     */
    public function shouldAllowToDefineWhichFileSystemsShouldBeAddToStreamWrapper()
    {
        $kernel = new TestKernel('wrapper_2', false);
        $kernel->boot();
        $container = $kernel->getContainer();
        $fileSystems = $container->getParameter('knp_gaufrette.stream_wrapper.filesystems');

        $this->assertEquals(array('pictures' => 'cache', 'text' => 'ftp'), $fileSystems);

        $wrapperFsMap = StreamWrapper::getFilesystemMap();

        foreach($fileSystems as $key => $fs) {
            $this->assertTrue($wrapperFsMap->has($key));
        }
    }

    /**
     * @test
     * @functional
     */
    public function shouldAllowToDefineFileSystemsWithoutDomain()
    {
        $kernel = new TestKernel('wrapper_3', false);
        $kernel->boot();
        $container = $kernel->getContainer();
        $fileSystems = $container->getParameter('knp_gaufrette.stream_wrapper.filesystems');

        $this->assertTrue($container->hasParameter('knp_gaufrette.stream_wrapper.protocol'));
        $this->assertEquals('tada', $container->getParameter('knp_gaufrette.stream_wrapper.protocol'));
        $this->assertEquals(array('cache' => 'cache', 'ftp' => 'ftp'), $fileSystems);

        $wrapperFsMap = StreamWrapper::getFilesystemMap();

        foreach($fileSystems as $key => $fs) {
            $this->assertTrue($wrapperFsMap->has($key));
        }
    }
}
