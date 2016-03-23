<?php
	/* Include the NuSOAP library. */ 
	require_once( EGL_SECURE.'libs'.EGL_DIRSEP.'nusoap'.EGL_DIRSEP.'nusoap.php');
	# create the server object
	$server = new soap_server;

		$server->fault( 'soap:Server','http://www.electronicgamingleague.com/', "ManagedCron Service error - Unknown service request" );
	
		
	// send the result as a SOAP response over HTTP
	$server->service($GLOBALS['HTTP_RAW_POST_DATA']);
?>