# MogileFS

Adapter that allows you to use MogileFS for storing files.

## Parameters

 * `domain` MogileFS domain
 * `hosts` Available trackers

## Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            mogilefs:
                domain: foobar
                hosts: ["192.168.0.1:7001", "192.168.0.2:7001"]
```
