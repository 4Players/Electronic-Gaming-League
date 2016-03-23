<?php
	global $gl_oVars;

	
	# -----------------------------------------------
	# Logout
	# -----------------------------------------------
	if( $gl_oVars->bLoggedIn )
	{
		$gl_oVars->cLogin->Logout( $gl_oVars->iMemberId );
		$gl_oVars->bLoggedIn = false;
		$gl_oVars->iMemberId = -1;

		$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
		$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c1030'] );
		
		PageNavigation::Location( $gl_oVars->sURLFile.'?page=home' );
		//PageNavigation::Location( "" );
	}
	else
	{
		$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
		$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c1031'] );
	
		PageNavigation::Location( $gl_oVars->sURLFile.'?page=home' );
	}
?>