<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Adapter;
use Gaufrette\Adapter;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\PhpseclibSftp;
use Gaufrette\Adapter\ListKeysAware;
use Gaufrette\Adapter\FileFactory;

class LazyLoadedPhpseclibSftpAdapter implements Adapter, FileFactory, ListKeysAware
{

    private $adapter;
    private $host;
    private $username;
    private $password;
    private $directory;
    private $create;

    /**
     * @param string $host
     * @param string $user
     * @param string $pass
     */
    public function __construct($host, $directory = null, $create = false, $username = false, $password = false)
    {
        $this->host = $host;
        $this->directory = $directory;
        $this->create = $create;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Lazy loads the PhpseclibSftp adapter to prevent sftp connection until the adapter is being used
     * @return PhpseclibSftp
     */
    private function getAdapter()
    {
        if ($this->adapter) {
            return $this->adapter;
        }
        $sftp = new \Net_SFTP($this->host);
        if ($this->username && $this->password) {
            $sftp->login($this->username, $this->password);
        }
        $phpseclibSftp = new PhpseclibSftp($sftp, $this->directory, $this->create);
        $this->adapter = $phpseclibSftp;

        return $this->adapter;
    }

    public function read($key)
    {
        return $this->getAdapter()->read($key);
    }

    public function write($key, $content)
    {
        return $this->getAdapter()->write($key, $content);
    }

    public function exists($key)
    {
        return $this->getAdapter()->exists($key);
    }

    public function keys()
    {
        return $this->getAdapter()->keys();
    }

    public function mtime($key)
    {
        return $this->getAdapter()->mtime($key);
    }

    public function delete($key)
    {
        return $this->getAdapter()->delete($key);
    }

    public function rename($sourceKey, $targetKey)
    {
        return $this->getAdapter()->rename($key);
    }

    public function isDirectory($key)
    {
        return $this->getAdapter()->isDirectory($key);
    }

    public function listKeys($prefix = '')
    {
        return $this->getAdapter()->listKeys($prefix);
    }

    public function createFile($key, Filesystem $filesystem)
    {
        return $this->getAdapter()->createFile($key, $filesystem);
    }
}
