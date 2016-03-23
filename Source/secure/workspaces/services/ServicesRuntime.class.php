<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================

// require_once( EGL_PUBLIC . 'workspace.init.php' );

class ServicesRuntime extends RuntimeEngine 
{
	
	/**
	* ServicesRuntime::EvaluateLoginstate();
	*
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
	* ServicesRuntime::InitDatabase();
	*
	*
	*/
	function InitDatabase()
	{
		return $this->SetDatabaseConnectingData( new db_connecting_data() );
	}

	
	
	/**
	* ServicesRuntime::InitPage();
	*
	*
	*/

	function InitPage()
	{
		global $gl_oVars;
		
	
		return 1;			
	}
	
	
	/**
	* ServicesRuntime::FirstInits();
	*
	*
	*/
	function FirstInits()
	{
		return $this->SetDebugSecurity( EGL_DEBUGSECURITY_LOW );
	}


	/**
	* ServicesRuntime::LastInits();
	*
	*
	*/
	function LastInits()
	{
		global $gl_oVars;
		return 1;	
	}
	
}



?>