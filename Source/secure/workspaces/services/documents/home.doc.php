<?php

	require_once( EGL_SECURE.'libs/nusoap/nusoap.php');
	
	// create the server object
	$server = new soap_server;
	$server->fault( 'soap:Server','http://www.electronicgamingleague.com/', "EGL Service error - Unknown service request" );
	
	// send the result as a SOAP response over HTTP
	$server->service($HTTP_RAW_POST_DATA);
	
?>