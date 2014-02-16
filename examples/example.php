<?php


require( dirname(dirname( __FILE__)).DIRECTORY_SEPARATOR."src/FileUpload/FileUpload.php" );


header("Content-Type: text/html; charset=utf-8");


// Start
$file = new FileUpload\FileUpload();

// set input( name of input file: show html )
$file->setInput( "my_file" );

// Directory output
$file->setDestinationDirectory( "upload" );

//Use "copy" function( Default: move_uploaded_file )
$file->setUploadFunction("copy");

//Set file size limit( Formats: 10M , 10MB, 10mb, 10485760, etc )
$file->setMaxFileSize("10M");

// Callback in before upload
$file->setCallbackInput(function( $data )
{
	echo "<h3>Start!</h3>";
});

// Callback in after upload
$file->setCallbackOutput(function( $data )
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
$file->setDestinationDirectory(dirname(__FILE__));

// Set multiples mime types
$file->setAllowedMimeTypes(array(
	'image/jpeg',
	'image/jpg',
	'image/pjpeg',
	'image/png',
));

// Set only one mime type
$file->setAllowMimeType('image/gif');

// Set filename output
$file->setFilename("myfile.%s");

// Allow overwriting if exists file
$file->allowOverwriting();

// Upload now!
$file->save();


// Get all operation info
highlight_string(print_r($file->getInfo(),true));
?>
<html>
    <head>
        <title>FileUpload Example</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
        	<input type="file" name="my_file" />
        	<input type="submit" value="Upload now!" />
        </form>
    </body>
</html>
