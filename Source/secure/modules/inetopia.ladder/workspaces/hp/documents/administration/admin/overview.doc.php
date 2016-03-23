<?php

	global $gl_oVars;

	# fetch url data
	$iLadderId	= (int)$_GET['ladder_id'];
	//$iGameId = (int)$_GET['game_id'];
	
	
	# classes & objects
	$cLadderSystem	= new InetopiaLadder( $gl_oVars->cDBInterface );
	$cGamePool = new GamePool( $gl_oVars->cDBInterface );
	$cMatchStructures = new MatchStructures( $gl_oVars->cDBInterface );
	$cMatch = new Match( $gl_oVars->cDBInterface );


	# fetch ladderdata
	$oLadder = $cLadderSystem->GetLadderbyID( $iLadderId );
	
	# ladder available?
	if( $oLadder )
	{
		$oGame = $cGamePool->GetGameById( $oLadder->game_id );
	
		$numLadderParticipants 	= $cLadderSystem->GetNumLadderParticipants( $oLadder->id );
		$num_encounts			= $cLadderSystem->GetNumLadderEncounts( $oLadder->id);
	
		# limited?	
		if( $oLadder->max_participants > 0 )
			$efficiency				= round( (($numLadderParticipants/$oLadder->max_participants)*100), 1);
	
		# fetch adminlist
		$aAdminlist = $cLadderSystem->GetLadderAdministrator( $oLadder->id );
	
		# provide template with data
		$gl_oVars->cTpl->assign( 'ladder', 	$oLadder );
		$gl_oVars->cTpl->assign( 'game', $oGame );
		$gl_oVars->cTpl->assign( 'num_participants', $numLadderParticipants );
		$gl_oVars->cTpl->assign( 'num_encounts', $num_encounts );
		$gl_oVars->cTpl->assign( 'efficiency', $efficiency );
		$gl_oVars->cTpl->assign( 'adminlist', $aAdminlist );
	}
?>