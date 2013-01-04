<?php

namespace Knp\Bundle\GaufretteBundle;

/**
 * Holds references to all declared filesystems
 * and allows to access them through their name
 */
class FilesystemMap implements \IteratorAggregate
{
    /**
     * Map of filesystems indexed by their name
     *
     * @var array
     */
    protected $map;

    /**
     * Instantiates a new filesystem map
     *
     * @param array $map
     */
    public function __construct(array $map)
    {
        $this->map = $map;
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
        if (!isset($this->map[$name])) {
            throw new \InvalidArgumentException(sprintf('No filesystem register for name "%s"', $name));
        }

        return $this->map[$name];
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->map);
    }
}
