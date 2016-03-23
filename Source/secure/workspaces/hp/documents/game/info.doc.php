<?php
	global $gl_oVars;
	$iGameId	= (int)$_GET['game_id'];
	
	header( "location: {$gl_oVars->sURLFile}?page=chosegame&game_id={$iGameId}" );
	/*
	# read all games
	$cGamePool = new GamePool( $gl_oVars->cDBInterface );
	
	$aGames = $cGamePool->GetGameList($iGameId  );
	$oGame = $aGames[0];	# select received game data
	

	$gl_oVars->cTpl->assign( 'game',	$oGame );
	*/
?>