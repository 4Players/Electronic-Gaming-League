<?php
	/*
	GetOpenProtestsByMemberId
	GetAdministratedProtestsByMemberId
	*/
	global $gl_oVars;

	
	$cMatch 	= new Match( $gl_oVars->cDBInterface, NULL );
	$cProtests	= new Protests( $gl_oVars->cDBInterface );
	
	$iMemberId	= $gl_oVars->iMemberId;
	$aProtests = array();
	

	# fetch data
	if( $_GET['display'] == 'all' ){
		$aProtests = $cProtests->GetProtestsByMemberId( $iMemberId );
	}
	else if( $_GET['display'] == 'open' ){
		$aProtests	= $cProtests->GetOpenProtestsByMemberId( $iMemberId /*, EGL_TIME, 60*10*/ );
	}
	else if( $_GET['display'] == 'closed' ){
		$aProtests	= $cProtests->GetAdministratedProtestsByMemberId( $iMemberId );
	}
	else{
		$aProtests	= $cProtests->GetOpenProtestsByMemberId( $iMemberId /*, EGL_TIME, 60*10*/ );
	}
		
	# tpl
	$gl_oVars->cTpl->assign( 'protests',  $aProtests );
?>