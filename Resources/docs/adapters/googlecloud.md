# Google Cloud

Adapter for Google APIs Client Library for PHP.

```
composer require google/apiclient:^2.12
```

## Parameters

 * `service_id` The service id of the `\Google_Service_Storage` to use. *(required)*
 * `bucket_name` The name of the GCS bucket to use. *(required)*
 * `detect_content_type`: if `true` will detect the content type for each file *(default `true`)*
 * `options` A list of additional options passed to the adapter.
   * `directory` A directory to operate in. *(default '')*
   * `acl` Whether the uploaded files should be `private` or `public` *(default `private`)*
   * `create`: if `true`, gaufrette will create the bucket automatically *(default `false`)*
   * `project_id`: required for automatic bucket creation
   * `bucket_location`: required for automatic bucket creation

## Defining services

You need to create a custom factory service which creates a `\Google\Client` and authorizes with the correct scopes 
and then returns a `\Google\Service\Storage` class connected to the client class:

```yaml
services:
   app.google_cloud_storage.service:
      class: Google\Service\Storage
      factory: ['App\Factory\GoogleCloudStorageServiceFactory', 'createGoogleCloudStorage']
```

The factory may be something like this:

```php
<?php

namespace App\Factory;

class GoogleCloudStorageServiceFactory
{
    public static function createGoogleCloudStorage()
    {
        $keyFileLocation = '/path/to/key/project-id.json';
        $bucketName = 'gaufrette-bucket-test-1234';
        $projectId = 'some-project-586';
        $bucketLocation = 'EUROPE-WEST9';

        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $keyFileLocation);
        $client = new \Google\Client();
        $client->setApplicationName('Gaufrette');
        $client->addScope(\Google\Service\Storage::DEVSTORAGE_FULL_CONTROL);
        $client->useApplicationDefaultCredentials();

        return new \Google\Service\Storage($client);
    }
}
```

⚠️ We do not recommend to set credentials directly in the factory, [read how to make a service factory with Symfony](https://symfony.com/doc/current/service_container/factories.html).


## Example

Once the service is set up use its key as the `service_id` in the gaufrette configuration:

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        profile_photos:
            google_cloud_storage:
                service_id: 'app.google_cloud_storage.service'
                bucket_name: 'images'
                options:
                    directory: 'profile_photos'
```
