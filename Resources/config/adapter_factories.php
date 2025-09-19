<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

return function (ContainerConfigurator $configurator) {
    $services = $configurator->services();

    $services
        ->set('knp_gaufrette.adapter.factory.in_memory', Factory\InMemoryAdapterFactory::class)
        ->tag('gaufrette.adapter.factory');

    $services
        ->set('knp_gaufrette.adapter.factory.service', Factory\ServiceAdapterFactory::class)
        ->tag('gaufrette.adapter.factory');

    $services
        ->set('knp_gaufrette.adapter.factory.local', Factory\LocalAdapterFactory::class)
        ->tag('gaufrette.adapter.factory');

    $services
        ->set('knp_gaufrette.adapter.factory.safe_local', Factory\SafeLocalAdapterFactory::class)
        ->tag('gaufrette.adapter.factory');

    $services
        ->set('knp_gaufrette.adapter.factory.async_aws_s3', Factory\AsyncAwsS3AdapterFactory::class)
        ->tag('gaufrette.adapter.factory');

    $services
        ->set('knp_gaufrette.adapter.factory.aws_s3', Factory\AwsS3AdapterFactory::class)
        ->tag('gaufrette.adapter.factory');

    $services
        ->set('knp_gaufrette.adapter.factory.doctrine_dbal', Factory\DoctrineDbalAdapterFactory::class)
        ->tag('gaufrette.adapter.factory');

    $services
        ->set('knp_gaufrette.adapter.factory.azure_blob_storage', Factory\AzureBlobStorageAdapterFactory::class)
        ->tag('gaufrette.adapter.factory');

    $services
        ->set('knp_gaufrette.adapter.factory.google_cloud_storage', Factory\GoogleCloudStorageAdapterFactory::class)
        ->tag('gaufrette.adapter.factory');

    $services
        ->set('knp_gaufrette.adapter.factory.gridfs', Factory\GridFSAdapterFactory::class)
        ->tag('gaufrette.adapter.factory');

    $services
        ->set('knp_gaufrette.adapter.factory.ftp', Factory\FtpAdapterFactory::class)
        ->tag('gaufrette.adapter.factory');

    $services
        ->set('knp_gaufrette.adapter.factory.phpseclib_sftp', Factory\PhpseclibSftpAdapterFactory::class)
        ->tag('gaufrette.adapter.factory');
};
