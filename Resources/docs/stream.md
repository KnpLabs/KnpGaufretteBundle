# Stream Wrapper

The `stream_wrapper` settings allow you to register filesystems with a specified domain and
then use as a stream wrapper anywhere in your code like:
`gaufrette://domain/file.txt`

## Parameters

 * `protocol` The protocol name like `gaufrette://…` *(default gaufrette)*
 * `filesystems` An array that contains filesystems that you want to register to this stream_wrapper.
 If you set array keys these will be used as an alias for the filesystem (see examples below) *(default all filesystems without aliases)*

## Example 1

Using default settings, the protocol is "gaufrette" and all filesystems will be served

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        backup: #...
        amazon: #...

    filesystems:
        backup1:
            adapter: backup
        amazonS3:
            adapter: amazon

    stream_wrapper: ~
```

```
gaufrette://backup1/...
gaufrette://amazonS3/...
```

## Example 2

We define the protocol as "data", all filesystem will still be served (by default)

``` yaml
# app/config/config.yml
knp_gaufrette:
    filesystems:
        #...

    stream_wrapper:
        protocol: data
```

```
data://backup1/...
data://amazonS3/...
```

## Example 3

We define the protocol as data and define which filesystem(s) will be available

``` yaml
# app/config/config.yml
knp_gaufrette:
    filesystems:
        #...

    stream_wrapper:
        protocol: data
        filesystems:
            - backup1
```

```
data://backup1/... (works since it is defined above)
data://amazonS3/... (will not be available)
```

## Example 4

We define the protocol as data and define which filesystems will be available using array keys to set domain aliases

``` yaml
# app/config/config.yml
knp_gaufrette:
    filesystems:
        #...

    stream_wrapper:
        protocol: data
        filesystems:
            backup: backup1
            pictures: amazonS3
```

```
data://backup/...
data://pictures/...
```
