# OpenCloud

Adapter for OpenCloud (Rackspace)

## Parameters

 * `object_store_id`: the id of the object store service
 * `container_name`: the name of the container to use
 * `create_container`: if `true` will create the container if it doesn't exist *(default `false`)*
 * `detect_content_type`: if `true` will detect the content type for each file *(default `true`)*

## Defining services

To use the OpenCloud adapter you should provide a valid `ObjectStore` instance. You can retrieve an instance through the
`OpenCloud\OpenStack` or `OpenCloud\Rackspace` instances. We can provide a comprehensive configuration through the Symfony
DIC configuration.

### Define OpenStack/Rackspace service

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

### Define ObjectStore service

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

## Example

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
