<?php
	global $gl_oVars;

	/*

	$cPolls = new Polls( $gl_oVars->cDBInterface );
	
	# fetch polls
	$aPolls = $cPolls->getDetailledPolls();
	
	
	# setup poll-list in templatesystem
	$gl_oVars->cTpl->assign( 'polls', $aPolls );*/

	header( 'location: '.$gl_oVars->sURLFile.'?page='.$gl_oVars->sModuleId.':categories');
?>