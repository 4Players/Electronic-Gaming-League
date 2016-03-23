<?php
	global $gl_oVars;
	
	// define GamePool
	$cGame = new GamePool( $gl_oVars->cDBInterface );

	$aGames = array();
	$aGames = $cGame->GetGames();
	

	$gl_oVars->cTpl->assign( "games", $aGames );
	
?>