<?php
	global $gl_oVars;
	
	// fetch url
	$iChallengeId	= (int)$_GET['challenge_id'];

	// defnines classes
	$cLadderSystem		= new InetopiaLadder( $gl_oVars->cDBInterface );
	

	// fetch data	
	$oChallenge	= $cLadderSystem->GetChallengeDetails( PARTTYPE_MEMBER, $iChallengeId );
	
	if( $oChallenge )
	{
		# ------------------------------------------------
		# ON DENY
		# ------------------------------------------------
		if( $_GET['a'] == 'deny' && strlen($_POST['reason']) > 0 )
		{
			$obj_challenge = array( 'state'		=> CHALLENGESTATE_DENIED,
									'react_id'	=> EGL_NO_ID,
								   );
			$cLadderSystem->SetChallengeData( $iChallengeId, $obj_challenge );
			
			
			$command_msg = 	"\n----------------------------------\n".
							$gl_oVars->aLngBuffer['module']['c1202'].
							"\n----------------------------------\n".
							$_POST['reason'];
				
			# create comment manage object for members
			$cComments = new Comments( $gl_oVars->cDBInterface, $GLOBALS['g_egltb_ladder_challenge_comments'], "challenge_id" );
			$cComments->CreateComment( array(	'challenge_id'	=> $oChallenge->id,
												'author_id'		=> $gl_oVars->oMemberData->id,
												'text'			=> $command_msg,
												'created'		=> EGL_TIME,
										  	)
										  );
			# successful
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sModuleId.':member.challengedetails&challenge_id='.$iChallengeId );
			
		}//if deny
		
		$gl_oVars->cTpl->assign( 'CHALLENGE', $oChallenge );
	}
	
?>