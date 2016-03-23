<?php
/*
	//$URL = 'http://localhost/EGL/Beta2/Source/Web/EGL_ROOT/public/index.php?page=A9CCDCBF-C696-422c-A0D8-91223A9C22E6:fastchallenge_update';
	//$URL = 'http://localhost/EGL/Beta2/Source/Web/EGL_ROOT/public/managedcrons.php?page=A9CCDCBF-C696-422c-A0D8-91223A9C22E6:fastchallenge.update&key=aAjs8311000Oshuzt63js76k6i74sg015233';


	$key = 'aAjs8311000Oshuzt63js76k6i74sg015233';
	$URL = 'http://localhost/EGL/Beta2/Source/Web/EGL_ROOT/public/managedcrons.php?page=01F2A7EB-87D2-4d2f-980C-6B71DC092FAB:timer&key='.$key;
	//$URL = 'http://localhost/EGL/WEB/EGL.Online!/public/managedcrons.php?page=01F2A7EB-87D2-4d2f-980C-6B71DC092FAB:timer&key='.$key;
	
	

	//$root = '/html/electronicgamingleague/hp/cron/';
	//$nusoap_root = '/html/electronicgamingleague/hp/cron/';
	
	require( 'D:\Development\Projekte\EGL\Beta2\Source\Web\EGL_ROOT\secure\libs\nusoap\nusoap.php' );
	$client = new soapclient($URL);


	$response = $client->call( 'run' );
	echo $client->reponse;
	echo $response;
*/
//mail( 'kf@inetopia.de', 'test', 'test' );
?>
