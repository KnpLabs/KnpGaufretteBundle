# Apc

A non-persistent adapter, use it in the dev environment, in demo sites, ...

## Parameters

 * `prefix` The prefix to this filesystem (APC 'namespace', it is recommended that this end in a dot '.') *(required)*
 * `ttl` Time to live *(default 0)*

## Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            apc:
                prefix: APC 'namespace' prefix
                ttl: 0
```