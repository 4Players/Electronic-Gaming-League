<?php
	global $gl_oVars;
	

	# create cup object
	$cCup 				= new Cup( $gl_oVars->cDBInterface, NULL /*cup_id NOT USED*/ );
	$cTeam 				= new Team( $gl_oVars->cDBInterface );
	$cGame 				= new GamePool( $gl_oVars->cDBInterface );
	
	
	$iParticipantId 	= -1;
	$iCupId				= -1;
	$iParttype			= -1;
	
	# team exists ?
	$iCupId				= (int)$_GET['cup_id'];
	$iParticipantId 	= (int)$_GET['team_id'];
	$iParttype 			= PARTTYPE_TEAM;		# set as team_id

	# team exists ?
	$oTeam = $cTeam->GetTeam( $iParticipantId );
	

	# --------------------------------------------
	# Enter
	# --------------------------------------------
	if( $_GET['a'] == 'enter' )
	{
		$oCup = $cCup->GetCup( $iCupId );
		$iNumEnteredParticipants = $cCup->GetNumCupParticipants( (int)$oCup->id );
	
		/*
			participant_type wird hier nicht gebraucht, da die Cup bereits bestimmt wurde
		
		*/
		if( $oCup && $oTeam && EGL_TIME < $oCup->start_time-$oCup->checkin_time*60 && $oCup->is_public )
		{
			$aGameAccounts = array(); # contains the whole gameidlist (for single&mulit[team] mode)
			$aMembersAlreadyJoined = array();
			
			$bgameacc_ok = false;
			$bmember_already_not_joined = false;
			

			# ----------------------
			# TEAM 
			# ----------------------
			if( $oCup->participant_type == PARTTYPE_TEAM ) 
			{
				if( $oCup->check_gameacc_id )
				{
					$aGameAccounts= $cGame->GetGamingIds( $oCup->game_id, $iParttype, $iParticipantId);
					if( sizeof($aGameAccounts) >= $oCup->num_team_members )
					{
						$bgameacc_ok=true;
					}
					else
					{
						#no game account created
	
						
						$aErrors[sizeof($aErrors)] = $gl_oVars->aLngBuffer['module']['c1450'];
					}//if
				}
				/* SET GAMEACC_CHECK => OK */
				else $bgameacc_ok = true;
				
				$aMembersAlreadyJoined = $cCup->CheckTeamMemberJoins( $oCup->id, $iParticipantId );
				if( sizeof($aMembersAlreadyJoined) == 0 ) 
				{
					$bmember_already_not_joined=true;
				}//if
				else
				{
					#	members currently join by other teams 
					$aErrors[sizeof($aErrors)] = $gl_oVars->aLngBuffer['module']['c1451'];
				}//if
			
				if( $iNumEnteredParticipants < $oCup->max_participants ){}
				else
				{
					/*
					max. participants entered
					*/
					$aErrors[sizeof($aErrors)] = $gl_oVars->aLngBuffer['module']['c1452'];
				}					
			}//if
		
		

			
			if( sizeof($aErrors) == 0 )
			{
				# .....
				if( $cCup->IsEnteredCup( $iCupId, $iParticipantId) )
				{
					$gl_oVars->cTpl->assign( 'msg_type',	'info' );
					$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1453'] );
				}
				else
				{
					$obj = NULL;
					$obj->cup_id 			= $iCupId;
					$obj->participant_id 	= $iParticipantId;
					$obj->created 			= EGL_TIME;
					
					if( $cCup->CreateCupParticipant( $obj ) )
					{
						$gl_oVars->cTpl->assign( 'msg_type',	'success' );
						$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1454'] );
					}//if
				}//if
			}
			else 
			{
				$gl_oVars->cTpl->assign( 'msg_type',	'error' );
				$gl_oVars->cTpl->assign( 'msg_errors',	$aErrors );
				$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1455'] );
			}//if if( $bgameacc_ok && $bmember_already_not_joined )
				
				
		}
		else
		{
			$gl_oVars->cTpl->assign( 'msg_type',	'error' );
			$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1456'] );
		}//if if( $oCup && EGL_TIME < $oCup->start_time-$oCup->checkin_time*60)
		
	} // if
	else if( $_GET['a'] == 'quit' )
	{
		$oCup = $cCup->GetCup( $iCupId );

		if( $oCup && 
			EGL_TIME < $oCup->start_time-$oCup->checkin_time*60 )
		{
			# test
			if( !$cCup->IsEnteredCup( $iCupId, $iParticipantId) )
			{
				$gl_oVars->cTpl->assign( 'msg_type',	'info' );
				$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1457'] );
			}
			else
			{
				if( $cCup->DeleteParticipant( $iCupId, $iParticipantId ) )
				{
					$gl_oVars->cTpl->assign( 'msg_type',	'success' );
					$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1458'] );
				}//if
				#echo mysql_error();
			}//if
		}
		else
		{
			$gl_oVars->cTpl->assign( 'msg_type',	'error' );
			$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1459'] );
		}//if
	}
	else if( $_GET['a'] == 'check_in' )
	{
		$oCup = $cCup->GetCup( $iCupId );

		if( $oCup && 
			EGL_TIME >= $oCup->start_time-$oCup->checkin_time*60 &&		# cup checkin-time erreich ?
			EGL_TIME < $oCup->start_time &&								# cup start überstrichen ?
			$cCup->IsEnteredCup( $iCupId, $iParticipantId) )
		{			
			$cCup->CheckinParticipant( $oCup->id, $iParticipantId );
			
			
			$gl_oVars->cTpl->assign( 'msg_type',	'success' );
			$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1460'] );
		}
		else
		{
			$gl_oVars->cTpl->assign( 'msg_type',	'error' );
			$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1461'] );
		}
		
	}
	else if( $_GET['a'] == 'check_out' )
	{
		$oCup = $cCup->GetCup( $iCupId );

		if( $oCup && 
			EGL_TIME >= $oCup->start_time-$oCup->checkin_time*60 &&		# cup checkin-time erreich ?
			EGL_TIME < $oCup->start_time &&								# cup start überstrichen ?
			$cCup->IsEnteredCup( $iCupId, $iParticipantId) )
		{
			
			$cCup->CheckoutParticipant( $oCup->id, $iParticipantId );

			// check out			
			$gl_oVars->cTpl->assign( 'msg_type',	'success' );
			$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1462'] );

		}
		else
		{
			//error
			$gl_oVars->cTpl->assign( 'msg_type',	'error' );
			$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1463'] );
		}		
	}
	
	# --------------------------------------------
	# List upcoming cups
	# --------------------------------------------
	else
	{
		
	
		/*
		
			DESCRIPTION:
			-------------
			
			Cups
			 - Entered/Checked

		
		*/

		# gets all upcoming Cups
		$aCups = $cCup->GetUpComingCups_ByParticipant( EGL_TIME, $iParttype, $iParticipantId );
		
					
		$gl_oVars->cTpl->assign( 'participant_id',		$iParticipantId );
		$gl_oVars->cTpl->assign( 'cups',		$aCups );
		$gl_oVars->cTpl->assign( 'cup_games',	$aGames );
		
		
	}	


	return 1;
?>