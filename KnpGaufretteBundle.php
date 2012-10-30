<?php

namespace Knp\Bundle\GaufretteBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Gaufrette\StreamWrapper;

/**
 * The Gaufrette Bundle
 *
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class KnpGaufretteBundle extends Bundle
{
    public function boot()
    {
        parent::boot();

        if (!$this->container->hasParameter('knp_gaufrette.stream_wrapper.protocol')
            || !$this->container->hasParameter('knp_gaufrette.stream_wrapper.filesystems')) {
            return;
        }

        StreamWrapper::register($this->container->getParameter('knp_gaufrette.stream_wrapper.protocol'));
        $wrapperFsMap = StreamWrapper::getFilesystemMap();

        $fileSystems = $this->container->getParameter('knp_gaufrette.stream_wrapper.filesystems');

        /*
         * If there are no filesystems configured to be wrapped,
         * all filesystems within the map will be wrapped.
         */
        if (empty($fileSystems)) {
            $fileSystems = $this->container->get('knp_gaufrette.filesystem_map');
            foreach ($fileSystems as $domain => $fileSystem) {
                $wrapperFsMap->set($domain, $fileSystem);
            }
        } else {
            foreach ($fileSystems as $domain => $fileSystem) {
                $wrapperFsMap->set($domain, $this->container->get('knp_gaufrette.filesystem_map')->get($fileSystem));
            }
        }
    }
}
