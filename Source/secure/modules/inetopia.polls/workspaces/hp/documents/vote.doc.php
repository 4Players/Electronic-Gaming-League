<?php
	global $gl_oVars;
	

	$poll_id 	= (int)$_GET['poll_id'];
	$answer_id 	= (int)$_POST['poll_vote_'.$poll_id];
	$ip_adress 	= $_SERVER['REMOTE_ADDR'];
	$game_id	= (int)$_GET['game_id'];
	$bExpiredPoll = false;


	# fetch poll data
	$cPolls = new Polls( $gl_oVars->cDBInterface );
	$oPoll = $cPolls->GetPoll( $poll_id );

	
	if( $oPoll )
	{
		// expired poll??
		if( EGL_TIME - $oPoll->end_time >= 0 ||
			EGL_TIME - $oPoll->start_time <= 0 )
		{
			$bExpiredPoll = true;
			$gl_oVars->cTpl->assign( 'poll_expired', true );
		}
		
		# --------------------------------------------------
		# Expired Poll ?
		# --------------------------------------------------
		if( !$bExpiredPoll )	# poll expired ?
		{
			# ----------------------------
			if( $_GET['a'] == 'voting' && $poll_id )
			{
				################################################
				# START VOTING -> IP-LOCK ??
				################################################
				
				if( $oPoll->lock_ip )
				{
					
					if( $cPolls->AlreadyVoted_IP( $poll_id, $ip_adress ))
					{
						$gl_oVars->cTpl->assign( 'voting_already_voted', true);
					}
					else
					{
						# Vote selected ?
						if( $answer_id )
						{
							$cPolls->SaveVote( $poll_id, $answer_id, $ip_adress, $gl_oVars->iMemberId );				
							$cPolls->HitPoll_answer( $answer_id );
							$gl_oVars->cTpl->assign( 'vote_success', true);
						}
					}//if
				}//if
				
				################################################
				# START VOTING -> MEMBER-ID LOCK ??
				################################################
				else if( $oPoll->lock_memberid )
				{
					if( $gl_oVars->bLoggedIn )
					{
						if( $cPolls->AlreadyVoted_MEMBERID( $poll_id, $gl_oVars->iMemberId ))
						{
							$gl_oVars->cTpl->assign( 'voting_already_voted', true);
						}
						else
						{
							# Vote selected ?
							if( $answer_id )
							{
								$cPolls->SaveVote( $poll_id, $answer_id, $ip_adress, $gl_oVars->iMemberId );				
								$cPolls->HitPoll_answer( $answer_id );
								$gl_oVars->cTpl->assign( 'vote_success', true);
							}
						}//if
					}
					else 
					{
						/*************
						***	 NOT LOGGED IN ??
						**************/
	
						$gl_oVars->cTpl->assign( 'not_loggedin' );
					}
				}
				else
				{
					$cPolls->HitPoll_answer( $answer_id );
					$gl_oVars->cTpl->assign( 'vote_success', true);
				}//if,else
			}
			else 
			{
				// view poll -> currently voted ?
				
				################################################
				# CHECK IP-ADDRESS VOTED?
				################################################
				if( $oPoll->lock_ip )
				{
					if( $cPolls->AlreadyVoted_IP( $poll_id, $ip_adress ))
					{
						$gl_oVars->cTpl->assign( 'already_voted', true);
					}//if
				}
				################################################
				# CHECK MEMBER-ID VOTED?
				################################################
				elseif( $oPoll->lock_memberid )
				{
					if( $cPolls->AlreadyVoted_MEMBERID( $poll_id, $gl_oVars->iMemberId ))
					{
						$gl_oVars->cTpl->assign( 'already_voted', true);
					}//if
				}
				else
				{
				}
				
			}//else
		}// !$bExpiredPoll
	}//if $oPoll

	/*
	# fetch answers
	$aPollAnswers = $cPolls->GetPollAnswers( $oPoll->id );
	
	
	# compute results
	#------------------------------
	$all_votes	= 0;
	for( $i=0; $i < sizeof($aPollAnswers); $i++ )
	{
		$all_votes += $aPollAnswers[$i]->hits;
	}//for*/
	
	/*
	$gl_oVars->cTpl->assign( 'all_votes', $all_votes );	
	$gl_oVars->cTpl->assign( 'poll', $oPoll );	
	$gl_oVars->cTpl->assign( 'poll_answers', $aPollAnswers );*/
	
	
	$url = $gl_oVars->sURLFile.'?page='.$gl_oVars->sModuleId.":overview&poll_id={$poll_id}";
	if( $game_id ) $url .= "&game_id={$game_id}";
	header( "location: $url " );
?>