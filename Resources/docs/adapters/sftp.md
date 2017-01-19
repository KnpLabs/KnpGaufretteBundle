# SFTP (SSH-FTP)

Adapter for SFTP (SSH-FTP).

## Parameters

 * `sftp_id` The id of the service that provides SFTP access.
 * `directory` The remote directory *(default null)*.
 * `create` Whether to create the directory if it does not exist *(default false)*.

## Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            sftp:
                sftp_id: acme_test.sftp
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
    acme_test.ssh.configuration:
        class: Ssh\Configuration
        arguments: [%acme_test.ssh.host%]

    acme_test.ssh.authentication:
        class: Ssh\Authentication\Password
        arguments: [%acme_test.ssh.username%, %acme_test.ssh.password%]

    acme_test.ssh.session:
        class: Ssh\Session
        arguments: [@acme_test.ssh.configuration, @acme_test.ssh.authentication]

    acme_test.sftp:
        class: Ssh\Sftp
        arguments: [@acme_test.ssh.session]
```
