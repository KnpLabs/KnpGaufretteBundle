<?php

namespace Knp\Bundle\GaufretteBundle;

/**
 * Holds references to all declared filesystems
 * and allows to access them through their name
 */
class FilesystemMap
{
    /**
     * Map of filesystems indexed by their name
     *
     * @var array
     */
    protected $map;

    /**
     * Instanciates a new filesystem map
     *
     * @param array $map
     */
    public function __construct(array $map)
    {
        $this->map = $map;
    }

    /**
     * @param string $name name of a filesystem
     * @throw \InvalidArgumentException if the filesystem does not exist
     * @return Filesystem
     */
    public function get($name)
    {
        if (!isset($this->map[$name])) {
            throw new \InvalidArgumentException(sprintf('No filesystem register for name "%s"', $name));
        }

        return $this->map[$name];
    }
}
