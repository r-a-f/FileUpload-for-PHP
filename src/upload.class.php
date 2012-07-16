<?php
/***************************************
** Title........: upload Class
** Filename.....: upload.class.php
** Author.......: Olaf Erlandsen
** Version......: 0.1
** Notes........:
** Last changed.: 28.12.2011
** Last change..: 
***************************************/


class upload
{
	private $fields = array();
	private $encode_name = false;
	private $mimes = array(
		'text'		=>	array(
			'text/plain',
		),	
		'image'		=>	array(
			'image/jpeg'	,
			'image/jpg'		,
			'image/pjpeg'	,
			'image/png'		,
			'image/gif'		,
		),
		'documents'	=>	array(
			'application/msword',
			'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'application/vnd.openxmlformats-officedocument.presentationml.presentation',
			'application/vnd.ms-powerpoint',
			'application/vnd.ms-excel',
			'application/vnd.oasis.opendocument.spreadsheet',
			'application/vnd.oasis.opendocument.presentation',
		),
		'videos'	=>	array(
			/* 3GP */
			'video/3gpp',
			'video/3gpp',
			/* AVI */
			'video/x-msvideo',
			'video/avi',
			/* MP4 */
			'video/mpeg4',
			'video/mp4',
			/* MPEG */
			'video/mpeg',
			'video/mpg',
			/* MOV */
			'video/quicktime',
			'video/x-sgi-movie',
			/* WMV */
			'video/x-ms-wmv',
			/* FLV */
			'video/x-flv',
		)
	);
	
	public function set( $fieldName , $path , $allowMimes = null , $ouputname = null )
	{
		if( is_array( $allowMimes ) )
		{
			$this->fields[ $fieldName ] = array(
				'path'		=>	$path,
				'mimes'		=>	$allowMimes,
				'ouputname'	=>	$ouputname,
			);
		}else if( is_string( $allowMimes ) ){
			if( array_key_exists( strtolower( trim( $allowMimes ) ) , $this->mimes ))
			{
				$this->fields[ $fieldName ] = array(
					'path'		=> $path,
					'mimes'		=>	$this->mimes[  strtolower( trim( $allowMimes ) )  ],
					'ouputname'	=>	$ouputname
				);
				
			}else{
				$this->fields[ $fieldName ] = array(
					'path'		=>	$path,
					'mimes'		=>	array($allowMimes),
					'ouputname'	=>	$ouputname,
				);
			}
		}else{
			$this->fields[ $fieldName ] = array(
				'path'		=>	$path,
				'mimes'		=>	array(),
				'ouputname'	=>	$ouputname
			);
		}
	}
	
	
	public function encode_name( $encode = true )
	{
		if( is_bool( $encode ) )
		{
			$this->encode_name = $encode;
		}
		
	}
	
	public function upload()
	{
		if( isset( $_FILES ) )
		{
			if( is_array( $_FILES ) )
			{
				$__files = array();
				foreach( $this->fields as $field => $config )
				{
					
					if( array_key_exists( $field , $_FILES ) )
					{
						
						if( is_string( $_FILES[$field]['name'] ) )
						{
							$__upload = array();
							if( is_array( $_FILES[$field]['name'] ) )
							{
								foreach( $_FILES[$field]['name'] as $key => $values )
								{
									if( $this->encode_name === true )
									{
										$m						=	explode( '.' , $__upload['name'] );
										$__upload['name']		=	md5( uniqid( "" , true ) ).'.'.$m[(count($m)-1)];
									}else{
										$__upload['name']		=	$_FILES[$field]['name'][$key];
									}
									$__upload['type']			= $_FILES[$field]['type'][$key];
									$__upload['size']			= $_FILES[$field]['size'][$key];
									$__upload['tmp_name']		= $_FILES[$field]['tmp_name'][$key];
									$__upload['error']			= $_FILES[$field]['error'][$key];
								}
							}else{
								
								if( $this->encode_name === true )
								{
									$m							=	explode( '.' , $_FILES[$field]['name'] );
									$_FILES[$field]['name']		=	md5( uniqid( "" , true ) ).'.'.strtolower($m[(count($m)-1)]);
								}
								$__upload = $_FILES[$field];
							}
							
							if( in_array( $__upload['type'] , $config['mimes'] ) )
							{
								$__files[$field] = $this->__upload( $__upload , $config['path'] . $__upload['name'] );
							}
							
							
						}else{}
					
						
					}
					
				}
				return $__files;
			}
		}
	}
	
	private function __upload( $field , $output )
	{
		if(  is_dir( dirname($output)) )
		{
			if(copy( $field['tmp_name'], $output ))
			{
				return array(
					'size'	=>	$field['size'],
					'name'	=>	basename( $output ),
					'path'	=>	dirname( $output ),
					'type'	=>	$field['type']
				);
			}else{}
		}else{}
		return false;
	}
	
	
}

?>