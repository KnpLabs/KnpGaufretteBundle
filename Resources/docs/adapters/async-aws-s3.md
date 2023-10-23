# AsyncAws S3

## Notes

Note that when you create a bucket it [is located in a specific region](http://docs.aws.amazon.com/AmazonS3/latest/dev/UsingBucket.html).
The full list of regions is available [here](http://docs.aws.amazon.com/general/latest/gr/rande.html#s3_region).

## Adapter for Amazon S3 SDK v3 (recommended)

```
composer require async-aws/simple-s3
```

### Service definition

An example service definition of the `AsyncAws\SimpleS3\SimpleS3Client`:

```yaml
services:
    acme.async_aws_s3.client:
        class: AsyncAws\SimpleS3\SimpleS3Client
        arguments:
            - region: '%amazon_s3.region%'
              accessKeyId: '%amazon_s3.key%'
              accessKeySecret: '%amazon_s3.secret%/K7MDENG/bPxRfiCYEXAMPLEKEY'
```

### Parameters

 * `service_id` The service id of the `AsyncAws\SimpleS3\SimpleS3Client` to use. *(required)*
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
            async_aws_s3:
                service_id: 'acme.async_aws_s3.client'
                bucket_name: 'images'
                detect_content_type: true
                options:
                    directory: 'profile_photos'
```
