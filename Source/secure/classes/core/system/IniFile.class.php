<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -




# -[ class ] -
class IniFile
{
	# -[ variables ]-
	var $aBuffer		= array();
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function IniFile ()
	{		
	}



	//-------------------------------------------------------------------------------
	// Purpose: load ini_file to local buffer
	// Output : true(1), false(0)
	//-------------------------------------------------------------------------------
	function LoadFromFile( $filename, $f_complex=false )
	{
		# fileexists ?
		if( file_exists( $filename ) )
		{
			# try parsing ini file
			if( $this->aBuffer = @parse_ini_file($filename, $f_complex ))
			{
				return 1;
			}
		}
		return 0;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: save ini_file from local buffer
	// Output : true(1), false(0)
	//-------------------------------------------------------------------------------
	function SaveToFile( $filename, $f_complex=false )
	{
		$oOutput = new File();
		
		# try opening file
		if( $oOutput->Open( $filename, 'w' ) )
		{
			
				/*
				*/
				$aComplexArrays = array();
				
				while( list($var_name, $var_value) = each($this->aBuffer) ) 
				{
					/*
						easy-type check
					*/
					if( !is_array( $this->aBuffer[$var_name] ) )
					{
						$oOutput->Write( "{$var_name} = {$var_value}".chr(13)/* linebreak \n*/);
					}
					else 
					{
						/*
							Save complex types into global array
						*/
						if( $f_complex ) $aComplexArrays[$var_name] = $this->aBuffer[$var_name];
					}
				}//while, list
				
		
				/*
				*/
				if( $f_complex )
				while( list($var_name, $var_value) = each($aComplexArrays) ) 
				{
					/*
						complex-type check
					*/
					$oOutput->Write( "[$var_name]".chr(13) /* linebreak \n*/ );
						
					/*
						list complex-type vars/values
					*/
					while( list($__var_name, $__var_value) = each($this->aBuffer[$var_name]) ) 
					{
						$oOutput->Write( "{$__var_name}	= {$__var_value}".chr(13)/* linebreak \n*/ );
					}//while
				}//while, list

			return $oOutput->Close();
		}//if
		
		return 0;
	}// SaveToFile()
	
	
	
	
	function GetBuffer(){ return $this->aBuffer; }
	function &GetBufferRef() { return $this->aBuffer; }

	function SetBuffer($buf) { ($this->aBuffer=$buf); }
	
};

?>