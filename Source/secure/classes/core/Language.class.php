<?php
# ================================ Copyright � 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -
class lngfile_t
{
	var $directory	= 'unknown';
	var $filename	= 'unknown';
	
	function lngfile_t( $dir, $file )
	{
		$this->directory = $dir;
		$this->filename = $file;
	}
};



# -[ class ] -

/**
* @copyright	Inetopia.
* @author 		Inetopia.
* @package 		EGL.LanguageSystem
**/
class Language
{
	# -[ variables ]-
	var $sDir		= NULL;
	var $aLngFiles	= array();
	var $aBuffer	= array();
	var $sLng		= 'unknown';
	
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function Language ()
	{
	}
	
	

	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------
	function SetLanguage( $lng )
	{
		$this->sLng = $lng;
	}
	
	
	/**
	* Parses the ini (lng) file
	* 
	* @param	string	root directory of language files
	* @param 	array	destination array for language data
	* @return	boolean true/false
	**/
	function ParseFile( $directory, &$pArray )
	{
		$pArray = array();
		
		# define filename
		$lng_file = $directory.$this->sLng.'.lng';
		if( file_exists( $lng_file ) )
		{
			
			# load buffer [init-file]  as complex
			 $pArray = $this->ModifySmartyLngArray( parse_ini_file( $lng_file, 1 )) ;
			 return 1;
			 
		}else
		{#
			DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "Couldn't load basic language file `{$lng_file}`" );
			return 0;
		}//if
	}
	
	/**
	* Parses the ini (lng) file
	* 
	* @param	string	root directory of language files
	* @param 	array	destination array for language data
	* @return	boolean true/false
	**/
	function ParseRootFile( $file, &$pArray )
	{
		$pArray = array();
		
		# define filename
		$lng_file = $file;
		if( file_exists( $lng_file ) )
		{
			
			# load buffer [init-file]  as complex
			 $pArray = $this->ModifySmartyLngArray( parse_ini_file( $lng_file, 1 )) ;
			 
		}else
		{#
			DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "Couldn't load basic language file `{$lng_file}`" );
			return 0;
		}//if
	}
	
	
		

	/**
	* Modifies language array  
	*
	* @param	array	arraylist of language contents
	* @return	array	new, modified array
	**/
	function ModifySmartyLngArray( $array )
	{
		while( list($var_name, $var_value) = each($array) )	
		{
			if( is_array( $array[$var_name] ))
			{
				while( list($sub_var_name, $sub_var_value) = each($array[$var_name]) )	
				{
					$array[$var_name][$sub_var_name] = str_replace( '\'', '"', $array[$var_name][$sub_var_name] );
				}//while
			}
			else
			{
				$array[$var_name] = str_replace( '\'', '"', $array[$var_name] );
			} //else if
		}//while

		return $array;	
	}	
	
	/**
	* fetch supported country-list from workspace
	*
	*
	* return description of supported languages
	* array:	name	[..] 	{standard-item, c0001}
	*			file	[..]
	*			token	[..]
	*
	**/
	function GetSupportedLanguagesFromWorkspace( $sWorkspace )
	{
		$cDir 					= new MyDirectory();
		$aSupportedLanguages 	= array();
		$aLanguageFiles 		= array();

		$sWorkspaceLng = EGL_SECURE.'workspaces'.EGL_DIRSEP.$sWorkspace.EGL_DIRSEP.'languages'.EGL_DIRSEP;
		if( $cDir->Open( $sWorkspaceLng ) ){
			$aLanguageFiles = $cDir->GetFiles( array('lng') );
			$cDir->Close();
		}//if
		
		// filter 
		for( $i=0; $i < sizeof($aLanguageFiles); $i++ )
		{
			$lng_token = substr($aLanguageFiles[$i],0,strlen($aLanguageFiles[$i])-strlen('.lng'));
			$this->SetLanguage( $lng_token );
			

			$tmp_lng_buffer = array();
			if( $this->ParseFile( $sWorkspaceLng, $tmp_lng_buffer ) ){
				$aSupportedLanguages[sizeof($aSupportedLanguages)] = 
										array(	'name'	=> $tmp_lng_buffer['c0001'],
												'file' => $aLanguageFiles[$i],
												'token' => $lng_token,
											);
			}
			unset($tmp_lng_buffer);
		}//for

		return $aSupportedLanguages;
	}
	
	
	/**
	 * ModuleLanguageFile
	 * 
	 */
	function ModuleLanguageFile( $oVars, $module_id, $workspace )
	{
		if( isset($oVars->cModuleManager))
		{
			$oModule = $oVars->cModuleManager->GetModule( $module_id );
			if( $oModule )
			{
				return EGL_SECURE.'modules'.EGL_DIRSEP.$oModule->sModulePath.EGL_DIRSEP.'workspaces'.EGL_DIRSEP.$workspace.EGL_DIRSEP.'languages'.EGL_DIRSEP.$oVars->sLanguage.'.lng';
			}
		}
		return 'error';
	}
	
};

?>