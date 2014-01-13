<?php

require( dirname(dirname( __FILE__)).DIRECTORY_SEPARATOR."FileUpload.php" );

// Start
$file = new FileUpload();
// set input( name of input file: show html )
$file->set_input( "my_file" );
// Directory output
$file->set_destination_directory( "upload" );
// Upload now!
$file->save();


// Get all operation info
highlight_string(print_r($file->get_info(),true));

?>
<form method="post" action="" enctype="multipart/form-data">
	<input type="file" name="my_file" />
	<input type="submit" value="Upload now!" />
</form>