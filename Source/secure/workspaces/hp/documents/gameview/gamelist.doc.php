<?php
	global $gl_oVars;
	$cGamePool 	= new GamePool( $gl_oVars->cDBInterface );
	$aGamelist = $cGamePool->GetGames();

	
	$gl_oVars->cTpl->assign( "gamelist", $aGamelist );
?>