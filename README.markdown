Gaufrette Bundle
================

Provides a [Gaufrette][gaufrette-homepage] integration for your Symfony projects.

About Gaufrette
---------------

Gaufrette is a PHP 5.3+ library providing a filesystem abstraction layer.
This abstraction layer permits you to develop your applications without the need to know were all their medias will be stored and how.

Documentation is available the [official page of Gaufrette][gaufrette-homepage].

Installation
------------

## Prerequisites

As this bundle is an integration for Symfony of the [Gaufrette][gaufrette-homepage] library, it requires you to first install [Gaufrette][gaufrette-homepage] in a Symfony project.

## Download the bundle

You can download an archive of the bundle and unpack it in the `vendor/bundles/Knplabs/Bundle/GaufretteBundle` directory of your application.

If you are versioning your project with git, you had better to embed it as a submodule:

    $ git submodule add https://github.com/knplabs/GaufretteBundle.git vendor/bundles/Knplabs/Bundle/GaufretteBundle

## Add the namespace in the autoloader

If the `Knplabs` namespace is not already defined in your autoloader, you must add it:

``` php
<?php

// app/autoload.php

$loader->registerNamespaces(array(

    'Knplabs\Bundle'                => __DIR__.'/../vendor/bundles'

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

        new Knplabs\Bundle\GaufretteBundle\KnplabsGaufretteBundle()
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
knplabs_gaufrette:
    adapters:
        foo:
            local:
                directory: /path/to/my/filesystem
```

The defined adapters are usable to create the filesystems.

## Configuring the Filesystems

``` yaml
# app/config/config.yml
knplabs_gaufrette:
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
$container->get('knplabs_gaufrette.filesystem_map')->get('bar');
```

Returns the instance of `Gaufrette\Filesystem` for `bar`.

Adapters Reference
------------------

## Local Adapter

A simple local filesystem based adapter.

### Parameters

 * `directory` The directory of the filesystem *(required)*
 * `create` Whether to create the directory if it does not exist *(default true)*

### Exemple

``` yaml
# app/config/config.yml
knplabs_gaufrette:
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

### Exemple

``` yaml
# app/config/config.yml
knplabs_gaufrette:
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

### Exemple

``` yaml
# app/config/config.yml
knplabs_gaufrette:
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

### Exemple

``` yaml
# app/config/config.yml
knplabs_gaufrette:
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

[gaufrette-homepage]: https://github.com/knplabs/Gaufrette
