<?php

namespace Knp\Bundle\GaufretteBundle;

use Gaufrette\FilesystemMapInterface;

/**
 * Holds references to all declared filesystems
 * and allows to access them through their name.
 */
class FilesystemMap implements \IteratorAggregate, FilesystemMapInterface
{
    /**
     * Map of filesystems indexed by their name.
     *
     * @var array
     */
    protected $maps;

    /**
     * Instantiates a new filesystem map.
     *
     * @param array $maps
     */
    public function __construct(array $maps)
    {
        $this->maps = $maps;
    }

    /**
     * Retrieves a filesystem by its name.
     *
     * @param string $name name of a filesystem
     *
     * @return \Gaufrette\Filesystem
     *
     * @throw \InvalidArgumentException if the filesystem does not exist
     */
    public function get($name)
    {
        if (!$this->has($name)) {
            throw new \InvalidArgumentException(sprintf('No filesystem is registered for name "%s"', $name));
        }

        return $this->maps[$name];
    }

    /**
     * @param string $name name of a filesystem
     *
     * @return bool
     */
    public function has($name)
    {
        return isset($this->maps[$name]);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->maps);
    }
}
