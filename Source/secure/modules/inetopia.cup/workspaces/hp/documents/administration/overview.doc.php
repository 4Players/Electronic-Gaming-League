<?php
	global $gl_oVars;


	# declare classes /objects
	$cCup		= new Cup( $gl_oVars->cDBInterface, NULL /*NO-ID*/ );
	$cGamePool	= new GamePool( $gl_oVars->cDBInterface );
	
	
	# declare vars
	$aGames	 = array();

	
	# fetch gamedata
	$sql_query = " SELECT games.*, COUNT(cups.game_id) AS num_gamecups FROM `{$GLOBALS['g_egltb_game_pool']}` AS games ".
				 " LEFT JOIN `{$GLOBALS['g_egltb_cups']}` AS cups " .
				 " ON cups.game_id=games.id ".
				 " GROUP BY games.id ".
				 " ORDER BY games.name ASC ";
	$aGames = $gl_oVars->cDBInterface->FetchArrayObject( $gl_oVars->cDBInterface->Query( $sql_query ) );
	
	
	# set template vars
	$gl_oVars->cTpl->assign( 'games',	$aGames );
?>