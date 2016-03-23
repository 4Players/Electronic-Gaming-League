<?php
	/* Include the NuSOAP library. */ 
	/*
	require_once( EGL_SECURE.'libs'.EGL_DIRSEP.'nusoap'.EGL_DIRSEP.'nusoap.php');
	# create the server object
	$server = new soap_server;
	# register the lookup service
	$server->register('ping');
	$server->register('run');
	
	function ping( $send_time, $url ){
		return array(	'received_time'	=> microtime(),
						'resend_time'	=> microtime(),
						'url'			=> PageNavigation::MyURL(),
					);
	}
	function run(){
		
		return "hallo";
	}
	
	// send the result as a SOAP response over HTTP
	$server->service($GLOBALS['HTTP_RAW_POST_DATA']);
	*/
	echo "hallo";
?>