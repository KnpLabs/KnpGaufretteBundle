UPGRADE FROM 0.1 to 0.2
=======================

### AmazonS3 

* In 0.2 we pass additional options for AmazonS3 Gaufrette provider AmazonS3 config was changed (old way is DEPRECIATED)

before:

```yml
knp_gaufrette:
    adapters:
        adaptername:
            amazon_s3:
                amazon_s3_id: amazon_s3.service.id
                bucket_name: mybucketname
                create: true
```

after:

```yml
knp_gaufrette:
    adapters:
        adaptername:
            amazon_s3:
                amazon_s3_id: amazon_s3.service.id
                bucket_name: mybucketname
                options:
                    create: true
```
