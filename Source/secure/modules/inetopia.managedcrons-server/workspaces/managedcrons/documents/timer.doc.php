<?php
	/* Include the NuSOAP library. */ 
	require_once( EGL_SECURE.'libs'.EGL_DIRSEP.'nusoap'.EGL_DIRSEP.'nusoap.php');
	# create the server object
	$server = new soap_server;
	# register the lookup service
	$server->register('ping');
	$server->register('run');
	
	/**
	 * ping
	 */
	function ping( $send_time, $url ){
		return array(	'received_time'	=> microtime(),
						'resend_time'	=> microtime(),
						'url'			=> PageNavigation::MyURL(),
					);
	}
	
	/**
	 * run
	 */
	function run(){
		global $gl_oVars;

		$acMCServerTimer = new ManagedCronsServerTimer( $gl_oVars->cDBInterface );
		$acMCServerTimer->RunTimer();
		return 1;
	}
	
	// send the result as a SOAP response over HTTP
	$server->service($GLOBALS['HTTP_RAW_POST_DATA']);
	// d:\Web\php5\php.exe d:\Development\Projekte\EGL\Beta2\Source\Web\EGL_ROOT\cron\execute.php
?>
