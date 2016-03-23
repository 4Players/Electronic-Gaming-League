<?php
	global $gl_oVars;
	
	/* Include the NuSOAP library. */ 
	require_once( EGL_SECURE.'libs'.EGL_DIRSEP.'nusoap'.EGL_DIRSEP.'nusoap.php');
	
	
	/*
	$service_uri = "http://localhost/EGL/Beta2/Source/Web/EGL_ROOT/public/services.php?page=01F2A7EB-87D2-4d2f-980C-6B71DC092FAB:update";
	$client = new soapclient( $service_uri ); 
	
	$response = $client->call( 'runUpdate', array() );
	if($client->fault){	
		echo "FAULT:  <p>Code: {$client->faultcode} <br />";
		echo "String: {$client->faultstring} </p>";
	}else
	{
		echo "Response:".$response;
	}*/

	//$acMCServerTimer = new ManagedCronsServerTimer( $gl_oVars->cDBInterface );
	//$acMCServerTimer->RunTimer();
	
	
?>