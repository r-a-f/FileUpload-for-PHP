<?php

require( dirname(dirname( __FILE__)).DIRECTORY_SEPARATOR."FileUpload.php" );

// Start
$file = new FileUpload();

// set input( name of input file: show html )
$file->set_input( "my_file" );

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
	'image/jpg'		,
	'image/pjpeg'	,
	'image/png'		,
));

// Set only one mime type
$file->set_allow_mime_type('image/gif');

// Set filename output
$file->set_filename('my-new-name%s');

// Allow overwriting if exists file
$file->allow_overwriting();


// Upload now!
$file->save();


// Get all operation info
highlight_string(print_r($file->get_info(),true));

?>
<form method="post" action="" enctype="multipart/form-data">
	<input type="file" name="my_file" />
	<input type="submit" value="Upload now!" />
</form>