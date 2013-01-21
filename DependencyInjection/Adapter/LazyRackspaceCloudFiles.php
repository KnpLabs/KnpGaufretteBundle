<?php

namespace Knp\Bundle\GaufretteBundle\Adapter;

use \CF_Container as RackspaceContainer,
    \CF_Authentication as RackspaceAuthentication,
    \CF_Connection as RackspaceConnection;

use Gaufrette\Adapter\RackspaceCloudfiles;

/**
 * Rackspace cloudfiles adapter
 *
 * @package GaufretteBundle
 * @author  Luciano Mammino <lmammino@oryzone.com>
 */
class LazyRackspaceCloudfiles extends RackspaceCloudfiles
{
    /**
     * Constructor.
     * Creates a new Rackspace adapter starting from a rackspace authentication instance and a container name
     *
     * @param \CF_Authentication $authentication
     * @param string $containerName
     * @param bool $createContainer if <code>TRUE</code> will try to create the container if not existent. Default <code>FALSE</code>
     */
    public function __construct(RackspaceAuthentication $authentication, $containerName, $createContainer = FALSE)
    {
        if(!$authentication->authenticated())
            $authentication->authenticate();

        $conn = new RackspaceConnection($authentication);

        $container = NULL;
        if($createContainer)
            $container = $conn->create_container($containerName);
        else
            $container = $conn->get_container($containerName);

        parent::__construct($container);
    }

}