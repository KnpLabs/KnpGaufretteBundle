# In Memory

Adapter for test purposes, it stores files in an internal array.

## Parameters

 * `files` An array of files *(optional)*

The `files` is an array of files where each file is a sub-array having the `content`, `checksum` and `mtime` optional keys.

## Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            in_memory:
                files:
                    'file1.txt':    ~
                    'file2.txt':
                        content:    Some content
                        checksum:   abc1efg2hij3
                        mtime:      123456890123
```
