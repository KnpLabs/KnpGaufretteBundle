# Amazon S3

Adapter to connect to Amazon S3 instances.

This adapter requires the use of amazonwebservices/aws-sdk-for-php which can be installed by adding the following line to your composer.json:

```
    "require": {
        ...
        "amazonwebservices/aws-sdk-for-php": "1.6.2"
    },
```

## Parameters

 * `amazon_s3_id`: the id of the AmazonS3 service used for the underlying connection
 * `bucket_name`: the name of the bucket to use
 * `options`: additional (optional) settings
   * `directory`: the directory to use, within the specified bucket
   * `region`
   * `create`

## Defining services

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

## Example

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
