# Azure Blob Storage

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
It looks like this: `BlobEndpoint=http://<AccountName>.blob.core.windows.net/;AccountName=<AccountName>;AccountKey=<AccountKey>`.

## Parameters

 * `blob_proxy_factory_id` Reference to the blob proxy factory service
 * `container_name` The name of the container (*optional if the `multi_container_mode` is enabled*)
 * `create_container` Boolean value that indicates whether to create the container if it does not exists (*optional*: default *false*)
 * `detect_content_type` Boolean value that indicates whether to auto determinate and set the content type on new blobs (*optional*: default *true*)
 * `multi_container_mode` Boolean value that indicates whether multi-container mode is enabled (the container will be determined using the first part of the file key) (*optional*: default *false*) 

## Example

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

With multi-container mode enabled:

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            azure_blob_storage:
                blob_proxy_factory_id: azure_blob_proxy_factory
                container_name: ~
                mult_container_mode: true
```
