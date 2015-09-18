Gaufrette Bundle
================

Provides a [Gaufrette][gaufrette-homepage] integration for your Symfony projects.

About Gaufrette
---------------

Gaufrette is a PHP 5.3+ library providing a filesystem abstraction layer.
This abstraction layer allows you to develop applications without needing to know where all their media files will be stored or how.

Documentation is available the [official page of Gaufrette][gaufrette-homepage].

Installation
------------

## Prerequisites

As this bundle is an integration for Symfony of the [Gaufrette][gaufrette-homepage] library, it requires you to first install [Gaufrette][gaufrette-homepage] in a Symfony project.

## With composer

This bundle can be installed using [composer](http://getcomposer.org) by adding the following in the `require` section of your `composer.json` file:

``` json
    "require": {
        ...
        "knplabs/knp-gaufrette-bundle": "*@dev"
    },
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

The defined adapters are then used to create the filesystems.

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

Each defined filesystem must have an `adapter` with its value set to an adapter's key.
The filesystem defined above will result in a service with id `gaufrette.bar_filesystem`.
The `alias` parameter allows us to define an alias for it (`foo_filesystem` in this case).

The filesystem map
------------------

You can access all declared filesystems through the map service.
In the previous exemple, we declared a `bar` filesystem:

``` php
$container->get('knp_gaufrette.filesystem_map')->get('bar');
```

Returns the `bar` instance of `Gaufrette\Filesystem`.

Adapters Reference
------------------

## Local Adapter (local)

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

## Azure Blob Storage (azure\_blob\_storage)

Adapter for Microsoft Azure Blob Storage service. To use this adapter you need to install the
[Azure SDK for php](http://www.windowsazure.com/en-us/develop/php/common-tasks/download-php-sdk/) into your project.

Further more you need a valid *connection string* and you must define a Blob Proxy factory service with it. You can use
the default `\Gaufrette\Adapter\AzureBlobStorage\BlobProxyFactory` this way:

``` yaml
# app/config/config.yml
services:
    azure_blob_proxy_factory:
        class: Gaufrette\Adapter\AzureBlobStorage\BlobProxyFactory
        arguments: [%azure_blob_storage_connection_string%]
```

You must set the parameter `azure_blob_storage_connection_string` to contain your windows azure blob storage connection
string. You can retrieve your connection string in your [Windows Azure management console](https://manage.windowsazure.com).

### Parameters

 * `blob_proxy_factory_id` Reference to the blob proxy factory service
 * `container_name` The name of the container
 * `create_container` Boolean value that indicates whether to create the container if it does not exists (*optional*: default *false*)
 * `detect_content_type` Boolean value that indicates whether to auto determinate and set the content type on new blobs (*optional*: default *true*)

### Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            azure_blob_storage:
                blob_proxy_factory_id: azure_blob_proxy_factory
                container_name: my_container
                create_container: true
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

Note that it is possible to prepare MongoGridFS service any way you like. This is just one way to do it.

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

## Ftp (ftp)

Adapter for FTP.

### Parameters

 * `directory` The remote directory *(required)*
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

## Sftp (sftp)

Adapter for SFTP (SSH-FTP).

### Parameters

 * `sftp_id` The id of the service that provides SFTP access.
 * `directory` The remote directory *(default null)*.
 * `create` Whether to create the directory if it does not exist *(default false)*.

### Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            sftp:
                sftp_id: acme_test.sftp
                directory: /example/sftp
                create: true
```

In your AcmeTestBundle, add following service definitions:

``` yaml
# src/Acme/TestBundle/Resources/config/services.yml
parameters:
    acme_test.ssh.host: my_host_name
    acme_test.ssh.username: user_name
    acme_test.ssh.password: some_secret

services:
    acme_test.ssh.configuration:
        class: Ssh\Configuration
        arguments: [%acme_test.ssh.host%]

    acme_test.ssh.authentication:
        class: Ssh\Authentication\Password
        arguments: [%acme_test.ssh.username%, %acme_test.ssh.password%]

    acme_test.ssh.session:
        class: Ssh\Session
        arguments: [@acme_test.ssh.configuration, @acme_test.ssh.authentication]

    acme_test.sftp:
        class: Ssh\Sftp
        arguments: [@acme_test.ssh.session]
```

## Phpseclib Sftp (phpseclib_sftp)

Adapter for phpseclib SFTP (SSH-FTP).

### Parameters

 * `phpseclib_sftp_id` The id of the service that provides SFTP access.
 * `directory` The remote directory *(default null)*.
 * `create` Whether to create the directory if it does not exist *(default false)*.

### Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            phpseclib_sftp:
                phpseclib_sftp_id: acme_test.sftp
                directory: /example/sftp
                create: true
```

In your AcmeTestBundle, add following service definitions:

``` yaml
# src/Acme/TestBundle/Resources/config/services.yml
parameters:
    acme_test.ssh.host: my_host_name
    acme_test.ssh.username: user_name
    acme_test.ssh.password: some_secret

services:
    acme_test.sftp:
        class: Net_SFTP
        arguments: [%acme_test.ssh.host%]
        calls:
            - [login, [%acme_test.ssh.username%, %acme_test.ssh.password%]]

```

## Apc (apc)

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

## Amazon S3 (amazon_s3)

Adapter to connect to Amazon S3 instances.

This adapter requires the use of amazonwebservices/aws-sdk-for-php which can be installed by adding the following line to your composer.json:

```
    "require": {
        ...
        "amazonwebservices/aws-sdk-for-php": "1.6.2"
    },
```

### Parameters

 * `amazon_s3_id`: the id of the AmazonS3 service used for the underlying connection
 * `bucket_name`: the name of the bucket to use
 * `options`: additional (optional) settings
   * `directory`: the directory to use, within the specified bucket
   * `region`
   * `create`

### Defining services

To use the Amazon S3 adapter you need to provide a valid `AmazonS3` instance (as defined in the Amazon SDK). This can
easily be set up as using Symfony's service configuration:

``` yaml
# app/config/config.yml
services:
    amazonS3:
        class: AmazonS3
        arguments:
            options:
                key:      '%aws_key%'
                secret:   '%aws_secret_key%'
```

### Example

Once the service is set up use its key as the amazon_s3_id in the gaufrette configuration:

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            amazon_s3:
                amazon_s3_id:   amazonS3
                bucket_name:    foo_bucket
                options:
                    directory:  foo_directory
```

Note that the SDK seems to have some issues with bucket names with dots in them, e.g. "com.mycompany.bucket" seems to have issues but "com-mycompany-bucket" works.

## AwsS3

Adapter for Amazon S3 SDK v2.

### Parameters

 * `service_id` The service id of the `Aws\S3\S3Client` to use. *(required)*
 * `bucket_name` The name of the S3 bucket to use. *(required)*
 * `options` A list of additional options passed to the adapter.
   * `create` Whether to create the bucket if it doesn't exist. *(default false)*
   * `directory` A directory to operate in. *(default '')*
   This directory will be created in the root of the bucket and all files will be read and written there.

### Defining services

An example service definition of the `Aws\S3\S3Client`:

```yaml
services:
    acme.aws_s3.client:
        class: Aws\S3\S3Client
        factory_class: Aws\S3\S3Client
        factory_method: 'factory'
        arguments:
            -
                key: %amazon_s3.key%
                secret: %amazon_s3.secret%
                region: %amazon_s3.region%
```

### Example

Once the service is set up use its key as the `service_id` in the gaufrette configuration:

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        profile_photos:
            aws_s3:
                service_id: 'acme.aws_s3.client'
                bucket_name: 'images'
                options:
                    directory: 'profile_photos'
```

## Open Cloud (opencloud)

Adapter for OpenCloud (Rackspace)

### Parameters

 * `object_store_id`: the id of the object store service
 * `container_name`: the name of the container to use
 * `create_container`: if `true` will create the container if it doesn't exist *(default `false`)*
 * `detect_content_type`: if `true` will detect the content type for each file *(default `true`)*

### Defining services

To use the OpenCloud adapter you should provide a valid `ObjectStore` instance. You can retrieve an instance through the
`OpenCloud\OpenStack` or `OpenCloud\Rackspace` instances. We can provide a comprehensive configuration through the Symfony
DIC configuration.

#### Define OpenStack/Rackspace service

Generic OpenStack:

``` yaml
# app/config/config.yml
services:
    opencloud.connection:
        class: OpenCloud\OpenStack
        arguments:
          - %openstack_identity_url%
          - {username: %openstack_username%, password: %openstack_password%, tenantName: %openstack_tenant_name%}
```

HPCloud:

``` yaml
# app/config/config.yml
services:
    opencloud.connection.hpcloud:
        class: OpenCloud\OpenStack
        arguments:
          - 'https://region-a.geo-1.identity.hpcloudsvc.com:123456/v2.0/' // check https://account.hpcloud.com/account/api_keys for identities urls
          - {username: %hpcloud_username%, password: %hpcloud_password%, tenantName: %hpcloud_tenant_name%}
```
The username and password are your login credentials, not the api key. Your tenantName is your Project Name on the api keys page.

Rackspace:

``` yaml
# app/config/config.yml
services:
    opencloud.connection.rackspace:
        class: OpenCloud\Rackspace
        arguments:
          - 'https://identity.api.rackspacecloud.com/v2.0/'
          - {username: %rackspace_username%, apiKey: %rackspace_apikey%}
```

#### Define ObjectStore service

HPCloud:

``` yaml
# app/config/config.yml
services:
    opencloud.object_store:
        class: OpenCloud\ObjectStoreBase
        factory_service: opencloud.connection.hpcloud
        factory_method: ObjectStore
        arguments:
          - 'Object Storage' # Object storage type
          - 'region-a.geo-1' # Object storage region
          - 'publicURL' # url type
```

Rackspace:

``` yaml
# app/config/config.yml
services:
    opencloud.object_store:
        class: OpenCloud\ObjectStoreBase
        factory_service: opencloud.connection
        factory_method: objectStoreService
        arguments:
          - 'cloudFiles' # Object storage type
          - 'DFW' # Object storage region
          - 'publicURL' # url type
```

### Example

Finally you can define your adapter in configuration:

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            opencloud:
                object_store_id: opencloud.object_store
                container_name: foo
```

## Cache (cache)

Adapter which allows you to cache other adapters

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

## Stream Wrapper

The `stream_wrapper` settings allow you to register filesystems with a specified domain and
then use as a stream wrapper anywhere in your code like:
`gaufrette://domain/file.txt`

### Parameters

 * `protocol` The protocol name like `gaufrette://…` *(default gaufrette)*
 * `filesystem` An array that contains filesystems that you want to register to this stream_wrapper.
 If you set array keys these will be used as an alias for the filesystem (see examples below) *(default all filesystems without aliases)*

### Example 1

Using default settings, the protocol is "gaufrette" and all filesystems will be served

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        backup: #...
        amazon: #...

    filesystems:
        backup1:
            adapter: backup
        amazonS3:
            adapter: amazon

    stream_wrapper: ~
```

```
gaufrette://backup1/...
gaufrette://amazonS3/...
```

### Example 2

We define the protocol as "data", all filesystem will still be served (by default)

``` yaml
# app/config/config.yml
knp_gaufrette:
    filesystems:
        #...

    stream_wrapper:
        protocol: data
```

```
data://backup1/...
data://amazonS3/...
```

### Example 3

We define the protocol as data and define which filesystem(s) will be available

``` yaml
# app/config/config.yml
knp_gaufrette:
    filesystems:
        #...

    stream_wrapper:
        protocol: data
        filesystems:
            - backup1
```

```
data://backup1/... (works since it is defined above)
data://amazonS3/... (will not be available)
```

### Example 4

We define the protocol as data and define which filesystems will be available using array keys to set domain aliases

``` yaml
# app/config/config.yml
knp_gaufrette:
    filesystems:
        #...

    stream_wrapper:
        protocol: data
        filesystems:
            backup: backup1
            pictures: amazonS3
```

```
data://backup/...
data://pictures/...
```

## Doctrine DBAL (doctrine_dbal)

Adapter that allows you to store data into a database.

### Parameters

 * `connection_name` The doctrine dbal connection name like `default`
 * `table` The table name like `media_data`
 * `key`: The primary key in the table
 * `content`: The field name of the file content
 * `mtime`: The field name of the timestamp
 * `checksum`: The field name of the checksum

### Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        database:
            doctrine_dbal:
                connection_name: default
                table: data
                columns:
                    key: id
                    content: text
                    mtime: date
                    checksum: checksum
```

## Dropbox (dropbox)

Adapter for Dropbox. In order to use it, you should add `dropbox-php/dropbox-php` as your composer dependency.

### Parameters

 * `api_id` The id of the service that provides Dropbox API access.

### Example

> In order to get a Dropbox token and token_secret, you need to add a new Dropbox App in your account, and then you'll need to go through the oAuth authorization process

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            dropbox:
                api_id: acme_test.dropbox.api
```

In your AcmeTestBundle, add following service definitions:

``` yaml
# src/Acme/TestBundle/Resources/config/services.yml
parameters:
    acme_test.dropbox.key: my_consumer_key
    acme_test.dropbox.secret: my_consumer_secret
    acme_test.dropbox.token: some_token
    acme_test.dropbox.token_secret: some_token_secret

services:
    acme_test.dropbox.oauth:
        class: Dropbox_OAuth_Curl
        arguments: [%acme_test.dropbox.key%, %acme_test.dropbox.secret%]
        calls:
            - [setToken, ["%acme_test.dropbox.token%", "%acme_test.dropbox.token_secret%"]]
    acme_test.dropbox.api:
        class: Dropbox_API
        arguments: [@acme_test.dropbox.oauth, "sandbox"]
```

[gaufrette-homepage]: https://github.com/KnpLabs/Gaufrette
