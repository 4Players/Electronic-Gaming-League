<?php

	global $gl_oVars;

	# fetch url data
	$iLadderId	= (int)$_GET['ladder_id'];
	$iGameId = (int)$_GET['game_id'];
	
	
	# classes & objects
	$cLadderSystem	= new InetopiaLadder( $gl_oVars->cDBInterface );
	$cGamePool = new GamePool( $gl_oVars->cDBInterface );
	$cMatchStructures = new MatchStructures( $gl_oVars->cDBInterface );
	$cMatch = new Match( $gl_oVars->cDBInterface );

	
	# fetch ladderdata
	$oLadder = $cLadderSystem->GetLadderbyID( $iLadderId );
	$oGame = $cGamePool->GetGameById( $oLadder->game_id );

	$aParticipants = $cLadderSystem->GetLadderParticipants( $oLadder->participant_type, $oLadder->id );

	
	/*
	$aStatisticCounter = array();
	for( $i=0; $i < sizeof($aParticipants); $i++ )
	{
		$year 	= strftime( '%y', $aParticipants[$i]->created );
		$month 	= strftime( '%m', $aParticipants[$i]->created );
		$day 	= strftime( '%d', $aParticipants[$i]->created );
		$hour 	= 0; //strftime( '%H', $aParticipants[$i]->created );
		$min 	= 0; //strftime( '%M', $aParticipants[$i]->created );
		$sec 	= 0; //strftime( '%S', $aParticipants[$i]->created );

		$array_item = (string)mktime($hour, $min, $sec, $month, $day, $year);
		if( !isset($aStatisticCounter[$array_item])) 
		{
			$aStatisticCounter[$array_item] = array();
		}else
		{
		}
		$aStatisticCounter[$array_item][sizeof($aStatisticCounter[$array_item])] = $aParticipants[$i];
		//echo "<br/>".$array_item;
	}*/
	

	# provide template with data
	$gl_oVars->cTpl->assign( 'ladder', 	$oLadder );
	$gl_oVars->cTpl->assign( 'game', $oGame );
	$gl_oVars->cTpl->assign( 'matchstructure', $oMatchStructure );
?>