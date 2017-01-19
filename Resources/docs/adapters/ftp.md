# FTP

Adapter for FTP.

## Parameters

 * `directory` The remote directory *(required)*
 * `host` FTP host *(required)*
 * `username` FTP username *(default null)*
 * `password` FTP password *(default null)*
 * `port` FTP port *(default 21)*
 * `passive` FTP passive mode *(default false)*
 * `create` Whether to create the directory if it does not exist *(default false)*
 * `mode` FTP transfer mode *(defaut FTP_ASCII)*

## Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            ftp:
                host: example.com
                username: user
                password: pass
                directory: /example/ftp
                create: true
                mode: FTP_BINARY
```
