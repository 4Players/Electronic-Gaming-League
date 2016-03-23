<?php
	global $gl_oVars;

	
	$cMatch 	= new Match( $gl_oVars->cDBInterface, NULL );
	$cProtests	= new Protests( $gl_oVars->cDBInterface );


	$aProtests = array();
	$adminaccess_time = 600; // 10 mins
	
	$cProtests->RefreshActiveProtests( $adminaccess_time );

	# fetch data
	if( $_GET['display'] == 'all' ){
		$aProtests = $cProtests->GetProtests();
	}
	else if( $_GET['display'] == 'open' ){
		$aProtests	= $cProtests->GetAdminProtests( EGL_TIME, $adminaccess_time, $gl_oVars->iMemberId /* 15 mins*/ );
	}
	else if( $_GET['display'] == 'closed' ){
		$aProtests	= $cProtests->GetAdministratedProtests();
	}
	else{
		$aProtests	= $cProtests->GetAdminProtests( EGL_TIME, $adminaccess_time, $gl_oVars->iMemberId /* 15 mins*/ );
	}
		
	# tpl
	$gl_oVars->cTpl->assign( 'protests',  $aProtests );
?>