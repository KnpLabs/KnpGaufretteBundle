<?php

namespace Knp\Bundle\GaufretteBundle\Tests;

use Knp\Bundle\GaufretteBundle\FilesystemMap;

class FilesystemMapTest extends \PHPUnit_Framework_TestCase
{
    private $filesystemMap;

    public function setUp()
    {
        $this->filesystemMap = new FilesystemMap(array('amazon_fs' => $this->getFilesystem(), 'local_fs' => $this->getFilesystem()));
    }

    /**
     * @test
     */
    public function shouldGetFilesystemByKey()
    {
        $this->assertInstanceOf('Gaufrette\Filesystem', $this->filesystemMap->get('amazon_fs'), 'should get filesystem object by key');
        $this->assertInstanceOf('Gaufrette\Filesystem', $this->filesystemMap->get('local_fs'), 'should get filesystem object by key');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function shouldNotGetFilesystemWhenKeyWasNotSet()
    {
        $this->filesystemMap->get('test');
    }

    /**
     * @return Gaufrette\Filesystem
     */
    private function getFilesystem()
    {
        return $this->getMockBuilder('Gaufrette\Filesystem')
            ->disableOriginalConstructor()
            ->getMock();
    }
}
