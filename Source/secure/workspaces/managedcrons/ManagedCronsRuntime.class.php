<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================

// require_once( EGL_PUBLIC . 'workspace.init.php' );

class ManagedCronsRuntime extends RuntimeEngine 
{
	/**
	* RuntimeEngine::InitDatabase -> Overloaded
	**/	
	function InitDatabase()
	{
		return $this->SetDatabaseConnectingData( new db_connecting_data() /*standard connection data*/ );
	}

	/**
	* RuntimeEngine::PageAccessCheck -> Overloaded
	**/	
	function PageAccessCheck()
	{
		global $gl_oVars;
		$sAccessKey = $_GET['key'];
		if( strlen($sAccessKey) == 0 ) return 0;
		
		// create config object
		$cConfigs = new DBConfigs( $gl_oVars->cDBInterface );
		$aEGLConfigs = $cConfigs->FetchConfigArray();
		
		if( isset( $aEGLConfigs['managedcrons_key'] ))
		{
			if( $aEGLConfigs['managedcrons_key'] == $sAccessKey )
			{
				return 1;
			}
		}
		return 0;
	}
}

?>