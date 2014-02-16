[![Build Status](https://travis-ci.org/olaferlandsen/FileUpload-for-PHP.png?branch=master)](https://travis-ci.org/olaferlandsen/FileUpload-for-PHP) [![PHP version](https://badge.fury.io/ph/olaferlandsen%2Ffileupload.png)](http://badge.fury.io/ph/olaferlandsen%2Ffileupload) [![Donate](https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=F3KYUX86HKN9J)





FileUpload 1.5
------------
A complete class to upload files with php 5.3+ or higher, but the best: very simple to use.

> This project was recently updated to 1.5 and is `PSR-0`, `PSR-1` and `PSR-2` compliant and supports `Composer` integration.

> **IMPORTANT!** If you want use this class in PHP 5.2 or lower, please contact [Olaf Erlandsen](#need-support) for FREE support.

*Example #1:*

```php
    <?php
        $file = new FileUpload\FileUpload();
        $file->setInput( "file" );
        $file->save();
        if ($file->getStatus()) {
            echo "is Upload!";
        }
    ?>
    <html>
        <head>
            <title>FileUpload Example</title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        </head>
        <body>
            <form method="post" action="" enctype="multipart/form-data">
                <input type="file" name="file" />
                <input type="submit" value="Upload now!" />
            </form>
        </body>
    </html>
```



## Documentation

### FileUpload::setAllowMimeType( string $mime_type )
This method will allow you to establish a new mime type

*Example:*

```php
$FileUpload->setAllowMimeType("text/html");
```

But you can also use the `mimeHelping`( Show more in $mime_helping )

```php
$FileUpload->setAllowMimeType("image"); // Set: image/jpeg, image/jpg, image/pjpeg, image/png and image/gif.
```

> Returns `true` if successful, otherwise returns `false`.

### FileUpload::setAllowedMimeTypes( array $mime_types )
This method will allow you to set multiple mime types.

*Example:*

```php
$FileUpload->setAllowedMimeTypes(array(
	"text/plain",
	"text/html"
));
```

> Returns `true` if successful, otherwise returns `false`.


### FileUpload::setAutoFilename(  )
This method will allow you to generate a unique name for the file you are uploading.

> Returns `true` if successful, otherwise returns `false`.


### FileUpload::setCallbackInput( mixed $callback )
This method will allow you to set a function to be executed to start the process.
The method used must have a single parameter, which will be equivalent [FileUpload::getInfo( )](#fileuploadgetinfo-)

*Example:*

```php
$FileUpload->setCallbackInput(function( $file ){
	echo "start!";
});
```

> Returns `true` if successful, otherwise returns `false`.

### FileUpload::setCallbackOutput( mixed $callback )
This method will allow you to set a function to be executed at the end of the process.
The method used must have a single parameter, which will be equivalent [FileUpload::getInfo( )](#fileuploadgetinfo-)

*Example:*

```php
$FileUpload->setCallbackOutput(function( $file ){
	rename( $file->destination, time() );
});
```

> Returns `true` if successful, otherwise returns `false`.


### FileUpload::setDestinationDirectory( string $destination_directory [, boolean $create_if_not_exist  = false ])
This method allows you to set where the file will be saved trying to upload.
> If the file path does not exist, you can set the parameter to true `$create_if_not_exist` when trying to create a new path.

*Examples:*

```php
$FileUpload->setDestinationDirectory("./uploads");
```
```php
$FileUpload->setDestinationDirectory("../uploads");
```
```php
$FileUpload->setDestinationDirectory("/var/www/html/uploads");
```
```php
$FileUpload->setDestinationDirectory("/var/www/html/uploads/tmp",true); // Path not exists, force create
```
> Returns `true` if successful, otherwise returns `false`.


### FileUpload::setFilename( string $filename)
This method will allow you to set the name of the file you are uploading.
For the extension of the file, use the wildcard %s.

*Example:*

```php
$FileUpload->setFilename("my_new_file.%s");
```
> Returns `true` if successful, otherwise returns `false`.


### FileUpload::setMaxFileSize( mixed $size )
This method allows you to limit the size of file you are uploading.

*Examples:*

```php
$FileUpload->setMaxFileSize("1m"); // Limit is 1MB(1048576 Bytes)
```
```php
$FileUpload->setMaxFileSize("1.5Megabytes"); // Limit is 1.5MB(1572864 Bytes)
```
```php
$FileUpload->setMaxFileSize("1.5MB"); // Limit is 1.5MB(1572864 Bytes)
```
```php
$FileUpload->setMaxFileSize("12Gbytes"); // Limit is 12 GB(12884901888 Bytes)
```
```php
$FileUpload->setMaxFileSize("1048576"); // Limit is 1MB(1048576 Bytes)
```
```php
$FileUpload->setMaxFileSize("1331.2"); // Limit is 1.3KB(1331.2 Bytes)
```

> Returns `true` if successful, otherwise returns `false`.


### FileUpload::setUploadFunction( string $function )
This method allows you to use the function that you need to upload files

*Example:*

```php
$FileUpload->setUploadFunction("copy"); // Default is move_uploaded_file
```

> Returns `true` if successful, otherwise returns `false`.


### FileUpload::sizeFormat( mixed $size )
Converts bytes to units of measurement.

*Example:*

```php
$FileUpload->sizeFormat("1"); // return 1B
```
```php
$FileUpload->sizeFormat("1024"); // return 1K
```
```php
$FileUpload->sizeFormat("1048576"); // return 1M
```
```php
$FileUpload->sizeFormat("1073741824"); // return 1G
```
```php
$FileUpload->sizeFormat("1099511627776"); // return 1T
```
```php
$FileUpload->sizeFormat("1331.2"); // return 1.3K
```

> Returns an string.

### FileUpload::sizeInBytes( mixed $size )
Converts measurement units to bytes

*Example:*

```php
$FileUpload->sizeInBytes("1"); // return 1
```
```php
$FileUpload->sizeInBytes("1B"); // return 1
```
```php
$FileUpload->sizeInBytes("1K"); // return 1024
```
```php
$FileUpload->sizeInBytes("1M"); // return 1048576
```
```php
$FileUpload->sizeInBytes("1G"); // return 1073741824
```
```php
$FileUpload->sizeInBytes("1.56M"); // return 1635778.56
```


> Returns an `float` or `integer`.


### FileUpload::getInfo( )
Returns all information about uploading the file.

*Example*

```php
stdClass Object
(
    [status]            => false       // true if successful upload
    [mime]              => ""// File mime type
    [filename]          => "" // The new filename
    [original]          => "" // Filename before to save in destination directory
    [size]              => 0 // In bytes
    [size_formated]     => 0B // In B, K, M and G
    [destination]       => "" // Default is current dir ( ./ )
    [allowed_mime_types]=> Array () // All allowed mime types
    [log]               => Array () // All logs
    [error]             => 0 // File error
)
```

> Returns an object.


### FileUpload::getStatus( )
Returns the status of the upload. If the condition is `false`, then the file has not yet risen, if the state is `true`, the file upload was performed successfully.
> Returns `true` if successful, otherwise returns `false`.


### FileUpload::isDirpath( string $directory )
Validates the directory path
> Returns `true` if successful, otherwise returns `false`.


### FileUpload::isFilename( string $filename )
Validates the filename.
> Returns `true` if successful, otherwise returns `false`.


### FileUpload::allowOverwriting()
If the file you try to upload already exists, it can not be overwritten unless you enable overwriting using this method.
> Returns `true` if successful, otherwise returns `false`.


### FileUpload::checkMimeType( string $mime_type )
Validates the mime type of the file.
If you have not enabled any mime type, the validation will return `true`.
> Returns `true` if successful, otherwise returns `false`.


### FileUpload::clearAllowedMimeTypes()
Removes all previously enabled mime types.
> Returns `true` if successful, otherwise returns `false`.


### FileUpload::dirExists( string $directory )
Checks if the directory exists.
> Returns `true` if successful, otherwise returns `false`.


### FileUpload::fileExists( string $file )
Checks if the file exists.
> Returns `true` if successful, otherwise returns `false`.


### FileUpload::log( string $message [ , ... ] )
This method lets you add a new log.
> Returns `true` if successful, otherwise returns `false`.


### FileUpload::save(  )
This method loads the file, applies filters and save the file to the set destination.
> Returns `true` if successful, otherwise returns `false`.



## Need Support?
 * Skype: olaferlandsen
 * [Email](mailto:info@infowebdevfreelance.com)


## Donate a coffee to Olaf Erlandsen :)
[![Donate](https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=F3KYUX86HKN9J)
