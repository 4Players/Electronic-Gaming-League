<?php
	/* Include the NuSOAP library. */ 
	require_once( EGL_SECURE.'libs'.EGL_DIRSEP.'nusoap'.EGL_DIRSEP.'nusoap.php');
	# create the server object
	$server = new soap_server;
	# register the lookup service
	$server->register('run');
	
	/**
	 * SERVICE: managedcron_services
	 * 
	 * fetch managedcron-services available
	 */
	function run( $key, $managedcron_id ){
		global $gl_oVars;

		// objects/classes		
		$cMCServer = new ManagedCronsServer( $gl_oVars->cDBInterface );
		
		// try fetching registered service/user
		$oMCUserService = $cMCServer->GetServiceByKey( $key );
		
		
		#---------------------------------------------------
		# access to current user available??
		#---------------------------------------------------
		if( $oMCUserService )
		{
			// 1. ManagedCron available?
			$oManagedCron = $cMCServer->GetManagedCronByID( $managedcron_id );
			$oTask = $cMCServer->GetManagedCronTask( (int)$oMCUserService->member_id, (int)$oManagedCron->id );
			if( $oManagedCron && !$oTask )
			{
				// 2. ManagedCron currently registered?
				$managed_cron = array( 	'mc_id'			=> $oManagedCron->id,
										'member_id'		=> (int)$oMCUserService->member_id,
										'url'			=> '',
										'created'		=> EGL_TIME,
									);
				if( $cMCServer->RegisterTask( $managed_cron ) )
				{
					return 1;
				}
			}//if
		}
		else
		{
			return 0;
		}//if
	}//if
	
	
	// send the result as a SOAP response over HTTP
	$server->service($GLOBALS['HTTP_RAW_POST_DATA']);
?>