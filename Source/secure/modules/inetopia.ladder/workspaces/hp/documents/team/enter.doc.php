<?php
	global $gl_oVars;

	
	# fetch url params
	$iLadderId		= (int)$_GET['ladder_id'];
	$iTeamId		= (int)$_GET['team_id'];

	# declare classes
	$cLadderSystem	= new InetopiaLadder( $gl_oVars->cDBInterface );
	$cGamePool = new GamePool( $gl_oVars->cDBInterface );
	$cTeam = new Team( $gl_oVars->cDBInterface );
	

	# fetch pagedata
	$oLadder = $cLadderSystem->GetLadderbyID( $iLadderId );
	$oGame = $cGamePool->GetGameById( (int)$oLadder->game_id );
	$oTeam = $cTeam->GetTeam( $iTeamId );
	
	if( $oTeam && $oLadder )
	{
	
		# global var -> join-access
		$bJoinAccess 	= true;
		$aFailedRules 	= array();
		
		
		# check join access
		if( $cLadderSystem->IsEnteredLadder( $iLadderId, $oTeam->id ))
		{
			$aFailedRules[sizeof($aFailedRules)] = $gl_oVars->aLngBuffer['module']['c9203'];
			$bJoinAccess = false;
		}
		
		# check game-account?
		if( $oLadder->check_gameacc_id && sizeof($cGamePool->GetGamingIds( $oLadder->game_id, PARTTYPE_TEAM,  $oTeam->id )) < $oLadder->num_team_members  )
		{
			$aFailedRules[sizeof($aFailedRules)] = $gl_oVars->aLngBuffer['module']['c9209'];
			$bJoinAccess = false;
		}
		
		# join-time 
		if( (EGL_TIME-$oTeam->created) < ($oLadder->join_time*3600) /*hours*/ )
		{
			$aFailedRules[sizeof($aFailedRules)] = Templates::ParseContent( $gl_oVars->aLngBuffer['module']['c9205'], $gl_oVars->cTpl, array( 'time_left' => ComputeTimeIntervalFromSeconds( ($oLadder->join_time*3600)-(EGL_TIME-$gl_oVars->oMemberData->created) ) ) );
			$bJoinAccess = false;
		}
			
		# signin-lock 
		if( $oLadder->signin_locked )
		{
			$aFailedRules[sizeof($aFailedRules)] = $gl_oVars->aLngBuffer['module']['c9206'];
			$bJoinAccess = false;
		}
			
		# ladder-start
		if( $oLadder->start_time > 0 && $oLadder->start_time > EGL_TIME )
		{
			$aFailedRules[sizeof($aFailedRules)] = Templates::ParseContent( $gl_oVars->aLngBuffer['module']['c9207'], $gl_oVars->cTpl, array( 'time_left' => $oLadder->start_time) );
			$bJoinAccess = false;
		}
			
		# max-participants archived?
		if( $oLadder->max_participants > 0 &&
			$oLadder->max_participants <= $cLadderSystem->GetNumLadderParticipants($iLadderId) )
		{
			$aFailedRules[sizeof($aFailedRules)] = $gl_oVars->aLngBuffer['module']['c9208'];
			$bJoinAccess = false;
		}

	
		if( $bJoinAccess )
		{
			#------------------------------------
			# Try Join
			#------------------------------------
			if( $_GET['a'] == 'join' )
			{
				$obj = NULL;
				$obj->ladder_id			= $iLadderId;
				$obj->participant_id	= $oTeam->id;
				$obj->created			= EGL_TIME;
				$obj->points			= $oLadder->first_points_score;
				$obj->last_points		= $oLadder->first_points_score;
	
				# add participant
				if( !$cLadderSystem->CreateLadderParticipant( $obj ) )
				{
					DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couln't add participant in 'InetopiaLadder::CreateLadderParticipant'" );
				}
				else
				{
					$gl_oVars->cTpl->assign( 'success', 	true );
					$gl_oVars->cTpl->assign( 'msg_type',	'success' );
					//$gl_oVars->cTpl->assign( 'msg_title',	'Beigetreten' );
					$gl_oVars->cTpl->assign( 'msg_text',	'Herzlichen Glückwünsch, du hast sich gerade in die Ladder eingeschrieben' );
				}//if
			}
			else 
			{
			}
		}else
		{
			$gl_oVars->cTpl->assign( 'failed_rules', $aFailedRules );
		}
		
		
		$gl_oVars->cTpl->assign( 'join_access', $bJoinAccess );
		$gl_oVars->cTpl->assign( 'ladder', $oLadder );
		$gl_oVars->cTpl->assign( 'team', $oTeam );
	}
	
?>