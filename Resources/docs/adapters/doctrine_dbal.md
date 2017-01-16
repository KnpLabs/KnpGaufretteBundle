# Doctrine DBAL

Adapter that allows you to store data into a database.

## Parameters

 * `connection_name` The doctrine dbal connection name like `default`
 * `table` The table name like `media_data`
 * `key`: The primary key in the table
 * `content`: The field name of the file content
 * `mtime`: The field name of the timestamp
 * `checksum`: The field name of the checksum

## Example

``` yaml
# app/config/config.yml
knp_gaufrette:
    adapters:
        database:
            doctrine_dbal:
                connection_name: default
                table: data
                columns:
                    key: id
                    content: text
                    mtime: date
                    checksum: checksum
```
