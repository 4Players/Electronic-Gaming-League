<?php

	global $gl_oVars;

	# fetch url data
	$iLadderId	= (int)$_GET['ladder_id'];
	//$iGameId = (int)$_GET['game_id'];
	# classes & objects
	$cLadderSystem		= new InetopiaLadder( $gl_oVars->cDBInterface );
	$cGamePool 			= new GamePool( $gl_oVars->cDBInterface );
	$cMatchStructures 	= new MatchStructures( $gl_oVars->cDBInterface );
	$cMatch 			= new Match( $gl_oVars->cDBInterface );


	# fetch ladderdata
	$oLadder = $cLadderSystem->GetLadderbyID( $iLadderId );
	
	if( $oLadder )
	{
		$oGame = $cGamePool->GetGameById( $oLadder->game_id );
		
		
			# provide template with data
		$gl_oVars->cTpl->assign( 'ladder', 	$oLadder );
		$gl_oVars->cTpl->assign( 'game', $oGame );
	}
?>