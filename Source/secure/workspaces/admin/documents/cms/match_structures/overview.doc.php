<?php
	global $gl_oVars;
	
	// define GamePool
	$cGame = new GamePool( $gl_oVars->cDBInterface );
	$cMatchStructures = new MatchStructures( $gl_oVars->cDBInterface );
	$cMatch = new Match( $gl_oVars->cDBInterface, NULL );

	$aGames = array();
	$aGames = $cGame->GetGames();
	
	$aMatchStructures = $cMatchStructures->GetMatchStructures();
	
	$gl_oVars->cTpl->assign( "games", $aGames );
	$gl_oVars->cTpl->assign( "match_structures", $aMatchStructures );
	
?>