# Safe Local Adapter

Almost as simple as the **local** adapter, but it encodes key to avoid having to deal with the directories structure.

## Parameters

 * `directory` The directory of the filesystem *(required)*
 * `create` Whether to create the directory if it does not exist *(default true)*

## Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            safe_local:
                directory:  /path/to/my/filesystem
                create:     true
```
