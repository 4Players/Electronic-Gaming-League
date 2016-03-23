<?php
	global $gl_oVars;

	# create cup object
	$cCup 				= new Cup( $gl_oVars->cDBInterface, NULL /*cup_id NOT USED*/ );
	$cGame 				= new GamePool( $gl_oVars->cDBInterface );
	
	$iParticipantId 	= -1;
	$iCupId				= -1;
	$iParttype			= -1;
	
	# member 
	$iCupId				= (int)$_GET['cup_id'];
	$iParticipantId 	= (int)$gl_oVars->oMemberData->id;
	$iParttype 			= PARTTYPE_MEMBER;	# set as member_id


	# --------------------------------------------
	# Enter
	# --------------------------------------------
	if( $_GET['a'] == 'enter' )
	{
		$oCup = $cCup->GetCup( $iCupId );
		$iNumEnteredParticipants = $cCup->GetNumCupParticipants( (int)$oCup->id );
		/*
			participant_type wird hier nicht gebraucht, da der Cup bereits bestimmt wurde
		
		*/
		if( $oCup && EGL_TIME < $oCup->start_time-$oCup->checkin_time*60 && $oCup->is_public )
		{
			$aGameAccounts = array(); # contains the whole gameidlist (for single&mulit[team] mode)
			$aMembersAlreadyJoined = array();
			
			$bgameacc_ok = false;
			$bmember_already_not_joined = false;
			
			# ----------------------
			# MEMBER 
			# ----------------------
			if( $oCup->participant_type == PARTTYPE_MEMBER ) 
			{
				# check gamingaccount
				if( $oCup->check_gameacc_id )
				{
					# check gamingaccount
					$aGameAccounts = $cGame->GetGamingIds( $oCup->game_id, $iParttype, $iParticipantId);
					
					
					if( sizeof($aGameAccounts) == 1 ) $bgameacc_ok = true;
					else
					{
						#no game account created
						$aErrors[sizeof($aErrors)] = $gl_oVars->aLngBuffer['module']['c1400'];
					}
				}
				else $bgameacc_ok = true;
			}//if
			
			if( $iNumEnteredParticipants < $oCup->max_participants ){}
			else
			{
				/*
				max. participants entered
				*/
				$aErrors[sizeof($aErrors)] = $gl_oVars->aLngBuffer['module']['c1401'];
			}	

			/*
				1. (all)  all game_accounds available ??
				2. (team) all members currently not joined by other teams ? ( NUR BEI TEAMS !!! )
			*/
			
		
			if( sizeof($aErrors) == 0 )
			{
				# .....
				if( $cCup->IsEnteredCup( $iCupId, $iParticipantId) )
				{
					$gl_oVars->cTpl->assign( 'msg_type',	'info' );
					$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1402'] );
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
						$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1404'] );
					}//if
				}//if
			}
			else 
			{
				$gl_oVars->cTpl->assign( 'msg_type',	'error' );
				$gl_oVars->cTpl->assign( 'msg_errors',	$aErrors );
				$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1403'] );
			}//if if( $bgameacc_ok && $bmember_already_not_joined )
				
				
		}
		else
		{
			$gl_oVars->cTpl->assign( 'msg_type',	'error' );
			$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1405'] );
		}//if if( $oCup && EGL_TIME < $oCup->start_time-$oCup->checkin_time*60)
		
	} // if
	//-----------------------------------------------
	// QUIT
	//-----------------------------------------------
	else if( $_GET['a'] == 'quit' )
	{
		$oCup = $cCup->GetCup( $iCupId );

		if( $oCup && 
			EGL_TIME < $oCup->start_time-$oCup->checkin_time*60 )
		{
			# test
			if( !$cCup->IsEnteredCup( $iCupId, $iParticipantId /*member_id*/) )
			{
				$gl_oVars->cTpl->assign( 'msg_type',	'info' );
				$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1406'] );
			}
			else
			{
				if( $cCup->DeleteParticipantByCup( $iCupId, $iParticipantId/*member_id*/ ) )
				{
					$gl_oVars->cTpl->assign( 'msg_type',	'success' );
					$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1407'] );
				}//if
				//echo mysql_error();
			}//if
		}
		else
		{
			$gl_oVars->cTpl->assign( 'msg_type',	'error' );
			$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1408'] );
		}//if
	}
	//-----------------------------------------------
	// CHECK-IN
	//-----------------------------------------------
	else if( $_GET['a'] == 'check_in' )
	{
		$oCup = $cCup->GetCup( $iCupId );

		if( $oCup && 
			EGL_TIME >= $oCup->start_time-$oCup->checkin_time*60 &&		# cup checkin-time erreich ?
			EGL_TIME < $oCup->start_time &&								# cup start überstrichen ?
			$cCup->IsEnteredCup( $iCupId, /*member_id*/$iParticipantId) )
		{			
			$cCup->CheckinParticipant( $oCup->id, $iParticipantId/*member_id*/ );
			$gl_oVars->cTpl->assign( 'msg_type',	'success' );
			$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1410'] );
			
		}
		else
		{
			$gl_oVars->cTpl->assign( 'msg_type',	'error' );
			$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1409'] );
		}
		
	}
	//-----------------------------------------------
	// CHECK-OUT
	//-----------------------------------------------
	else if( $_GET['a'] == 'check_out' )
	{
		$oCup = $cCup->GetCup( $iCupId );

		if( $oCup && 
			EGL_TIME >= $oCup->start_time-$oCup->checkin_time*60 &&		# cup checkin-time erreich ?
			EGL_TIME < $oCup->start_time &&								# cup start überstrichen ?
			$cCup->IsEnteredCup( $iCupId, $iParticipantId) )
		{
			$cCup->CheckoutParticipant( $oCup->id, $iParticipantId ); /*member_id*/
			$gl_oVars->cTpl->assign( 'msg_type',	'success' );
			$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1412'] );
			
			
		}
		else
		{
			$gl_oVars->cTpl->assign( 'msg_type',	'error' );
			$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1411'] );
		}		
	}
	
	# --------------------------------------------
	# List upcoming cups
	# --------------------------------------------
	else
	{
		/*	DESCRIPTION:
			-------------
			Cups
			 - Entered/Checked */
			 
		# gets all upcoming Cups
		$aCups = $cCup->GetUpComingCups_ByParticipant( EGL_TIME, $iParttype, $iParticipantId );
		
		$gl_oVars->cTpl->assign( 'cups',		$aCups );
		$gl_oVars->cTpl->assign( 'cup_games',	$aGames );
		
	}//if
	return 1;
?>