# Dropbox

Adapter for Dropbox. In order to use it, you should add `dropbox-php/dropbox-php` as your composer dependency.

## Parameters

 * `api_id` The id of the service that provides Dropbox API access.

## Example

> In order to get a Dropbox token and token_secret, you need to add a new Dropbox App in your account, and then you'll need to go through the oAuth authorization process

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        foo:
            dropbox:
                api_id: acme_test.dropbox.api
```

In your AcmeTestBundle, add following service definitions:

``` yaml
# src/Acme/TestBundle/Resources/config/services.yml
parameters:
    acme_test.dropbox.key: my_consumer_key
    acme_test.dropbox.secret: my_consumer_secret
    acme_test.dropbox.token: some_token
    acme_test.dropbox.token_secret: some_token_secret

services:
    acme_test.dropbox.oauth:
        class: Dropbox_OAuth_Curl
        arguments: [%acme_test.dropbox.key%, %acme_test.dropbox.secret%]
        calls:
            - [setToken, ["%acme_test.dropbox.token%", "%acme_test.dropbox.token_secret%"]]
    acme_test.dropbox.api:
        class: Dropbox_API
        arguments: [@acme_test.dropbox.oauth, "sandbox"]
```