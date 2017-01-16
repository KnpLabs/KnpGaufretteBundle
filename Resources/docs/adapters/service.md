# Service

Allows you to use a user defined adapter service.

## Parameters

 * `id` The id of the service *(required)*

## Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            service:
                id:     my.adapter.service
```
