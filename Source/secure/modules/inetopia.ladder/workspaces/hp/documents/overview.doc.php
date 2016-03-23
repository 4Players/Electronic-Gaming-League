<?php
	global $gl_oVars;
	
	
	$iLadderId	= (int)$_GET['ladder_id'];
	$iPageIndex	= (int)$_GET['p'];
	

	# declare objects/classes
	$cLadderSystem	= new InetopiaLadder( $gl_oVars->cDBInterface );
	$cFastChallenge	= new FastChallenge( $gl_oVars->cDBInterface );
	$cDBConfigs		= new DBConfigs( $gl_oVars->cDBInterface );
	
	# fetch data
	$oLadder = $cLadderSystem->GetLadderbyID( $iLadderId );
	if( $oLadder ){
			
		
		$aTop2	= $cLadderSystem->GetLadderParticipants( $oLadder->participant_type, $iLadderId, 0, 2 );
	
		$aLastMatches = $cLadderSystem->GetLastLadderEncounts( $oLadder->participant_type, $iLadderId, 10 );
		/*
			all matchs coming up next or last 24 hours
		*/
		$aNextMatches = $cLadderSystem->GetNextLadderEncounts( $oLadder->participant_type, $iLadderId, EGL_TIME-(3600*24) );
		
		
		# fetch current game_news according to game - cat - ids
		$aLadderNews = module_sendmessage( MODULEID_INETOPIA_NEWS, 'get_category_news', $__DATA__, $oLadder->cat_id );
		
		
		
		$participants_per_page 	= 15;
		$limit_start			= (int)$_GET['pos'];
		$num_participants		= $cLadderSystem->GetNumLadderParticipants($iLadderId);
		
		
		$num_pages	= $num_participants/$participants_per_page;
		if( !is_int($num_pages) ) $num_pages = ((int)$num_pages)+1;	
		if( $limit_start == 0 ) $curr_page=0;
		else $curr_page = (int)($limit_start/$participants_per_page);
	
		
		# get ladder participants	
		$aLadderParticipants = $cLadderSystem->GetLadderParticipants( $oLadder->participant_type, $iLadderId, $limit_start, $participants_per_page );
		$aAdministrator	= $cLadderSystem->GetLadderAdministrator( $iLadderId );
		
		
		#----------------------------------
		# FAST CHALLENGE
		#
		#----------------------------------
		
		$fc_time_to_next_update = 1800; // dbconfigs..load
		$fc_updatetime_diff 	= $fc_time_to_next_update-(EGL_TIME - $oLadder->fastchallenge_update);
		$fc_num_participants 	= $cFastChallenge->GetNumParticipantsFromPool( $oLadder->id );
		
		$aTimeDiff = ComputeTimeIntervalFromSeconds( $fc_updatetime_diff );
		$t =	Templates::ParseContent( 	$gl_oVars->aLngBuffer['basic']['c4280'], // c1217
											$gl_oVars->cTpl,
											array( 	'days' 		=> $aTimeDiff['days'],
													'hours' 	=> $aTimeDiff['hours'],
													'minutes' 	=> $aTimeDiff['mins'],
													'seconds' 	=> $aTimeDiff['seconds'],
												)//array
										);
										
		$gl_oVars->cTpl->assign( 'fc_updatetime_diff_str', $t );
		$gl_oVars->cTpl->assign( 'fc_updatetime_diff', $fc_updatetime_diff );
		$gl_oVars->cTpl->assign( 'fc_num_participants', $fc_num_participants );
		
		
		
		
		
		
		$gl_oVars->cTpl->assign( 'participants_per_page', $participants_per_page );
		$gl_oVars->cTpl->assign( 'num_pages', $num_pages );
		$gl_oVars->cTpl->assign( 'curr_page', $curr_page );
	
		# provide template with data5
		$gl_oVars->cTpl->assign( "ladder_news", $aLadderNews ); 
		
		$gl_oVars->cTpl->assign( 'ladder_participants', $aLadderParticipants );
		$gl_oVars->cTpl->assign( 'top2', $aTop2 );
		$gl_oVars->cTpl->assign( 'ladder', $oLadder );
		
		$gl_oVars->cTpl->assign( 'last_matches', $aLastMatches );
		$gl_oVars->cTpl->assign( 'next_matches', $aNextMatches );
		
		$gl_oVars->cTpl->assign( 'num_participants', $num_participants );
		$gl_oVars->cTpl->assign( 'adminlist', $aAdministrator );
		
	}//if
		
	
?>