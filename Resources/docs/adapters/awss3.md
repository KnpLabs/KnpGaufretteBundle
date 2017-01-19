# Amazon S3 SDK v2

Adapter for Amazon S3 SDK v2.

## Parameters

 * `service_id` The service id of the `Aws\S3\S3Client` to use. *(required)*
 * `bucket_name` The name of the S3 bucket to use. *(required)*
 * `options` A list of additional options passed to the adapter.
   * `create` Whether to create the bucket if it doesn't exist. *(default false)*
   * `directory` A directory to operate in. *(default '')*
   This directory will be created in the root of the bucket and all files will be read and written there.

## Defining services

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

## Example

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