# AWS S3

## Table of contents

- [Amazon SDK v3 (recommended)](#adapter-for-amazon-s3-sdk-v3-recommended)
- [Amazon SDK v2](#adapter-for-amazon-s3-sdk-v2)
- [Amazon SDK v1 (deprecated)](#adapter-for-amazon-s3-sdk-v1-deprecated-by-amazon)

## Notes

Note that when you create a bucket it [is located in a specific region](http://docs.aws.amazon.com/AmazonS3/latest/dev/UsingBucket.html).
The full list of regions is available [here](http://docs.aws.amazon.com/general/latest/gr/rande.html#s3_region).

## Adapter for Amazon S3 SDK v3 (recommended)

```
composer require aws/aws-sdk-php:^3.0
```

### Service definition

An example service definition of the `Aws\S3\S3Client`:

```yaml
services:
    acme.aws_s3.client:
        class: Aws\S3\S3Client
        factory: [Aws\S3\S3Client, 'factory']
        arguments:
            -
                version: latest
                region: %amazon_s3.region%
                credentials:
                    key: %amazon_s3.key%
                    secret: %amazon_s3.secret%
```

### Parameters

 * `service_id` The service id of the `Aws\S3\S3Client` to use. *(required)*
 * `bucket_name` The name of the S3 bucket to use. *(required)*
 * `detect_content_type` Auto detect the content type. *(default false)*
 * `options` A list of additional options passed to the adapter.
   * `create` Whether to create the bucket if it doesn't exist. *(default false)*
   * `directory` A directory to operate in. *(default '')*
   This directory will be created in the root of the bucket and all files will be read and written there.
   * `acl` Default ACL to apply to the objects

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
                detect_content_type: true
                options:
                    directory: 'profile_photos'
```

## Adapter for Amazon S3 SDK v2

```
composer require aws/aws-sdk-php:^2.0
```

### Service definition

An example service definition of the `Aws\S3\S3Client`:

```yaml
services:
    acme.aws_s3.client:
        class: Aws\S3\S3Client
        factory: [Aws\S3\S3Client, 'factory']
        arguments:
            -
                key: %amazon_s3.key%
                secret: %amazon_s3.secret%
                region: %amazon_s3.region%
```

### Parameters

 * `service_id` The service id of the `Aws\S3\S3Client` to use. *(required)*
 * `bucket_name` The name of the S3 bucket to use. *(required)*
 * `detect_content_type` Auto detect the content type. *(default false)*
 * `options` A list of additional options passed to the adapter.
   * `create` Whether to create the bucket if it doesn't exist. *(default false)*
   * `directory` A directory to operate in. *(default '')*
   This directory will be created in the root of the bucket and all files will be read and written there.
   * `acl` Default ACL to apply to the objects

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
                detect_content_type: true
                options:
                    directory: 'profile_photos'
```

## Adapter for Amazon S3 SDK v1 (DEPRECATED by Amazon)

```
composer require amazonwebservices/aws-sdk-for-php
```

### Service definition

To use the Amazon S3 adapter you need to provide a valid `AmazonS3` instance (as defined in the Amazon SDK). This can
easily be set up as using Symfony's service configuration:

``` yaml
# app/config/config.yml
services:
    amazonS3:
        class: AmazonS3
        arguments:
            options:
                key: '%aws_key%'
                secret: '%aws_secret_key%'
```

### Parameters

 * `amazon_s3_id`: the id of the AmazonS3 service used for the underlying connection
 * `bucket_name`: the name of the bucket to use
 * `options`: additional (optional) settings
   * `directory`: the directory to use, within the specified bucket
   * `region`
   * `create`

### Example

Once the service is set up use its key as the `amazon_s3_id` in the gaufrette configuration:

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            amazon_s3:
                amazon_s3_id: amazonS3
                bucket_name: foo_bucket
                options:
                    directory: foo_directory
```

Note that the SDK seems to have some issues with bucket names with dots in them, e.g. "com.mycompany.bucket" seems to have issues but "com-mycompany-bucket" works.
