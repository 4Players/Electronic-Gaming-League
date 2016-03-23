<?php

	global $gl_oVars;

	# fetch url data
	$iLadderId	= (int)$_GET['ladder_id'];
	$iGameId = (int)$_GET['game_id'];
	
	# classes & objects
	$cLadderSystem	= new InetopiaLadder( $gl_oVars->cDBInterface );
	$cGamePool = new GamePool( $gl_oVars->cDBInterface );
	$cTeam = new Team( $gl_oVars->cDBInterface );
	
	
	# fetch ladderdata
	$oLadder = $cLadderSystem->GetLadderbyID( $iLadderId );
	$oGame = $cGamePool->GetGameById( $oLadder->game_id );
	
	# ------------------------------------------------------
	# A D D   P A R T I C I P A N T
	# ------------------------------------------------------
	if( $_GET['a']	== 'del_part' )
	{
		$iParId = (int)$_GET['part_id'];
		if( !$cLadderSystem->DeleteParticipant( $iParId ) )
		{
			$gl_oVars->cTpl->assign( 'msg_type',	'error' );
			$gl_oVars->cTpl->assign( 'msg_title',	'Error' );
			$gl_oVars->cTpl->assign( 'msg_text',	'Der Teilnehmer konnte nicht entfernt werden.' );
		}	
		else 
		{
			/*
			$gl_oVars->cTpl->assign( 'msg_type',	'success' );
			$gl_oVars->cTpl->assign( 'msg_title',	'Global Check-In' );
			$gl_oVars->cTpl->assign( 'msg_text',	'Der Teilnehmer wurde erfolgreich hinzugefügt' );*/
		}		
	}
	elseif( $_GET['a']	== 'add_part' )
	{
		$bParticipantExists	= false;
		$iParticipantStartId = 0;
		$iParticipantEndId = 0;
		$bParticipantList = false;
		
		// mass add??
		if( strrpos( $_POST['add_participant_id'], '-' ) )
		{
			$aParts = explode( '-', $_POST['add_participant_id'] );
			$iParticipantStartId = (int)$aParts[0];
			$iParticipantEndId = (int)$aParts[1];
			$bParticipantList = true;
		}
		if( !$bParticipantList )
		{
			if( $oLadder->participant_type == PARTTYPE_TEAM) if( $cTeam->GetTeam( $_POST['add_participant_id'] ) ) $bParticipantExists = true;
			if( $oLadder->participant_type == PARTTYPE_MEMBER) if( $gl_oVars->cMember->GetMemberDataById( $_POST['add_participant_id'] ) ) $bParticipantExists = true;
	
			
			# participant currently exists ?
			if( $bParticipantExists )
			{
				
				# currently entered ?
				if( !$cLadderSystem->IsEnteredLadder($iLadderId, $_POST['add_participant_id'] ))
				{
					$obj = NULL;
					$obj->ladder_id			= $iLadderId;
					$obj->participant_id	= $_POST['add_participant_id'];
					$obj->created			= EGL_TIME;
					$obj->points			= $oLadder->first_points_score;
	
					if( !$cLadderSystem->CreateLadderParticipant( $obj ) )
					{
						DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couln't add participant in 'InetopiaLadder::CreateLadderParticipant'" );
					}
					else
					{
						$gl_oVars->cTpl->assign( 'success', 	true );
						$gl_oVars->cTpl->assign( 'msg_type',	'success' );
						$gl_oVars->cTpl->assign( 'msg_title',	'Teilnehmer hinzuzgefügt' );
						$gl_oVars->cTpl->assign( 'msg_text',	'Der Teilnehmer wurde erfolgreich hinzugefügt' );
					}
				}
				else
				{
					$gl_oVars->cTpl->assign( 'msg_type',	'error' );
					$gl_oVars->cTpl->assign( 'msg_title',	'Error' );
					$gl_oVars->cTpl->assign( 'msg_text',	'Der Teilnehmer wurde bereits eingetragen.' );
				}//if
			}
			else
			{
				$gl_oVars->cTpl->assign( 'msg_type',	'error' );
				$gl_oVars->cTpl->assign( 'msg_title',	'Error' );
				$gl_oVars->cTpl->assign( 'msg_text',	'Dieser Teilnehmer ist in der Datenbank nicht eingetragen.' );
			}//if
		}//if
		else
		{
			//$bParticipantExists = false;
			if( $iParticipantStartId < $iParticipantEndId )
			{
				for( $i=$iParticipantStartId; $i < $iParticipantEndId; $i++ )
				{
					$bParticipantExists  = false;
					if( $oLadder->participant_type == PARTTYPE_TEAM) if( $cTeam->GetTeam( $i ) ) $bParticipantExists = true;
					if( $oLadder->participant_type == PARTTYPE_MEMBER) if( $gl_oVars->cMember->GetMemberDataById( $i ) ) $bParticipantExists = true;
	
					# participant currently exists ?
					if( $bParticipantExists )
					{
						# currently entered ?
						if( !$cLadderSystem->IsEnteredLadder( $iLadderId, $i ))
						{
							$obj = NULL;
							$obj->ladder_id			= $iLadderId;
							$obj->participant_id	= $i;
							$obj->created			= EGL_TIME;
							$obj->points			= $oLadder->first_points_score;							
							
			
							if( !$cLadderSystem->CreateLadderParticipant( $obj ) )
							{
								DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couln't add participant in 'InetopiaLadder::CreateLadderParticipant'" );
							}
							else
							{
								/*
								$gl_oVars->cTpl->assign( 'success', 	true );
								$gl_oVars->cTpl->assign( 'msg_type',	'success' );
								$gl_oVars->cTpl->assign( 'msg_title',	'Teilnehmer hinzuzgefügt' );
								$gl_oVars->cTpl->assign( 'msg_text',	'Die Teilnehmer wurden erfolgreich hinzugefügt' );*/
							}
						}
						else
						{
							/*
							$gl_oVars->cTpl->assign( 'msg_type',	'error' );
							$gl_oVars->cTpl->assign( 'msg_title',	'Error' );
							$gl_oVars->cTpl->assign( 'msg_text',	'Der Teilnehmer wurde bereits eingetragen.' );
							*/
						}//if
					}
					else
					{
						/*
						$gl_oVars->cTpl->assign( 'msg_type',	'error' );
						$gl_oVars->cTpl->assign( 'msg_title',	'Error' );
						$gl_oVars->cTpl->assign( 'msg_text',	'Dieser Teilnehmer ist in der Datenbank nicht eingetragen.' );
						*/
					}//if
			
				}//for
			}//if
				
			$gl_oVars->cTpl->assign( 'success', 	true );
			$gl_oVars->cTpl->assign( 'msg_type',	'success' );
			$gl_oVars->cTpl->assign( 'msg_title',	'Teilnehmer hinzuzgefügt' );
			$gl_oVars->cTpl->assign( 'msg_text',	'Die Teilnehmer wurden erfolgreich hinzugefügt' );

				
		}//if $bParticipantList		
		
		
	}//if
	
	
	
	$participants_per_page 	= 50;
	$limit_start			= (int)$_GET['pos'];
	$num_participants		= $cLadderSystem->GetNumLadderParticipants($iLadderId);
	
	
	$num_pages	= $num_participants/$participants_per_page;
	if( !is_int($num_pages) ) $num_pages = ((int)$num_pages)+1;	
	if( $limit_start == 0 ) $curr_page=0;
	else $curr_page = (int)($limit_start/$participants_per_page);

	
	# get ladder participants	
	$aLadderParticipants = $cLadderSystem->GetLadderParticipants( $oLadder->participant_type, $iLadderId, $limit_start, $participants_per_page );



	$gl_oVars->cTpl->assign( 'participants_per_page', $participants_per_page );
	$gl_oVars->cTpl->assign( 'num_pages', $num_pages );
	$gl_oVars->cTpl->assign( 'curr_page', $curr_page );
		
	
	# provide template with data
	$gl_oVars->cTpl->assign( 'ladder', 	$oLadder );
	$gl_oVars->cTpl->assign( 'game', $oGame );
	
	$gl_oVars->cTpl->assign( 'ladder_participants', $aLadderParticipants );
	$gl_oVars->cTpl->assign( 'num_ladder_participants', $num_participants );
?>