<?php

namespace Knp\Bundle\GaufretteBundle\Tests;

use Knp\Bundle\GaufretteBundle\FilesystemMap;
use PHPUnit\Framework\TestCase;

class FilesystemMapTest extends TestCase
{
    private $filesystemMap;

    public function setUp(): void
    {
        $this->filesystemMap = new FilesystemMap(['amazon_fs' => $this->getFilesystem(), 'local_fs' => $this->getFilesystem()]);
    }

    /**
     * @test
     */
    public function shouldGetFilesystemByKey()
    {
        if(class_exists(\Gaufrette\FilesystemInterface::class)) {
            $this->assertInstanceOf(\Gaufrette\FilesystemInterface::class, $this->filesystemMap->get('amazon_fs'), 'should get filesystem object by key');
            $this->assertInstanceOf(\Gaufrette\FilesystemInterface::class, $this->filesystemMap->get('local_fs'), 'should get filesystem object by key');
        } else {
            $this->assertInstanceOf(\Gaufrette\Filesystem::class, $this->filesystemMap->get('amazon_fs'), 'should get filesystem object by key');
            $this->assertInstanceOf(\Gaufrette\Filesystem::class, $this->filesystemMap->get('local_fs'), 'should get filesystem object by key');
        }

    }

    /**
     * @test
     */
    public function shouldNotGetFilesystemWhenKeyWasNotSet()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->filesystemMap->get('test');
    }

    /**
     * @return Gaufrette\Filesystem
     */
    private function getFilesystem()
    {
        return $this->getMockBuilder(\Gaufrette\Filesystem::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}
