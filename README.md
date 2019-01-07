Gaufrette Bundle
================

[![Build Status](https://travis-ci.org/KnpLabs/KnpGaufretteBundle.svg?branch=master)](https://travis-ci.org/KnpLabs/KnpGaufretteBundle)

Provides a [Gaufrette][gaufrette-homepage] integration for your Symfony projects.

About Gaufrette
===============

Gaufrette is a PHP library providing a filesystem abstraction layer.
This abstraction layer allows you to develop applications without needing to know where all their media files will be stored or how.

Documentation is available the [official page of Gaufrette][gaufrette-homepage].

Installation
============

## Prerequisites

As this bundle is an integration for Symfony of the [Gaufrette][gaufrette-homepage] library, it requires you to first install [Gaufrette][gaufrette-homepage] in your project.

Note that, you need to install separately the adapters you want to use. You can find more details about these packages [here](https://github.com/KnpLabs/Gaufrette#metapackages-for-adapters),
and the full list adapters [on packagist](https://packagist.org/packages/gaufrette/).

## With composer

```bash
composer require knplabs/knp-gaufrette-bundle
```

## Register the bundle

You must register the bundle in your kernel:

``` php
<?php

return [
    // ...
    Knp\Bundle\GaufretteBundle\KnpGaufretteBundle::class                       => ['all' => true],
];
```

Configuration
=============

The Gaufrette bundle allows you to declare your filesystems as services without having to reach into the famous "Service Container".
Indeed, you can do it with the configuration!

The configuration of the Gaufrette bundle is divided into two parts: the `adapters` and the `filesystems`.

## Configuring the Adapters

``` yaml
# config/packages/knp_gaufrette.yaml
knp_gaufrette:
    adapters:
        foo:
            local:
                directory: /path/to/my/filesystem
```

The defined adapters are then used to create the filesystems.

You can use on of these adapters:
* [Local Adapter](Resources/docs/adapters/local.md)
* [Safe Local Adapter](Resources/docs/adapters/safe_local.md)
* [Service](Resources/docs/adapters/service.md)
* [In Memory](Resources/docs/adapters/memory.md)
* [Azure Blob Storage](Resources/docs/adapters/azure.md)
* [GridFS](Resources/docs/adapters/gridfs.md)
* [MogileFS](Resources/docs/adapters/mogilefs.md)
* [Ftp](Resources/docs/adapters/ftp.md)
* [Sftp](Resources/docs/adapters/sftp.md)
* [Phpseclib Sftp](Resources/docs/adapters/phpseclib_sftp.md)
* [Apc](Resources/docs/adapters/apc.md)
* [AWS S3](Resources/docs/adapters/awss3.md)
* [Open Cloud](Resources/docs/adapters/opencloud.md)
* [GoogleCloudStorage](Resources/docs/adapters/googlecloud.md)
* [Cache](Resources/docs/adapters/cache.md)
* [Stream Wrapper](Resources/docs/stream.md)
* [Doctrine DBAL](Resources/docs/adapters/doctrine_dbal.md)
* [Dropbox](Resources/docs/adapters/dropbox.md)

## Configuring the Filesystems

``` yaml
# config/packages/knp_gaufrette.yaml
knp_gaufrette:
    adapters:
        # ...
    filesystems:
        bar:
            adapter:    foo
            alias:      foo_filesystem
```

Each defined filesystem must have an `adapter` with its value set to an adapter's key.
The filesystem defined above will result in a service with id `gaufrette.bar_filesystem`.
The `alias` parameter allows us to define an alias for it (`foo_filesystem` in this case).

The filesystem map
==================

You can access all declared filesystems through the map service.
In the previous exemple, we declared a `bar` filesystem:

``` php
$container->get('knp_gaufrette.filesystem_map')->get('bar');
```

Returns the `bar` instance of `Gaufrette\Filesystem`.

Use cases
==================

[Check out](https://github.com/KnpLabs/KnpGaufretteBundle/blob/master/Resources/docs/use-case-examples.md) basic examples of the library.

[gaufrette-homepage]: https://github.com/KnpLabs/Gaufrette

## Maintainers

- [@NiR-](https://github.com/NiR-)
- [@nicolasmure](https://github.com/nicolasmure)
