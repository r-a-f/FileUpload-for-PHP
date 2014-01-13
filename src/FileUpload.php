<?php
/**
*	FileUpload
*
*	A complete class to upload files with php 5 or higher, but the best: very simple to use.
*
*	@author Olaf Erlandsen <info@webdevfreelance.com>
*	@author http://www.webdevfreelance.com/
*
*	@package FileUpload
*	@version 1.0
*/
class FileUpload
{
	/**
	*	Upload function name
	*	Remember:
	*		Default function: move_uploaded_file
	*		Native options:
	*			- move_uploaded_file
	*			- copy
	*
	*	@since		1.0
	*	@version	1.0
	*	@var		string
	*/
	private $upload_function = "move_uploaded_file";
	/**
	*	Array with the information obtained from the
	*	variable $_FILES or $HTTP_POST_FILES.
	*
	*	@since		1.0
	*	@version	1.0
	*	@var		array
	*/
	private $file_array	= array();
	/**
	*	If the file you are trying to upload already exists it will
	*	be overwritten if you set the variable to true.
	*
	*	@since		1.0
	*	@version	1.0
	*	@var		boolean
	*/
	private $overwrite_file = false;
	/**
	*	Input element
	*	Example:
	*		<input type="file" name="file" />
	*	Result:
	*		FileUpload::$input = file
	*
	*	@since		1.0
	*	@version	1.0
	*	@var		string
	*/
	private $input;
	/**
	*	Path output
	*
	*	@since		1.0
	*	@version	1.0
	*	@var		string
	*/
	private $destination_directory;
	/**
	*	Output filename
	*
	*	@since		1.0
	*	@version	1.0
	*	@var		string
	*/
	private $filename;
	/**
	*	Max file size
	*
	*	@since		1.0
	*	@version	1.0
	*	@var		float
	*/
	private $max_file_size= 0.0;
	/**
	*	List of allowed mime types
	*
	*	@since		1.0
	*	@version	1.0
	*	@var		array
	*/
	private $allowed_mime_types = array();
	/**
	*	Callbacks
	*
	*	@since		1.0
	*	@version	1.0
	*	@var		array
	*/
	private $callbacks = array("before"=>null,"after"=>null);
	/**
	*	File object
	*
	*	@since		1.0
	*	@version	1.0
	*	@var		object
	*/
	private	$file;
	/**
	*	Helping mime types
	*
	*	@since		1.0
	*	@version	1.0
	*	@var		array
	*/
	private $mime_helping = array(
		'text'		=>	array(
			'text/plain',
		),	
		'image'	=>	array(
			'image/jpeg'	,
			'image/jpg'		,
			'image/pjpeg'	,
			'image/png'		,
			'image/gif'		,
		),
		'document'	=>	array(
			'application/msword',
			'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'application/vnd.openxmlformats-officedocument.presentationml.presentation',
			'application/vnd.ms-powerpoint',
			'application/vnd.ms-excel',
			'application/vnd.oasis.opendocument.spreadsheet',
			'application/vnd.oasis.opendocument.presentation',
		),
		'video'	=>	array(
			'video/3gpp',
			'video/3gpp',
			'video/x-msvideo',
			'video/avi',
			'video/mpeg4',
			'video/mp4',
			'video/mpeg',
			'video/mpg',
			'video/quicktime',
			'video/x-sgi-movie',
			'video/x-ms-wmv',
			'video/x-flv',
		),
	);
	/**
	*	Construct
	*
	*	@since		0.1
	*	@version	1.0
	*	@return 	object
	*/
	public function __construct( )
	{
		$this->file = array(
			"status"			=>	false,
			"mime"				=>	"",
			"filename"			=>	"",
			"original"			=>	"",
			"size"				=>	0,
			"size_formated"		=>	"0B",
			"destination"			=>	"",
			"allowed_mime_types"=>array(),
			"log"				=>array(),
			"error"				=>0,
		);
		// Change dir to current dir
		$this->destination_directory = dirname( __FILE__ ) . DIRECTORY_SEPARATOR;
		chdir( $this->destination_directory );
		
		// Set file array
		if( isset( $_FILES ) AND is_array( $_FILES ) )
		{
			$this->file_array = $_FILES;
		}else if( isset( $HTTP_POST_FILES ) AND is_array( $HTTP_POST_FILES ) )
		{
			$this->file_array = $HTTP_POST_FILES;
		}
	}
	/**
	*	Set input.
	*	If you have $_FILES["file"], you must use the key "file"
	*	Example:
	*		$object->set_input( "file" );
	*
	*	@since		1.0
	*	@version	1.0
	*	@param		string	$input
	*	@return 	boolean
	*/
	public function set_input( $input )
	{
		if( !empty( $input ) AND ( is_string( $input ) or is_numeric( $input ) ) )
		{
			$this->log( "Capture set to %s" , $input );
			$this->input = $input;
			return true;
		}
		return false;
	}
	/**
	*	Set new filename
	*	Example:
	*		FileUpload::set_filename( "new file.txt" )
	*	Remember:
	*		Use %s to retrive file extension
	*
	*	@since		1.0
	*	@version	1.0
	*	@param		string	$filename
	*	@return 	boolean
	*/
	public function set_filename( $filename )
	{
		if( $this->is_filename( $filename ) )
		{
			$this->log( "Filename set to %s" , $filename );
			$this->filename = $filename;
			return true;
		}
		return false;
	}
	/**
	*	Set automatic filename
	*
	*	Remember:
	*		Use %s to retrive file extension
	*
	*	@since		1.0
	*	@version	1.0
	*	@param		string	$extension
	*	@return 	boolean
	*/
	public function set_auto_filename( )
	{
		$this->log( "Automatic filename is enabled");
		$this->filename = sha1(mt_rand(1, 9999) . uniqid()) . time() ;
		$this->log( "Filename set to %s" , $this->filename );
		return true;
	}
	/**
	*	Set file size limit
	*
	*	@since		1.0
	*	@version	1.0
	*	@param		integer	$file_size
	*	@return 	boolean
	*/
	public function set_max_file_size( $file_size )
	{
		$file_size = $this->size_in_bytes($file_size);
		if( is_numeric( $file_size ) AND $file_size > -1 )
		{
			// Get php config
			$size = $this->size_in_bytes(ini_get('upload_max_filesize'));
			
			$this->log("PHP settings have set the maximum file upload size to %s(%d)",
				$this->size_format($size),
				$size
			);
			// Calculate difference
			if( $size < $file_size )
			{
				$this->log("WARNING! The PHP configuration allows a maximum size of %s", $this->size_format($size));
				return false;
			}
			
			$this->log("[INFO]Maximum allowed size set at %s(%d)",
				$this->size_format($file_size),
				$file_size
			);
			$this->max_file_size = $file_size;
			return true;
		}
		return false;
	}
	/**
	*	Set array mime types
	*
	*	@since		1.0
	*	@version	1.0
	*	@param		array	$mimes
	*	@return 	boolean
	*/
	public function set_allowed_mime_types( array $mimes )
	{
		if( count( $mimes ) > 0  )
		{
			array_map( array( $this , "set_allow_mime_type" ) , $mimes );
			return true;
		}
		return false;
	}
	/**
	*	Set input callback
	*
	*	@since		1.0
	*	@version	1.0
	*	@param		mixed	$callback
	*	@return 	boolean
	*/
	public function set_callback_input( $callback )
	{
		if( is_callable( $callback , false ) )
		{
			$this->callbacks["input"] = $callback;
			return true;
		}
		return false;
	}
	/**
	*	Set output callback
	*
	*	@since		1.0
	*	@version	1.0
	*	@param		mixed	$callback
	*	@return 	boolean
	*/
	public function set_callback_output( $callback )
	{
		if( is_callable( $callback , false ) )
		{
			$this->callbacks["output"] = $callback;
			return true;
		}
		return false;
	}
	/**
	*	Append a mime type to allowed mime types
	*
	*	@since		1.0
	*	@version	1.0
	*	@param		string	$mime
	*	@return 	boolean
	*/
	public function set_allow_mime_type( $mime )
	{
		if( !empty( $mime ) AND is_string( $mime ) )
		{
			if( preg_match( "#^[-\w\+]+/[-\w\+]+$#" , $mime ) )
			{
				$this->log("IMPORTANT! Mime %s enabled", $mime);
				$this->allowed_mime_types[] = strtolower($mime);
				$this->file["allowed_mime_types"][] = strtolower($mime);
				return true;
			}else if( array_key_exists( $mime , $this->mime_helping ) )
			{
				$this->set_allowed_mime_types( $this->mime_helping[$mime] );
				return true;
			}
		}
		return false;
	}
	/**
	*	Set function to upload file
	*	Examples:
	*		1.- FileUpload::set_upload_function("move_uploaded_file");
	*		2.- FileUpload::set_upload_function("copy");
	*
	*	@since		1.0
	*	@version	1.0
	*	@param		string	$mime
	*	@return 	boolean
	*/
	public function set_upload_function( $function )
	{
		if( !empty( $function ) and ( is_array( $function) or is_string( $function ) ) )
		{
			if( is_callable( $function ) )
			{
				$this->log("IMPORTANT! The function for uploading files is set to: %s",$function);
				$this->upload_function = $function;
				return true;
			}
		}
		return false;
	}
	/**
	*	Clear allowed mime types cache
	*
	*	@since		1.0
	*	@version	1.0
	*	@return 	boolean
	*/
	public function clear_allowed_mime_types()
	{
		$this->allowed_mime_types = array();
		$this->file["allowed_mime_types"] = array();
		return true;
	}
	/**
	*	Set destination output
	*
	*	@since		1.0
	*	@version	1.0
	*	@param		string	$destination_directory
	*	@param		boolean	$create_if_not_exist
	*	@return 	boolean
	*/
	public function set_destination_directory( $destination_directory ,$create_if_not_exist = false )
	{
		$destination_directory = realpath( $destination_directory );
		if( substr($destination_directory,-1) != DIRECTORY_SEPARATOR )
		{
			$destination_directory .= DIRECTORY_SEPARATOR;
		}
		if( $this->is_dirpath( $destination_directory ) )
		{
			if( $this->dir_exists( $destination_directory ) )
			{
				$this->destination_directory = $destination_directory;
				if( substr($this->destination_directory,-1) != DIRECTORY_SEPARATOR )
				{
					$this->destination_directory .= DIRECTORY_SEPARATOR;
				}
				chdir( $destination_directory );
				return true;
			}
			else if( $create_if_not_exist === true )
			{
				if ( mkdir( $destination_directory , $this->destination_permissions , true ) )
				{
					if( $this->dir_exists( $destination_directory ) )
					{
						
						$this->destination_directory = $destination_directory;
						if( substr($this->destination_directory,-1) != DIRECTORY_SEPARATOR )
						{
							$this->destination_directory .= DIRECTORY_SEPARATOR;
						}
						chdir( $destination_directory );
						return true;
					}
				}
			}
		}
		return false;
	}
	/**
	*	Check file exists
	*
	*	@since		1.0
	*	@version	1.0
	*	@param		string	$file_destination
	*	@return 	boolean
	*/
	public function file_exists( $file_destination )
	{
		if( $this->is_filename( $file_destination ) )
		{
			if( file_exists( $file_destination ) and is_file( $file_destination ) )
			{
				return true;
			}
		}
		return false;
	}
	/**
	*	Check dir exists
	*
	*	@since		1.0
	*	@version	1.0
	*	@param		string	$path
	*	@return 	boolean
	*/
	public function dir_exists( $path )
	{
		if( $this->is_dirpath( $path ) )
		{
			if( file_exists( $path ) and is_dir( $path ) )
			{
				return true;
			}
		}
		return false;
	}
	/**
	*	Check valid filename
	*
	*	@since		1.0
	*	@version	1.0
	*	@param		string	$filename
	*	@return 	boolean
	*/
	public function is_filename( $filename )
	{
		$filename = basename( $filename );
		return !empty( $filename) and ( is_string( $filename ) or is_numeric( $filename ) );
	}
	/**
	*	Validate mime type with allowed mime types,
	*	but if allowed mime types is empty, this method return true
	*
	*	@since		1.0
	*	@version	1.0
	*	@param		string	$mime
	*	@return 	boolean
	*/
	public function check_mime_type( $mime )
	{
		if( count( $this->allowed_mime_types ) == 0 )
		{
			return true;
		}
		return in_array( strtolower( $mime ) , $this->allowed_mime_types );
	}
	/**
	*	Retrive status of upload
	*
	*	@since		1.0
	*	@version	1.0
	*	@return 	boolean
	*/
	public function get_status( )
	{
		return $this->file["status"];
	}
	/**
	*	Check valid path
	*
	*	@since		1.0
	*	@version	1.0
	*	@param		string	$filename
	*	@return 	boolean
	*/
	public function is_dirpath( $path )
	{
		if( !empty( $path ) and ( is_string( $path ) or is_numeric( $path ) ) )
		{
			if( DIRECTORY_SEPARATOR == "/" )
			{
				if( preg_match( '/^[^*?"<>|:]*$/' , $path ) )
				{
					 return true;
				}
			}else{
				$tmp = substr($path,2);
				$bool = preg_match( "/^[^*?\"<>|:]*$/" , $tmp );
		        return ($bool == 1);
			}
		}
		return false;
	}
	/**
	*	Allow overwriting files
	*
	*	@since		1.0
	*	@version	1.0
	*	@return 	boolean
	*/
	public function allow_overwriting()
	{
		$this->log("Overwrite enabled");
		$this->allow_overwriting = true;
		return true;
	}
	/**
	*	File info
	*
	*	@since		1.0
	*	@version	1.0
	*	@return 	object
	*/
	public function get_info()
	{
		return (object)$this->file;
	}
	/**
	*	Upload file
	*
	*	@since		1.0
	*	@version	1.0
	*	@return 	boolean
	*/
	public function save()
	{
		if( count($this->file_array) > 0 )
		{
			$this->log("Capturing input %s",$this->input);
			if( array_key_exists($this->input , $this->file_array ) )
			{
				// set original filename if not have a new name
				if( empty($this->filename) )
				{
					$this->log("Using original filename %s",$this->file_array[$this->input]["name"]);
					$this->filename = $this->file_array[$this->input]["name"];
				}
				
				// Replace %s for extension in filename
				$extension = preg_replace("/[\w\d]*(.[\d\w]+)$/i",'$1',$this->file_array[$this->input]["name"]);
				$this->filename = sprintf( $this->filename , $extension );
				
				// set file info
				$this->file["mime"] 		= $this->file_array[$this->input]["type"];
				$this->file["tmp"]			= $this->file_array[$this->input]["tmp_name"];
				$this->file["original"]		= $this->file_array[$this->input]["name"];
				$this->file["size"]			= $this->file_array[$this->input]["size"];
				$this->file["size_formated"]= $this->size_format($this->file["size"]);
				$this->file["destination"]	= $this->destination_directory . $this->filename;
				$this->file["filename"]		= $this->filename;
				$this->file["error"]		=  $this->file_array[$this->input]["error"];
				
				// Check if exists file
				if( $this->file_exists( $this->destination_directory.$this->filename ) )
				{
					$this->log("%s file already exists",$this->filename);
					// Check if overwrite file
					if( $this->overwrite_file === false )
					{
						$this->log("You don't allow overwriting. Show more about FileUpload::allow_overwriting");
						return false;
					}
					$this->log("The %s file is overwritten" , $this->filename);
				}
				
				// Execute input callback
				if( !empty( $this->callbacks["input"] ) )
				{
					$this->log("Running input callback");
					call_user_func( $this->callbacks["input"] , (object)$this->file );
				}
				
				// Check mime type
				$this->log("Check mime type");
				if( !$this->check_mime_type( $this->file["mime"] ) )
				{
					$this->log("Mime type %s not allowed" , $this->file["mime"] );
					return false;
				}
				$this->log("Mime type %s allowed" , $this->file["mime"] );
				// Check file size
				if( $this->max_file_size > 0 )
				{
					$this->log("Checking file size");
				
					if( $this->max_file_size < $this->file["size"] )
					{
						$this->log("The file exceeds the maximum size allowed(Max: %s; File: %s)",
							$this->size_format($this->max_file_size),
							$this->size_format($this->file["size"])
						);
						return false;
					}
				}
				// Copy tmp file to destination and change status
				$this->log("Copy tmp file to destination %s" , $this->destination_directory );
				$this->log("Using upload function: %s" , $this->upload_function );
				$this->file["status"] = call_user_func_array( $this->upload_function, array(
					$this->file_array[$this->input]["tmp_name"],
					$this->destination_directory . $this->filename
				));
				// Execute output callback
				if( !empty( $this->callbacks["output"] ) )
				{
					$this->log("Running output callback");
					call_user_func( $this->callbacks["output"] , (object)$this->file );
				}
				return $this->file["status"];
			}
		}
	}
	/**
	*	Create log
	*
	*	@since		1.0
	*	@version	1.0
	*	@return 	boolean
	*/
	public function log()
	{
		$params = func_get_args();
		$this->file["log"][] = call_user_func_array( "sprintf" , $params );
		return true;
	}
	/**
	*	File size for humans.
	*
	*	@since		1.0
	*	@version	1.0
	*	@param		integer	$bytes
	*	@param		integer	$precision
	*	@return 	string
	*/
	public function size_format($size, $precision = 2)
	{
		$base = log($size) / log(1024);
		$suffixes = array('B', 'K', 'M', 'G');
		return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
	}
	/**
	*	Convert human file size to bytes
	*
	*	@since		1.0
	*	@version	1.0
	*	@param		integer	$size
	*	@return 	string
	*/
	public function size_in_bytes($size)
	{
		$units = array("B"=>0,"K"=>1,"M"=>2,"G"=>3);
		$matches = array();
		preg_match("/(?<size>[\d\.]+)\s*(?<unit>b|k|m|g)?/i",$size,$matches);
		if( !array_key_exists( "unit", $matches ) )
		{
			$unit = "B";
		}else{
			$unit = strtoupper( $matches["unit"] );
		}
		return (floatval($matches["size"]) * pow(1024, $units[$unit]) ) ;
	}
} // End class