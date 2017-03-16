# Google Cloud

Adapter for Google APIs Client Library for PHP.

## Parameters

 * `service_id` The service id of the `\Google_Service_Storage` to use. *(required)*
 * `bucket_name` The name of the GCS bucket to use. *(required)*
 * `detect_content_type`: if `true` will detect the content type for each file *(default `true`)*
 * `options` A list of additional options passed to the adapter.
   * `directory` A directory to operate in. *(default '')*
   * `acl` Whether the uploaded files should be `private` or `public` *(default `private`)*

## Defining services

You need to create a custom factory service which creates a `\Google_Client` and authorizes with the correct scopes 
and then returns a `\Google_Service_Storage` class connected to the client class:

```yaml
services:
    app.google_cloud_storage.service:
        class: \Google_Service_Storage
        factory: [App\Factory\GoogleCloudStorageServiceFactory
        factory_method: 'createService'
        arguments:
            -
                # all the arguments needed like service account email and path to key.p12
```

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
