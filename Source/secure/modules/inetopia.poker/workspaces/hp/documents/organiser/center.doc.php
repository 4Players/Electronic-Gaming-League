<?php
	global $gl_oVars;
	$cPokerOrganiser = new PokerOrganiser( $gl_oVars->cDBInterface );
	
	// header params
	$iOrganiserId = (int)$_GET['organiser_id'];

	// fetch data
	$oOrganiser 	= $cPokerOrganiser->GetOrganiserById( $iOrganiserId );
	$oLastSessions 	= $cPokerOrganiser->GetOrganiserSessions( $iOrganiserId );
	
	
	// provide template with data
	$gl_oVars->cTpl->assign( 'organiser', $oOrganiser );
	$gl_oVars->cTpl->assign( 'org_sessions', $oLastSessions );
?>