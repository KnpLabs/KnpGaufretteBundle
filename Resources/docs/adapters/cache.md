# Cache

Adapter which allows you to cache other adapters

## Parameters

 * `source` The source adapter that must be cached *(required)*
 * `cache` The adapter used to cache the source *(required)*
 * `ttl` Time to live, in seconds *(default 0)*
 * `serializer` The adapter used to cache serializations *(default null)*

## Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        media_ftp:
            ftp:
                host: example.com
                username: user
                password: pass
                directory: /example/ftp
                create: true
                mode: FTP_BINARY
        media_apc:
            apc:
                prefix: APC 'namespace' prefix
                ttl: 0
        media_cache:
            cache:
                source: media_ftp
                cache: media_apc
                ttl: 7200
    filesystems:
        media:
            adapter: media_cache
```
