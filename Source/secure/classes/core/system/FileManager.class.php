<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -




# -[ class ] -
class FileManager
{
	# -[ variables ]-
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================

	/**
	* Constructor
	*
	*/
	function FileManager ()
	{
	}
	
	
	/**
	* copy files
	*
	* @param	string	$source_file
	* @param	string	$dest_file
	* @return	bool	true/false
	*/
	function CopyFile( $source_file, $dest_file )
	{
		return _copy( $source_file, $dest_file );
	}

	
	/**
	* CreateRootPath
	*
	* @param	string	$root
	* @param	string	$url
	* @return 	bool	true/false
	*
	*/
	function CreateRootPath( $url )
	{
		$aDirectorySplit = explode( EGL_DIRSEP, $url );
		
		$dir = '';
		foreach ($aDirectorySplit as $part) 
		{
			$dir .= $part . EGL_DIRSEP;
			if( !is_dir($dir) && strlen($dir) > 0 )
				$this->CreateFolder( $dir );
		}
		return true;
	}
	
	
	/**
	* SaveCopy
	*
	* @param	string	$source_file
	* @param	string	$dest_file
	* @return	bool	true/false
	*/
	function SaveCopy( $source_file, $des_file )
	{
		if( $this->CreateRootPath( dirname($des_file) ) &&
			$this->CopyFile( $source_file, $des_file) )
		{
			return true;
		}else return false;
	}
	
	
	
	/**
	* CreateFolder
	*
	* @param	string	$root
	* @param	integer	$rights
	* @return	bool	true/false
	*/	
	function CreateFolder( $root, $rights=0777 )
	{
		return _mkdir( $root, $rights );
	}
};
?>