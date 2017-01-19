# MongoDB GridFS

Adapter that allows you to use a MongoDB GridFS for storing files.

## Parameters

 * `mongogridfs_id` The id of the service that provides MongoGridFS object instance for adapter *(required)*

## Example

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
