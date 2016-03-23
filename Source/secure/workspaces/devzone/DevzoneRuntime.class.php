<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



class DevzoneRuntime extends RuntimeEngine 
{
	
	/**
	* DevZoneRuntime::EvaluateLoginstate()
	*
	*/
	function EvaluateLoginstate()
	{
		#-----------------------------------------------
		# define global variables
		#-----------------------------------------------
		global $gl_oVars;		

	return 1;
	}
	

	
	/**
	* DevZoneRuntime::InitDatabase()
	*
	*/
	function InitDatabase()
	{
		return $this->SetDatabaseConnectingData( new db_connecting_data() );
	}

	
	
	/**
	* DevZoneRuntime::InitPage()
	*
	*/
	function InitPage()
	{
		global $gl_oVars;
		
	
		return 1;			
	}
	
	
	/**
	* DevZoneRuntime::FirstInits()
	*
	*/
	function FirstInits()
	{
		return $this->SetDebugSecurity( EGL_DEBUGSECURITY_LOW );
	}

	
	/**
	* DevZoneRuntime::LastInits()
	*
	*/
	function LastInits()
	{
		global $gl_oVars;
		
		$cLanguage = new Language();
		
		$aSupportedLanguages = $cLanguage->GetSupportedLanguagesFromWorkspace( $gl_oVars->sWorkspace );
		for( $i=0; $i < sizeof($aSupportedLanguages); $i++ ){
			$lng_file = EGL_PUBLIC.'files'.EGL_DIRSEP.'country_pool'.EGL_DIRSEP.$aSupportedLanguages[$i]['tolen'].'gif';
			if( file_exists($lng_file) ){
				$aSupportedLanguages[$i]['lng_file'] = $aSupportedLanguages[$i]['tolen'].'gif';
			}else{
			$aSupportedLanguages[$i]['lng_file'] = '';
			}
		}
		$gl_oVars->cTpl->assign( 'SUPPORTED_LNG', $aSupportedLanguages );		
		
		
		return 1;	
	}
	
};
?>