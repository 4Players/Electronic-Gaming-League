<?php
	global $gl_oVars;
	
	// fetch url
	$iMemberId		= (int)$gl_oVars->iMemberId;
	
	
	// defnines classes
	$cLadderSystem		= new InetopiaLadder( $gl_oVars->cDBInterface );
	
	// fetch ladders
	$aLadders = $cLadderSystem->GetJoined1on1LadderByMemberId( $iMemberId );
	
	//-------------------------------------------
	// QUIT
	//-------------------------------------------
	if( $_GET['a'] == 'quit' ){
		
		$iLadderId = (int)$_POST['ladder_id'];
		
		for( $i=0; $i < sizeof($aLadders); $i++ ){
			if( $aLadders[$i]->id == $iLadderId ){
				
				// open challenges
				$aOpenChallenges = $cLadderSystem->GetChallengesByParticipant( 	PARTTYPE_MEMBER, 
																				$iMemberId, 
																				CHALLENGESTATE_CHALLENGING, 
																				$iLadderId 
																			);
				
				// open matches?
				$aNotClosedMatches = $cLadderSystem->GetNotClosedMatchesByParticipant( 	PARTTYPE_MEMBER, 
																						$iMemberId, 
																						$iLadderId 
																			);

				if( sizeof($aOpenChallenges) > 0 ||
					sizeof($aNotClosedMatches) > 0 )
				{
					// error, open challenges or matches available
					
					$gl_oVars->cTpl->assign( 'msg_type',	'error' );
					$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1300'] );
					
				}
				else
				{
					// no open challenges or matches available -> delete!!
					
					$cLadderSystem->DeleteParticipantByLadderId( $iMemberId, $iLadderId );
					
					$gl_oVars->cTpl->assign( 'msg_type',	'success' );
					$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1301'] );
					$gl_oVars->cTpl->assign( 'SUCCESS',		true );
				}
			}//if
		}//for
	}
	
	$gl_oVars->cTpl->assign( 'LADDERS', $aLadders );
?>