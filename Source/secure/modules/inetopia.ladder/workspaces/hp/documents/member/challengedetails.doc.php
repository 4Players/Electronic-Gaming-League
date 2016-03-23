<?php
	global $gl_oVars;
	
	# activate comments
	$_GET['comment']='write';
	
	
	# fetch header/get data from url
	$iChallengeId	= (int)$_GET['challenge_id'];
	
	# declare classes/objects
	$cLadderSystem		= new InetopiaLadder( $gl_oVars->cDBInterface );
	$cMatch				= new Match( $gl_oVars->cDBInterface, NULL );
	$cMatchStructures 	= new MatchStructures( $gl_oVars->cDBInterface );
	$cMapCollections 	= new MapCollections( $gl_oVars->cDBInterface );
	
	# fetch object data
	$oChallenge	= $cLadderSystem->GetChallengeDetails( PARTTYPE_MEMBER, $iChallengeId );
	$oLadder = $cLadderSystem->GetLadderbyID( (int)$oChallenge->ladder_id );
	$oMS = $oMatchStructure = 	$cMatchStructures->GetMatchStructure( (int)$oChallenge->matchstructure_id );
	
	
	# map-collection selected?
	$aMaps = array();
	if( $oMatchStructure->mapcollection_id > 0 )
		$aMaps = $cMapCollections->GetCollectionMaps(  (int)$oMatchStructure->mapcollection_id );
	
	# -----------------------------
	# EVENTS
	# -----------------------------
	if( $oChallenge && 
		$oChallenge->state == CHALLENGESTATE_CHALLENGING )
	if( $_GET['a'] == "accept" )
	{
		# MATCH-STRUCUTRE
		//$oMS = $cMatchStructures->GetMatchStructure( $oChallenge->matchstructure_id );
		
		# -----------------------------------------
		# read previous settings, from input stream
		# -----------------------------------------
		
		# challenge-time
		$challenge_time	= 0;
		list ($day, $month, $year) = explode('.', $_POST['challengetime_date']); list ($hour, $min) = explode(':', $_POST['challengetime_time']); 
		$challenge_time	= mktime( $hour, $min, 0, $month, $day, $year ); // set unix timestamp
		
		# 1/2/3/4 - Map
		$map1	= $_POST['map1'];
		$map2	= $_POST['map2'];
		//$map3	= $_POST['map3'];		# currently not included
		//$map4	= $_POST['map4'];		# currently not included
		
		
		// check changes
		if( $oChallenge->react_id == $gl_oVars->iMemberId )	 // my reacttion?
		if( $oChallenge->map1 != $map1 ||
			$oChallenge->map2 != $map2 ||
			$oChallenge->challenge_time != $challenge_time )
		{
					
			#UPDATE CHALLENGE
			$react_id = EGL_NO_ID;
			if( $oChallenge->challenger_id == $oChallenge->react_id ) $react_id = $oChallenge->opponent_id;
			if( $oChallenge->opponent_id == $oChallenge->react_id ) $react_id = $oChallenge->challenger_id;
			
			$uc_re = $cLadderSystem->UpdateChallenge( 	$iChallengeId,
														 array(	'challenge_time' 	=> $challenge_time,				# challenge-time
																'map1'				=> $map1,
																'map2'				=> $map2,
																'react_id'			=> $react_id,
																)
													);
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPage.'&challenge_id='.$iChallengeId );
		}
		else{
			# ------------------------------------------
			# NO CHANGES -> create match/encount
			# ------------------------------------------
		
			# structure not exists?
			if( !$oMS ) DEBUG( MSGTYPE_ERROR, __LINE__, __FILE__, "Couldn't create match ecnount - ladder {$oChallenge->ladder_name}:{$oChallenge->ladder_id} needs a valid match-structure-id" );
			else
			{
				$_MAPS_ 	= "";
				$_NUM_MAPS_ = 0;
	
				# evaulate DOUBLE-MAP-CHALLENGE 
				if( $oChallenge->challenge_type == CHALLENGETYPE_DOUBLE_MAP )
				{
					$_MAPS_		= $map1.','.$map2;
					$_NUM_MAPS_ = 2;
				}
				# evaulate DOUBLE-MAP-CHALLENGE 
				if( $oChallenge->challenge_type == CHALLENGETYPE_SINGLE_MAP )
				{
					$_MAPS_		= $map1;
					$_NUM_MAPS_ = 1;
				}
				# evaulate DOUBLE-MAP-CHALLENGE 
				if( $oChallenge->challenge_type == CHALLENGETYPE_RANDOM_MAP )
				{
					// currently not exists
					// mapcollection_id
					
					// find random-map
					if( sizeof($aMaps) > 0 )
					{
						srand ((double)microtime()*1000000);
						$rnd_map_index = rand(0,sizeof($aMaps)-1);
						
						$map1		= $aMaps[$rnd_map_index]->map_name;	// for challenge-object
	
						$_MAPS_		= $aMaps[$rnd_map_index]->map_name;	// for match-object
						$_NUM_MAPS_ = 1;
					
						/*	
						echo $_MAPS_;
						return 0;*/
					}
					else
					{
						DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't create match/ -encount - ladder {$oChallenge->ladder_name}:{$oChallenge->ladder_id} needs a more than 0 maps (in MapCollection), using random-map challenge-mode" );
						return 1;
					}
				}//if
	
				
				$iMatchId = -1;
				# create match, fetching created match-id
				$m_re = $cMatch->AddMatch(	array(	 	'module_id'				=> MODULEID_INETOPIA_LADDER,
														'module_entry_id' 		=> $oChallenge->ladder_id,
														'participant_type' 		=> PARTTYPE_MEMBER,
														'matchstructure_id' 	=> $oChallenge->matchstructure_id,
														'status' 				=> MATCH_RUNNING,
														'challenger_id' 		=> $oChallenge->challenger_id,
														'opponent_id' 			=> $oChallenge->opponent_id,
														'num_maps' 				=> $_NUM_MAPS_,
														'maps' 					=> $_MAPS_, 
														'num_rounds' 			=> $oMS->num_rounds,
														'round_names' 			=> $oMS->round_names,
														'fixed' 				=> (int)$oMS->fixed,
														'mapcollection_id' 		=> (int)$oMS->mapcollection_id,
														'created' 				=> EGL_TIME,
														'challenge_time' 		=> $challenge_time
													)
											);
				$iMatchId	= $gl_oVars->cDBInterface->InsertId();
											
				# create match-ecnount										
				$iEncountId	= $cLadderSystem->CreateEncount(	array(	'ladder_id'	=> $oChallenge->ladder_id,
																		'match_id'	=> $iMatchId,
																		'created'	=> EGL_TIME
																	)
															);
											
				// error occrued?
				if( !$iMatchId || !$m_re ) DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't create match/ -encount - ladder {$oChallenge->ladder_name}:{$oChallenge->ladder_id} needs a valid match-structure-id" );
				else
				{
					//$iMatchId	= (int)$gl_oVars->cDBInterface->InsertId();
					
					# MATCH CREATED --> UPDATE CHALLENGE
					$uc_re = $cLadderSystem->UpdateChallenge( 	$iChallengeId,
																 array( 'match_id'			=> $iMatchId,					# match-id
																 		'state'				=> CHALLENGESTATE_ACCEPTED,		# accept
																 		'time_phased'		=> EGL_TIME,					# terminiert, accepted, denied
																 		'challenge_time' 	=> $challenge_time,			# challenge-time
																 		'react_id'			=> EGL_NO_ID,
																		'map1'				=> $map1,
																 		'map2'				=> $map2,
																 	)
															 );
					# CHALLENGE-UPDATE SUCCESSFULL ?
					if( !$uc_re ) DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't update challenge ID:{$iChallengeId} " );
					else
					{
						$gl_oVars->cTpl->assign( 'success', true );
						
						$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
						$gl_oVars->cTpl->assign( 'msg_title',	$gl_oVars->aLngBuffer['basic']['c1207']  );
						$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c9106'] );
											
						PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPage.'&challenge_id='.$iChallengeId );
					}//if
															 
					
				}//if
				
			}//if valid ms-id?
			
		}//if no changes => create match
		
	}
	# -----------------------------
	# -----------------------------
	else
	{
	}
	

	# create comment manage object for members
	$cComments = new Comments( $gl_oVars->cDBInterface, $GLOBALS['g_egltb_ladder_challenge_comments'], "challenge_id" );
	
	#----------------------------------------------------
	# comment input detected ?
	#----------------------------------------------------
	if( Isset( $_POST['comment_text'] ) &&
		strlen($_POST['comment_text']) > 0 &&
		$gl_oVars->bLoggedIn )
	{
		
		# try to create obj
		if( $cComments->CreateComment( array(	'challenge_id'	=> $oChallenge->id,
												'author_id'		=> $gl_oVars->oMemberData->id,
												'text'			=> $_POST['comment_text'],
												'created'		=> EGL_TIME
									  		)
									  ) )//if
		{
			# successful
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPage.'&challenge_id='.$iChallengeId );
		}
		
	}#/if

	$aChallengeComments			= NULL;
	$iChallengeCommentCounter 	= -1;
	
	# get comment buffer
	/*if( $_GET['comment'] == 'write' ||
		$_GET['comment'] == 'show' )
	{*/
		# try to catch the comments of current displayed member
		$aChallengeComments = $cComments->GetComments( $oChallenge->id );
		$iChallengeCommentCounter = sizeof($aChallengeComments);
	//}
		
	# counter already read, else => read
	if( $iChallengeCommentCounter == -1 )
		$iChallengeCommentCounter = $cComments->GetCommentsCount( $oChallenge->id );
			
		
	# save data as a var into template
	$gl_oVars->cTpl->assign( 'comments',		$aChallengeComments ); 
	$gl_oVars->cTpl->assign( 'comment_count', 	$iChallengeCommentCounter );
	# ---------------------------------------------------------------------------------------- 
	
	# provide template with challenge data
	$gl_oVars->cTpl->assign( 'challenge',	$oChallenge );
	
	# setup challenge-lock
	if( $oChallenge->state != CHALLENGESTATE_CHALLENGING )
	{
		$gl_oVars->cTpl->assign( 'CHALLENGE_LOCKED', true );
	}
	else
		$gl_oVars->cTpl->assign( 'CHALLENGE_LOCKED', false );

		
		
	if( sizeof($aMaps) > 0 )$gl_oVars->cTpl->assign( 'MAPS', $aMaps );
		
?>