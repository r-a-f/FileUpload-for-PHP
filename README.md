FileUpload 1.0!
------------
 A complete class to upload files with php 5 or higher, but the best: very simple to use.

*Example #1:*

```php
    <?php
    	$file = new FileUpload();
	$file->set_input( "file" );
	$file->save();
    ?>
```

*Example #2:*

```php
    <?php
    	$file = new FileUpload();
    	// set input( name of input file: <input type="file" name="file"/> )
	$file->set_input( "file" );
		
	// Directory output
	$file->set_destination_directory( "upload" );
	
	//Use "copy" function( Default: move_uploaded_file )
	$file->set_upload_function("copy");
	
	//Set file size limit( Formats: 10M , 10MB, 10mb, 10485760, etc )
	$file->set_max_file_size("10M");
	
	// Callback in before upload
	$file->set_callback_input(function( $data )
	{
		echo "<h3>Start!</h3>";
	});
	
	// Callback in after upload
	$file->set_callback_output(function( $data )
	{
		echo "<h3>End!</h3>";
		if( $data->status === true )
		{
			echo "<p>The ".$data->filename." file is upload</p>";
		}else{
			echo "<p>The ".$data->filename." file could not be uploaded to the server</p>";
		}
	});
		
	// Set destination directory( output file )
	$file->set_destination_directory("upload/complete");
		
	// Set multiples mime types
	$file->set_allowed_mime_types(array(
		'image/jpeg'	,
		'image/jpg'	,
		'image/pjpeg'	,
		'image/png'	,
	));
	
	// Set only one mime type
	$file->set_allow_mime_type('image/gif');
	
	// Set filename output
	$file->set_filename('my-new-name%s');
	
	// Allow overwriting if exists file
	$file->allow_overwriting();
	
	// Upload now!
	$file->save();
?>
```



## Documentation


### FileUpload::set_allow_mime_type( string $mime_type )
This method will allow you to establish a new mime type

*Example:*
```php
$FileUpload->set_allow_mime_type("text/html");
```

But you can also use the `mime_helping`( Show more in $mime_helping )

```php
$FileUpload->set_allow_mime_type("image"); // Set: image/jpeg, image/jpg, image/pjpeg, image/png and image/gif.
```

> Returns `TRUE` if successful, otherwise returns `FALSE`.

### FileUpload::set_allowed_mime_types( array $mime_types )
This method will allow you to set multiple mime types.

*Example:*
```php
$FileUpload->set_allowed_mime_types(array(
	"text/plain",
	"text/html"
));
```

> Returns `TRUE` if successful, otherwise returns `FALSE`.


### FileUpload::set_auto_filename(  )
This method will allow you to generate a unique name for the file you are uploading.

> Returns `TRUE` if successful, otherwise returns `FALSE`.


### FileUpload::set_callback_input( mixed $callback )
This method will allow you to set a function to be executed to start the process.
The method used must have a single parameter, which will be equivalent [FileUpload::get_info( )](#fileuploadget_info-)

*Example:*
```php
$FileUpload->set_callback_input(function( $file ){
	echo "start!";
});
```

> Returns `TRUE` if successful, otherwise returns `FALSE`.

### FileUpload::set_callback_output( mixed $callback )
This method will allow you to set a function to be executed at the end of the process.
The method used must have a single parameter, which will be equivalent [FileUpload::get_info( )](#fileuploadget_info-)

*Example:*
```php
$FileUpload->set_callback_output(function( $file ){
	rename( $file->destination, time() );
});
```

> Returns `TRUE` if successful, otherwise returns `FALSE`.


### FileUpload::set_destination_directory( string $destination_directory [, boolean $create_if_not_exist  = false ])
This method allows you to set where the file will be saved trying to upload.
> If the file path does not exist, you can set the parameter to true `$create_if_not_exist` when trying to create a new path.

*Examples:*
```php
$FileUpload->set_destination_directory("./uploads");
```
```php
$FileUpload->set_destination_directory("../uploads");
```
```php
$FileUpload->set_destination_directory("/var/www/html/uploads");
```
> Returns `TRUE` if successful, otherwise returns `FALSE`.


### FileUpload::set_filename( string $filename)
This method will allow you to set the name of the file you are uploading.
For the extension of the file, use the wildcard %s.
*Example:*
```php
$FileUpload->set_filename("my_new_file.%s");
```
> Returns `TRUE` if successful, otherwise returns `FALSE`.


### FileUpload::set_max_file_size( mixed $size )
This method allows you to limit the size of file you are uploading.
*Examples:*
```php
$FileUpload->set_max_file_size("1m"); // Limit is 1MB(1048576 Bytes)
```
```php
$FileUpload->set_upload_function("1048576"); // Limit is 1MB(1048576 Bytes)
```
> Returns `TRUE` if successful, otherwise returns `FALSE`.


### FileUpload::set_upload_function( string $function )
This method allows you to use the function that you need to upload files
*Example:*
```php
$FileUpload->set_upload_function("copy"); // Default is move_uploaded_file
```

> Returns `TRUE` if successful, otherwise returns `FALSE`.


### FileUpload::size_format( mixed $size )
Converts bytes to units of measurement.
*Example:*

```php
$FileUpload->size_format("1048576"); // return 1M
```

> Returns an string.

### FileUpload::size_in_bytes( mixed $size )
Converts measurement units to bytes
*Example:*

```php
$FileUpload->size_format("1MB"); // return 1048576
```
> Returns an `float` or `integer`.


### FileUpload::get_info( )
Returns all information about uploading the file.
```php
stdClass Object
(
    [status] => false // true if successful upload
    [mime] => "" // File mime type
    [filename] => "" // The new filename
    [original] => "" // Filename before to save in destination directory
    [size] => 0 // In bytes
    [size_formated] => 0B // In B, K, M and G
    [destination] => "" // Default is current dir ( ./ )
    [allowed_mime_types] => Array () // All allowed mime types
    [log] => Array () // All logs
    [error] => 0 // File error
)
```
> Returns an object.


### FileUpload::get_status( )
Returns the status of the upload. If the condition is `FALSE`, then the file has not yet risen, if the state is `TRUE`, the file upload was performed successfully.
> Returns `TRUE` if successful, otherwise returns `FALSE`.


### FileUpload::is_dirpath( string $directory )
Validates the directory path
> Returns `TRUE` if successful, otherwise returns `FALSE`.


### FileUpload::is_filename( string $filename )
Validates the filename.
> Returns `TRUE` if successful, otherwise returns `FALSE`.


### FileUpload::allow_overwriting()
If the file you try to upload already exists, it can not be overwritten unless you enable overwriting using this method.
> Returns `TRUE` if successful, otherwise returns `FALSE`.


### FileUpload::check_mime_type( string $mime_type )
Validates the mime type of the file.
If you have not enabled any mime type, the validation will return `TRUE`.
> Returns `TRUE` if successful, otherwise returns `FALSE`.


### FileUpload::clear_allowed_mime_types()
Removes all previously enabled mime types.
> Returns `TRUE` if successful, otherwise returns `FALSE`.


### FileUpload::dir_exists( string $directory )
Checks if the directory exists.
> Returns `TRUE` if successful, otherwise returns `FALSE`.


### FileUpload::file_exists( string $file )
Checks if the file exists.
> Returns `TRUE` if successful, otherwise returns `FALSE`.


### FileUpload::log( string $message [ , ... ] )
This method lets you add a new log.
> Returns `TRUE` if successful, otherwise returns `FALSE`.


### FileUpload::save(  )
This method loads the file, applies filters and save the file to the set destination.
> Returns `TRUE` if successful, otherwise returns `FALSE`.
