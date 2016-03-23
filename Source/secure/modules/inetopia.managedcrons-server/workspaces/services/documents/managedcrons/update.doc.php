<?php
	/* Include the NuSOAP library. */ 
	require_once( EGL_SECURE.'libs'.EGL_DIRSEP.'nusoap'.EGL_DIRSEP.'nusoap.php');
	# create the server object
	$server = new soap_server;
	# register the lookup service
	$server->register('run');
	
	/**
	 * run - service
	 */
	function run(){
		global $gl_oVars;
		
		// start managed cron server
		$cManagedCronServer = new ManagedCronServer( $gl_oVars->cDBInterface );
		if( $cManagedCronServer->Update() ){
			return (int)true;
		}else{
			return (int)false;
		}
		return 1;
	}
	
	// send the result as a SOAP response over HTTP
	$server->service($GLOBALS['HTTP_RAW_POST_DATA']);
?>