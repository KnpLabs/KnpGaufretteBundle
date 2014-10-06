<?php

namespace Knp\Bundle\GaufretteBundle\Tests\Functional\Resources\Adapter;

use Gaufrette\Adapter;
use Gaufrette\Util;
use Predis\ClientInterface;

/**
 * Redis
 */
class Redis implements Adapter
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var string
     */
    protected $hash;

    /**
     * @param ClientInterface $client
     * @param string          $hash
     */
    public function __construct(ClientInterface $client, $hash)
    {
        $this->client = $client;
        $this->hash = $hash;
    }

    /**
     * {@inheritDoc}
     */
    public function read($key)
    {
        return $this->client->executeCommand(
            $this->client->createCommand('HGET', [$this->hash, $key])
        );
    }

    /**
     * Renames a file
     *
     * @param string $sourceKey
     * @param string $targetKey
     *
     * @return boolean
     *
     * throws \Gaufrette\Exception\FileNotFound
     */
    public function rename($sourceKey, $targetKey)
    {
        $contentCopy = $this->read($sourceKey);
        $this->delete($sourceKey);

        return (boolean) $this->write($targetKey, $contentCopy);
    }

    /**
     * {@inheritDoc}
     */
    public function write($key, $content, array $metadata = null)
    {
        return $this->client->executeCommand(
            $this->client->createCommand('HSET', [$this->hash, $key, $content])
        );
    }

    /**
     * {@inheritDoc}
     */
    public function exists($key)
    {
        return $this->client->executeCommand(
            $this->client->createCommand('HEXISTS', [$this->hash, $key])
        );
    }

    /**
     * {@inheritDoc}
     */
    public function keys()
    {
        return $this->client->executeCommand(
            $this->client->createCommand('HKEYS', [$this->hash])
        );
    }

    /**
     * {@inheritDoc}
     */
    public function mtime($key)
    {
        //@todo not implemented yet since we'll not need this right now, mtime is the timestamp for the key
    }

    /**
     * {@inheritDoc}
     */
    public function delete($key)
    {
        return $this->client->executeCommand(
            $this->client->createCommand('HDEL', [$this->hash, $key])
        );
    }

    /**
     * {@inheritDoc}
     */
    public function isDirectory($path)
    {
        return false;
    }
}
