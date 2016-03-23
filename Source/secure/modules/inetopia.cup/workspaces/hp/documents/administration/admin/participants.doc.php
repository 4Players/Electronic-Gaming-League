<?php
	global $gl_oVars;

	$iCupId			= (int)$_GET['cup_id'];
	$iParticipantId	= (int)$_GET['part_id'];
	$iCupPartId		= (int)$_GET['cuppart_id'];
	
	
	
	# declare classes
	$cCup 		= new Cup( $gl_oVars->cDBInterface, (int)$_GET['cup_id'] );
	$cTeam		= new Team( $gl_oVars->cDBInterface );
	$cGamePool			= new GamePool( $gl_oVars->cDBInterface );
	
	
	# fetch data
	$oCup = $cCup->GetData();
	$oGame = $cGamePool->GetGameById( (int)$oCup->game_id );
	
	
	# ACTION :: Add participant
	if( $oCup )
	{
		if( $_GET['a']	== 'global_checkin' )
		{
			$cCup->ExecuteGlobaleCheckin( $oCup->id );
			
		}		
		else if( $_GET['a']	== 'global_checkout' )
		{
			$cCup->ExecuteGlobaleCheckout( $oCup->id );
			
		}
		else if( $_GET['a']	== 'global_remove' )
		{
			$cCup->DeleteCupParticipants( $oCup->id );
			
		}
		else if( $_GET['a']	== 'remove' )
		{
			$iParticipantId = (int)$_GET['cuppart_id'];
			if( !$cCup->DeleteParticipant( $iParticipantId ) )
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
		else if( $_GET['a']	== 'add_part' )
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
				if( $oCup->participant_type == PARTTYPE_TEAM) if( $cTeam->GetTeam( $_POST['add_participant_id'] ) ) $bParticipantExists = true;
				if( $oCup->participant_type == PARTTYPE_MEMBER) if( $gl_oVars->cMember->GetMemberDataById( $_POST['add_participant_id'] ) ) $bParticipantExists = true;

				
				# participant currently exists ?
				if( $bParticipantExists )
				{
					# currently entered ?
					if( !$cCup->IsEnteredCup($iCupId, (int)$_POST['add_participant_id'] ))
					{
						$obj = NULL;
						$obj->cup_id			= $iCupId;
						$obj->participant_id	= $_POST['add_participant_id'];
						$obj->created			= EGL_TIME;
	
						if( !$cCup->CreateCupParticipant( $obj ) )
						{
							DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couln't add participant in 'Cup::CreateCupParticipant'" );
						}
						else
						{
							$gl_oVars->cTpl->assign( 'msg_type',	'success' );
							$gl_oVars->cTpl->assign( 'msg_title',	'Teilnehmer hinzuzgefügt' );
							$gl_oVars->cTpl->assign( 'msg_text',	'Der Teilnehmer wurde hinzugefügt' );
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
					$gl_oVars->cTpl->assign( 'msg_text',	'Dieses Mitglied existiert nicht.' );
				}//if
			}//if
			
			# =======================================================
			# ADD MEMBER / TEAM -LIST
			# =======================================================
			else
			{
				//$bParticipantExists = false;
				if( $iParticipantStartId < $iParticipantEndId )
				{
					for( $i=$iParticipantStartId; $i < $iParticipantEndId; $i++ )
					{
						$bParticipantExists  = false;
						if( $oCup->participant_type == PARTTYPE_TEAM) if( $cTeam->GetTeam( $i ) ) $bParticipantExists = true;
						if( $oCup->participant_type == PARTTYPE_MEMBER) if( $gl_oVars->cMember->GetMemberDataById( $i ) ) $bParticipantExists = true;
		
						# participant currently exists ?
						if( $bParticipantExists )
						{
							# currently entered ?
							if( !$cCup->IsEnteredCup($iCupId, $i ))
							{
								$obj = NULL;
								$obj->cup_id			= $iCupId;
								$obj->participant_id	= $i;
								$obj->created			= EGL_TIME;
			
								if( !$cCup->CreateCupParticipant( $obj ) )
								{
									DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couln't add participant in 'Cup::CreateCupParticipant'" );
								}
								else
								{
									/*
									$gl_oVars->cTpl->assign( 'msg_type',	'success' );
									$gl_oVars->cTpl->assign( 'msg_title',	'Teilnehmer hinzuzgefügt' );
									$gl_oVars->cTpl->assign( 'msg_text',	'Der Teilnehmer wurde erfolgreich hinzugefügt' );*/
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
				
				$gl_oVars->cTpl->assign( 'success',		true );
				$gl_oVars->cTpl->assign( 'msg_type',	'success' );
				$gl_oVars->cTpl->assign( 'msg_title',	'Teilnehmer hinzuzgefügt' );
				$gl_oVars->cTpl->assign( 'msg_text',	'Der Teilnehmer wurden erfolgreich hinzugefügt' );

				
			}//if $bParticipantList
		
			
		}//if $_GET['a']
		elseif ( $_GET['a'] == 'checkin' )
		{
			$cCup->CheckinParticipantById( $iCupPartId );

		}
		elseif( $_GET['a'] == 'checkout' )
		{
			$cCup->CheckoutParticipantById( $iCupPartId );
		}//if $_GET['a']
		
		
	}// if $oCup (cup found)?
	
	
	
	
	# get participants
	$aParticipants = $cCup->GetDetailedCupParticipants( (int)$_GET['cup_id'], $oCup->participant_type );

	
	
	$gl_oVars->cTpl->assign( 'game', $oGame );
	$gl_oVars->cTpl->assign( 'cup', $oCup );
	$gl_oVars->cTpl->assign( 'participants', $aParticipants );
	$gl_oVars->cTpl->assign( 'num_participants', sizeof($aParticipants) );
	
?>