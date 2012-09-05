Gaufrette Bundle
================

Provides a [Gaufrette][gaufrette-homepage] integration for your Symfony projects.

About Gaufrette
---------------

Gaufrette is a PHP 5.3+ library providing a filesystem abstraction layer.
This abstraction layer permits you to develop your applications without the need to know where all their medias will be stored and how.

Documentation is available the [official page of Gaufrette][gaufrette-homepage].

Installation
------------

## Prerequisites

As this bundle is an integration for Symfony of the [Gaufrette][gaufrette-homepage] library, it requires you to first install [Gaufrette][gaufrette-homepage] in a Symfony project.

## Download the bundle

You can download an archive of the bundle and unpack it in the `vendor/bundles/Knp/Bundle/GaufretteBundle` directory of your application.

### Standard Edition Style

If you are using the `deps` file to manage your project's dependencies,
you must add the following lines to it:

    [gaufrette]
        git=http://github.com/KnpLabs/Gaufrette.git

    [KnpGaufretteBundle]
        git=http://github.com/KnpLabs/KnpGaufretteBundle.git
        target=/bundles/Knp/Bundle/GaufretteBundle

### Composer Style

Bundle can be installed using composer by add to require `composer.json` part `"knplabs/knp-gaufrette-bundle": "dev-master"` line.

### Git Submodule Style

If you are versioning your project with git, you had better to embed it
as a submodule:

    $ git submodule add https://github.com/KnpLabs/KnpGaufretteBundle.git vendor/bundles/Knp/Bundle/GaufretteBundle

## Add the namespace in the autoloader 

You must register both Gaufrette and the KnpGaufretteBundle in your autoloader:
You do not have to do that if you are using composer autoload system.

``` php
<?php

// app/autoload.php

$loader->registerNamespaces(array(
    'Knp\Bundle'                => __DIR__.'/../vendor/bundles',
    'Gaufrette'                 => __DIR__.'/../vendor/gaufrette/src',
    // ...
));
```

## Register the bundle

You must register the bundle in your kernel:

``` php
<?php

// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(

        // ...

        new Knp\Bundle\GaufretteBundle\KnpGaufretteBundle()
    );

    // ...
}
```

Configuration
-------------

The Gaufrette bundle allows you to declare your filesystems as services without having to reach into the famous "Service Container".
Indeed, you can do it with the configuration!

The configuration of the Gaufrette bundle is divided into two parts: the `adapters` and the `filesystems`.

## Configuring the Adapters

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            local:
                directory: /path/to/my/filesystem
```

The defined adapters are usable to create the filesystems.

## Configuring the Filesystems

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        # ...
    filesystems:
        bar:
            adapter:    foo
            alias:      foo_filesystem
```

Each defined filesystem must have an `adapter` with the key of an adapter as value.
The filesystem defined above with result in a service with id `gaufrette.bar_filesystem`.
The `alias` parameter permits to also defines an alias for it.

The filesystem map
------------------

You can access to all declared filesystems through the map service.
In the previous exemple, we declared a `bar` filesystem:

``` php
$container->get('knp_gaufrette.filesystem_map')->get('bar');
```

Returns the instance of `Gaufrette\Filesystem` for `bar`.

Adapters Reference
------------------

## Local Adapter

A simple local filesystem based adapter.

### Parameters

 * `directory` The directory of the filesystem *(required)*
 * `create` Whether to create the directory if it does not exist *(default true)*

### Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            local:
                directory:  /path/to/my/filesystem
                create:     true
```

## Safe Local Adapter (safe\_local)

Almost as simple as the **local** adapter, but it encodes key to avoid having to deal with the directories structure.

### Parameters

 * `directory` The directory of the filesystem *(required)*
 * `create` Whether to create the directory if it does not exist *(default true)*

### Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            safe_local:
                directory:  /path/to/my/filesystem
                create:     true
```

## Service (service)

Allows you to use a user defined adapter service.

### Parameters

 * `id` The id of the service *(required)*

### Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            service:
                id:     my.adapter.service
```

## In Memory (in\_memory)

Adapter for test purposes, it stores files in an internal array.

### Parameters

 * `files` An array of files *(optional)*

The `files` is an array of files where each file is a sub-array having the `content`, `checksum` and `mtime` optional keys.

### Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            in_memory:
                files:
                    'file1.txt':    ~
                    'file2.txt':
                        content:    Some content
                        checksum:   abc1efg2hij3
                        mtime:      123456890123
```

## GridFS (gridfs)

Adapter that allows you to use a MongoDB GridFS for storing files.

### Parameters

 * `mongogridfs_id` The id of the service that provides MongoGridFS object instance for adapter *(required)*

### Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            gridfs:
                mongogridfs_id: acme_test.gridfs
```

In your AcmeTestBundle, add following service definitions:

``` yaml
# src/Acme/TestBundle/Resources/config/services.yml
parameters:
    acme_test.mongo.server: "mongodb://localhost:27017"
    acme_test.mongo.options:
        connect: true
    acme_test.mongodb.name: "test_database"
    acme_test.gridfs.prefix: "fs" #Default
services:
    acme_test.mongo:
        class: Mongo
        arguments: [%acme_test.mongo.server%, %acme_test.mongo.options%]
    acme_test.mongodb:
        class: MongoDB
        arguments: [@acme_test.mongo, %acme_test.mongodb.name%]
    acme_test.gridfs:
        class: MongoGridFS
        arguments: [@acme_test.mongodb, %acme_test.gridfs.prefix%]
```

Note that it is possible to prepare MongoGridFS service anyway you like. This is just one way to do it.

## MogileFS (mogilefs)

Adapter that allows you to use MogileFS for storing files.

### Parameters

 * `domain` MogileFS domain
 * `hosts` Available trackers

### Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            mogilefs:
                domain: foobar
                hosts: ["192.168.0.1:7001", "192.168.0.2:7001"]
```

[gaufrette-homepage]: https://github.com/KnpLabs/Gaufrette

## Ftp

Adapter for FTP.

### Parameters

 * `directory` The directory of the filesystem *(required)*
 * `host` FTP host *(required)*
 * `username` FTP username *(default null)*
 * `password` FTP password *(default null)*
 * `port` FTP port *(default 21)*
 * `passive` FTP passive mode *(default false)*
 * `create` Whether to create the directory if it does not exist *(default false)*
 * `mode` FTP transfer mode *(defaut FTP_ASCII)*

### Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            ftp:
                host: example.com
                username: user
                password: pass
                directory: /example/ftp
                create: true
                mode: FTP_BINARY
```

## Apc

Adapter for APC.

A non-persistent adapter, use it in the dev environment, in demo sites, ...

### Parameters

 * `prefix` The prefix to this filesystem (APC 'namespace', it is recommended that this end in a dot '.') *(required)*
 * `ttl` Time to live *(default 0)*

### Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            apc:
                prefix: APC 'namespace' prefix
                ttl: 0
```

## Cache 

Adapter which allow to cache other adapters

### Parameters

 * `source` The source adapter that must be cached *(required)*
 * `cache` The adapter used to cache the source *(required)*
 * `ttl` Time to live *(default 0)*
 * `serializer` The adapter used to cache serializations *(default null)*

### Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        media_ftp:
            ftp:
                host: example.com
                username: user
                password: pass
                directory: /example/ftp
                create: true
                mode: FTP_BINARY
        media_apc:
            apc:
                prefix: APC 'namespace' prefix
                ttl: 0
        media_cache:
            cache:
                source: media_ftp
                cache: media_apc
                ttl: 7200
    filesystems:
        media:
            adapter: media_cache
```
