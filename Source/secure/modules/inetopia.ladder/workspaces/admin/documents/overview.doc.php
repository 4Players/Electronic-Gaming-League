<?php

	global $gl_oVars;

	# fetch URL informations
	//$iLadderId		= (int)$_GET['ladder_id'];
	
	

	# declare classes /objects
	$cLadderSystem	= new InetopiaLadder( $gl_oVars->cDBInterface );
	$cGamePool		= new GamePool( $gl_oVars->cDBInterface );
	
	
	# fetch cuplist with participants !!
	//$aCups 	= $cCup->GetCups();
	//$aGames = $cGamePool->GetGames();
	/*
	# fetch cup admins
	for( $i=0; $i < sizeof($aCups); $i++ )
	{
		$aCups[$i]->adminlist = $cCup->GetCupAdministrator( $aCups[$i]->id );
	}*/
	$aGames	 = array();

	
	# fetch gamedata
	$sql_query = " SELECT games.*, COUNT(ladders.game_id) AS num_gameladders FROM {$GLOBALS['g_egltb_game_pool']} AS games ".
				 " LEFT JOIN {$GLOBALS['g_egltb_ladders']} AS ladders " .
				 " ON ladders.game_id=games.id ".
				 " GROUP BY games.id ".
				 " ORDER BY games.name ASC ";
	$aGames = $gl_oVars->cDBInterface->FetchArrayObject( $gl_oVars->cDBInterface->Query( $sql_query ) );
	
	
	# set template vars
	//$gl_oVars->cTpl->assign( 'ladders',	$aCups );
	$gl_oVars->cTpl->assign( 'games',	$aGames );
?>