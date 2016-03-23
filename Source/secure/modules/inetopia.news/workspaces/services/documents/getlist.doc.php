<?php
	/* Include the NuSOAP library. */ 
	require_once( EGL_SECURE.'libs/nusoap/nusoap.php');
	
	
	# create the server object
	$server = new soap_server();
		
	function getNews( $limit_start, $limit_cnt ) 
	{
		# global access variable
		global $gl_oVars;
		$cNews = new News( $gl_oVars->cDBInterface );
		return $cNews->GetNews( $limit_start, $limit_cnt );
	}
	
	
	# register the lookup service
	$server->register('getNews');

	
		// send the result as a SOAP response over HTTP
	$server->service($GLOBALS['HTTP_RAW_POST_DATA']);
	//exit();
?>