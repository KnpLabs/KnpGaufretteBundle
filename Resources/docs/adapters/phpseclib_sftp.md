# Phpseclib Sftp

Adapter for phpseclib SFTP (SSH-FTP).

## Parameters

 * `phpseclib_sftp_id` The id of the service that provides SFTP access.
 * `directory` The remote directory *(default null)*.
 * `create` Whether to create the directory if it does not exist *(default false)*.

## Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            phpseclib_sftp:
                phpseclib_sftp_id: acme_test.sftp
                directory: /example/sftp
                create: true
```

In your AcmeTestBundle, add following service definitions:

``` yaml
# src/Acme/TestBundle/Resources/config/services.yml
parameters:
    acme_test.ssh.host: my_host_name
    acme_test.ssh.username: user_name
    acme_test.ssh.password: some_secret

services:
    acme_test.sftp:
        class: phpseclib\Net\SFTP #for phpseclib 1.x you need to use Net_SFTP
        arguments: [%acme_test.ssh.host%]
        calls:
            - [login, [%acme_test.ssh.username%, %acme_test.ssh.password%]]

```
