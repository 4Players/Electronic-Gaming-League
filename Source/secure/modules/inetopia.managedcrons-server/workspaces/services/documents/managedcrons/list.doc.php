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
	function run( $key ){
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
			$output_tasks 	= array();
			$aManagedCronsList	= array();
			
			$aTaskList = $cMCServer->GetTasksByMemberId( $oMCUserService->member_id );
			
			#======================================================
			# filter ´registered crons, to essential information
			#
			#
			# 
			#======================================================
			for( $c=0; $c < sizeof($aTaskList); $c++ )
			{
				$bActivated = false;
				if( $aTaskList[$c]->member_id == $oMCUserService->member_id )
					$bActivated = true;
					
				$output_tasks[$c] = array( 	'managedcron_id' 		=> $aTaskList[$c]->managedcron_id,
											'name'					=> $aTaskList[$c]->name,
											'required_moduleid'		=> $aTaskList[$c]->required_moduleid,
											'required_version'		=> $aTaskList[$c]->required_version,
											'update_rate'			=> $aTaskList[$c]->update_rate,
											'uri_type'				=> $aTaskList[$c]->uri_type,
											'uri'					=> $aTaskList[$c]->uri,
											'description'			=> $aTaskList[$c]->description,
											'image'					=> $aTaskList[$c]->image,
											'activated'				=> $bActivated,
											'calls'					=> $aTaskList[$c]->calls,
											'calls_failed'			=> $aTaskList[$c]->calls_failed,
											'last_call'				=> $aTaskList[$c]->last_call,
											);
			}//for
			return $output_tasks;
		}
		else
		{
			//return run('aAjs8311000Oshuzt63js76k6i74sg015233');
			return new soap_fault( 'unknownkey_request', 'ManagedCrons-Server', 'Unknown key request', '' );
		}//if
		
	}//if
	
	//echo nl2br( print_r( run('aAjs8311000Oshuzt63js76k6i74sg015233'), 1));
	// send the result as a SOAP response over HTTP
	$server->service($GLOBALS['HTTP_RAW_POST_DATA']);
?>