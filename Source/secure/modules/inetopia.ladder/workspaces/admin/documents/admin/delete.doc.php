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
	
		
		if( $_GET['a']	== 'delete' )
		{
			if( $_POST['delete_mode'] == 'all' )
			{
				# delete match & encounts
				$cLadderSystem->DeleteMatchEncounts( $iLadderId );
				
				# delete participants
				$cLadderSystem->DeleteLadderParticipants( $iLadderId );
				
				# delete cup
				$cLadderSystem->DeleteLadder( $iLadderId );
				
				$gl_oVars->cTpl->assign ( 'success', 	true );
				$gl_oVars->cTpl->assign ( 'msg_type', 	'success' );
				$gl_oVars->cTpl->assign ( 'msg_title', 	'Turnier gelöscht' );
				$gl_oVars->cTpl->assign ( 'msg_text', 	'Die Ladder wurde hiermit unwiderruflich gelöscht.' );
			}
			elseif( $_POST['delete_mode'] == 'patches' )
			{
				if( $_POST['delete_matches'] == 'yes' ) $cLadderSystem->DeleteLadderMatchesByModuleData( $iLadderId );
				if( $_POST['delete_matches'] == 'yes' ) $cLadderSystem->DeleteLadderEncounts( $iLadderId );
				if( $_POST['delete_participants'] == 'yes' )  $cLadderSystem->DeleteLadderParticipants( $iLadderId );
				if( $_POST['reset_points'] == 'yes' )  $cLadderSystem->ResetLadderParticipantPoints( $iLadderId, $oLadder->first_points_score );
				
				
				$gl_oVars->cTpl->assign ( 'success', 	true );
				$gl_oVars->cTpl->assign ( 'msg_type', 	'success' );
				$gl_oVars->cTpl->assign ( 'msg_title', 	'Turnierdaten gelöscht' );
				$gl_oVars->cTpl->assign ( 'msg_text', 	'Einige Ladderdaten wurden hiermit unwiderruflich gelöscht.' );

			}
			else
			{
				$gl_oVars->cTpl->assign ( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign ( 'msg_title', 	'Fehler' );
				$gl_oVars->cTpl->assign ( 'msg_text', 	'Es muss ein bestimmter Lösch Modus ausgewählt sein' );
			}
			
		}//if $_GET
		
		
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