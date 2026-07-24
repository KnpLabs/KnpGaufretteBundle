<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Knp\Bundle\GaufretteBundle\FilesystemMap;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\InMemory;
use Gaufrette\Adapter\Local;
use Gaufrette\Adapter\SafeLocal;
use Gaufrette\Adapter\AsyncAwsS3;
use Gaufrette\Adapter\AwsS3;
use Gaufrette\Adapter\DoctrineDbal;
use Gaufrette\Adapter\OpenCloud;
use Gaufrette\Adapter\AzureBlobStorage;
use Gaufrette\Adapter\GoogleCloudStorage;
use Gaufrette\Adapter\GridFS;
use Gaufrette\Adapter\Ftp;
use Gaufrette\Adapter\PhpseclibSftp;
use Knp\Bundle\GaufretteBundle\Command\FilesystemKeysCommand;

return function (ContainerConfigurator $configurator) {
    $parameters = $configurator->parameters();
    $services = $configurator->services();

    $parameters->set('knp_gaufrette.filesystem_map.class', FilesystemMap::class);

    $services
        ->set('knp_gaufrette.filesystem', Filesystem::class)
        ->abstract()
        ->public()
        ->arg(0, null) // The Adapter
    ;

    $services
        ->set('knp_gaufrette.adapter.in_memory', InMemory::class)
        ->abstract()
        ->private()
        ->arg(0, null) // Files
    ;

    $services
        ->set('knp_gaufrette.adapter.local', Local::class)
        ->abstract()
        ->private()
        ->arg(0, null)  // Directory
        ->arg(1, null)  // Create
    ;

    $services
        ->set('knp_gaufrette.adapter.safe_local', SafeLocal::class)
        ->abstract()
        ->private()
        ->arg(0, null)  // Directory
        ->arg(1, null)  // Create
    ;

    $services
        ->set('knp_gaufrette.adapter.async_aws_s3', AsyncAwsS3::class)
        ->abstract()
        ->private();

    $services
        ->set('knp_gaufrette.adapter.aws_s3', AwsS3::class)
        ->abstract()
        ->private();

    $services
        ->set('knp_gaufrette.adapter.doctrine_dbal', DoctrineDbal::class)
        ->abstract()
        ->private();

    $services
        ->set('knp_gaufrette.adapter.opencloud', OpenCloud::class)
        ->abstract()
        ->private()
        ->arg(0, null)  // ObjectStore
        ->arg(1, null)  // Container name
        ->arg(2, null)  // Create container
        ->arg(3, null)  // Detect content type
    ;

    $services
        ->set('knp_gaufrette.adapter.azure_blob_storage', AzureBlobStorage::class)
        ->abstract()
        ->private();

    $services
        ->set('knp_gaufrette.adapter.google_cloud_storage', GoogleCloudStorage::class)
        ->abstract()
        ->private();

    $services
        ->set('knp_gaufrette.adapter.gridfs', GridFS::class)
        ->abstract()
        ->private();

    $services
        ->set('knp_gaufrette.adapter.ftp', Ftp::class)
        ->abstract()
        ->private();

    $services
        ->set('knp_gaufrette.adapter.phpseclib_sftp', PhpseclibSftp::class)
        ->abstract()
        ->private();

    $services
        ->set('knp_gaufrette.filesystem_map', '%knp_gaufrette.filesystem_map.class%')
        ->public()
        ->arg(0, null)  // map of filesystems
    ;

    $services
        ->alias(FilesystemMap::class, 'knp_gaufrette.filesystem_map')
        ->private();

    $services
        ->set('knp_gaufrette.command.filesystem_keys', FilesystemKeysCommand::class)
        ->arg(0, service('knp_gaufrette.filesystem_map'))
        ->tag('console.command', ['command' => 'gaufrette:filesystem:keys']);
};
