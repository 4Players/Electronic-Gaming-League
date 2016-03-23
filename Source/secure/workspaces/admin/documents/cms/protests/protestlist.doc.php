<?php
	global $gl_oVars;

	
	$cMatch 	= new Match( $gl_oVars->cDBInterface, NULL );
	$cProtests	= new Protests( $gl_oVars->cDBInterface );


	# fetch data
	$aProtests	= $cProtests->GetAdminProtests( EGL_TIME, 60*10 /* 15 mins*/ );

	
	
	# tpl
	$gl_oVars->cTpl->assign( 'protests',  $aProtests );

?>