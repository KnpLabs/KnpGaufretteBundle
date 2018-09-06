# Symfony use cases

The goal is to suggest how to handle generic tasks with the framework.

----------

## Upload a file

Depending on the number of filesystems you have, you may need to retrieve the one you need with the `knp_gaufrette.filesystem_map` service.
Otherwise you simply need to inject the `knp_gaufrette.filesystem` service.

Then, once you fetch the associated adapter, you are able to perform the desired operation and apply additional logic depending the current adapter.

In the case of the `AwsS3` adapter:

```php
/** @var AwsS3 $adapter */
$adapter = $this->filesystem->getAdapter();

// When we don't set the correct content type manually S3 will assume application/octet-stream
// and therefore will offer the file as download to the user.
// (cf https://florian.ec/articles/upload-files-to-amazon-s3-with-symfony2-and-gaufrette/)
if ($adapter instanceof AwsS3) {
    $adapter->setMetadata($filename, ['contentType' => 'application/pdf']);
}

$adapter->write($myAbsolutePath, file_get_contents($tempPath));
```

## Download a file stream

Another common need would be to download a file from a filesystem. Instead of loading the whole file content in the memory, why not using a stream ?

Gaufrette provides a default stream wrapper and you could use it easily in a response for example:

```php
public function downloadAction()
{
    $fileStream = sprintf('gaufrette://your_defined_fs/%s', 'absolute/path/to/file.pdf');

    $response = new BinaryFileResponse($fileStream);
    $response->headers->set('Content-Type', 'application/pdf');
    $response->setContentDisposition(
        ResponseHeaderBag::DISPOSITION_ATTACHMENT,
        'file.pdf'
    );

    return $response;
}
```
