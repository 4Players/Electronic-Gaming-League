<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -




# -[ class ] -
class File
{
	# -[ variables ]-
	var $hFile	= NULL;
	var $size	= 0;
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function File ()
	{
		$this->hFile = NULL;
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: open overgiven file
	// Output : true/false
	//-------------------------------------------------------------------------------
	function Open( $filename, $mode )
	{
		if( !$this->hFile )
		{
			if( file_exists($filename) )
			$this->size = filesize($filename);
			if( !($this->hFile=@fopen( $filename, $mode )) )
				return 0;
			return 1;
		}else return 0;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: close current opened file
	// Output : tru/false
	//-------------------------------------------------------------------------------
	function Close()
	{
		if( $this->hFile ) 
		if( !@fclose($this->hFile) ) 
			return 0;
		$this->hFile = NULL;
		return 1;
	}
	
	
	/**
	* read 
	* @param integer offset
	*/

	function Read( $size=-1 )
	{
		if( $this->hFile ) 
		{
			if( $size == -1 )
			{
				$str='';
				while( $data = @fread( $this->hFile, 4096 )) $str .= $data;
				return $str;
			}
			else if( $size > 0 )
			{
				return @fread( $this->hFile, $size );
			}
			else return NULL;
		}else return -1;
	}
	
	
	
	/**
	* seek to offset
	* @param integer offset
	*/

	function Write( $buffer, $length=0 )
	{
		if( $this->hFile ) 
		{
			if( $length > 0 ) return @fwrite( $this->hFile, $buffer, $length );
			return @fwrite( $this->hFile, $buffer );
		}else return -1;		
	}
	
	
	
	/**
	* seek to offset
	* @param integer offset
	*/
	function Seek( $offset )
	{
		if( !@fseek( $this->hFile, $offset ) ) return 0;
		return 1;
	}
	
	
	
	/**
	* flush file resource
	* @return true/false
	*/
	function Flush()
	{
		if( !@fflush( $this->hFile ) ) return 0;
		return 1;
	}
	
	
	/**
	* 
	*/
	function SortFileArrayBy_ATIME( $a, $b )
	{
		if( $a['access'] == $b['access'] ) return 0;
		return ($a['access'] < $b['access']) ? -1 : 1;
	}
};

?>