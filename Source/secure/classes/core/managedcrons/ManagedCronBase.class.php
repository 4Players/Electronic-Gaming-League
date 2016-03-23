<?php
# ================================ Copyright © 2004-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ class ] -
class ManagedCronBase
{
	# -[ variables ]-
	var $pDBInterfaceCon	= NULL;

	
	/**
	 * constructor
	 * 
	 * 
	 */
	function ManagedCronBase( &$pDBCon )
	{
		$this->pDBInterfaceCon = &$pDBCon;
	}
	
	/**
	 * 
	 * param array	managed-cron-data (array(
	 */
	function VersionCheck( $required_moduleid, $required_version )
	{
		// no module service?
		if( $required_moduleid == EGL_NO_ID ){
			
			// versioncehck EGL_CURRENT_VERSION, 	$required_version
			$check_success = __check_version( EGL_CURRENT_VERSION, $required_version );
			if( $check_success ){
				return true;
			}//if
			else return false;
			
		}
		// module service
		else{
			global $gl_oVars;
			$oModule = $gl_oVars->cModuleManager->GetModule( $required_moduleid );
			if( $oModule ){
			
				// check	
				$check_success = __check_version( $oModule->sVersion, $required_version );
				if( $check_success ){
					return true;
				}
				else return false;
			}//if
			return false;
		}//if
	}
};

?>