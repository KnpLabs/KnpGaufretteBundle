# Local Adapter

A simple local filesystem based adapter.

## Parameters

 * `directory` The directory of the filesystem *(required)*
 * `create` Whether to create the directory if it does not exist *(default true)*

## Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            local:
                directory:  /path/to/my/filesystem
                create:     true
```
