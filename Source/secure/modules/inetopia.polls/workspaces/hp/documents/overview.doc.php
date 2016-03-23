<?php
	global $gl_oVars;
	
	$iGameId = (int)$_GET['game_id'];
	$iPollId = (int)$_GET['poll_id'];
	$ip_adress 	= $_SERVER['REMOTE_ADDR'];
	

	$cGamePool = new GamePool( $gl_oVars->cDBInterface );
	$cPolls = new Polls( $gl_oVars->cDBInterface );
	
	# fetch poll data
	//$aPolls = $cPolls->GetPolls();
	$aGames = $cGamePool->GetGames();
	
	
	
	
	# ----------------------------------------
	# fetch game polls
	# ----------------------------------------
	if( $iGameId )
	{
		$oGame = $cGamePool->GetGameById( $iGameId );
		$aPolls = $cPolls->GetCategoryPolls( $oGame->cat_id, 100 );
		
		
		$gl_oVars->cTpl->assign( 'game', $oGame );
		
	}
	# ----------------------------------------
	# fetch special polls
	# ----------------------------------------
	else
	{
		$iPollCatRoot = (int)module_sendmessage( $gl_oVars->sModuleId, 'get_settings', $__DATA__, 'cat_root_id' );
		$aPolls = $cPolls->GetCategoryPolls( $iPollCatRoot, 100 );

	}//if( $iGameId )
	
	/*
		-----------------------------------------------
		Falls anz. Polls > 0, selektiere aktuelle Poll + Antworten
		Der Rest wird in $aPolls gespeichert und aufgeliset
	*/
	if( sizeof($aPolls))
	{
		$oCurrPoll = NULL;
		$aCurrPollAnswers = array();

		// ---------------------------------
		// pollid not selected => select last
		// ---------------------------------
		if( !$iPollId )
		{
			$oCurrPoll = $aPolls[0];
			array_shift( $aPolls);
			
		}//if
		// ---------------------------------
		// select current poll id
		// ---------------------------------
		else 
		{
			for( $i=0; $i < sizeof($aPolls); $i++ )
			{
				if( $aPolls[$i]->id == $iPollId )
				{
					$oCurrPoll = $aPolls[$i];
					DeleteItemOfArray( $aPolls, $i );
					break;
				}//if
			}
		}//if
		
		$bAlreadyVoted = false;
		if( $oCurrPoll->lock_ip )$bAlreadyVoted = $cPolls->AlreadyVoted_IP( $oCurrPoll->id, $ip_adress );
		if( $oCurrPoll->lock_memberid ) $bAlreadyVoted = $cPolls->AlreadyVoted_MEMBERID( $oCurrPoll->id, $gl_oVars->iMemberId );
		

		$gl_oVars->cTpl->assign( "already_voted", $bAlreadyVoted );
		$aCurrPollAnswers = $cPolls->GetPollAnswers( (int)$oCurrPoll->id );
	
		$gl_oVars->cTpl->assign( 'curr_poll', $oCurrPoll );
		$gl_oVars->cTpl->assign( 'curr_poll_answers', $aCurrPollAnswers );
		
	}//if
	
	$gl_oVars->cTpl->assign( 'polls', $aPolls );
	$gl_oVars->cTpl->assign( 'games', $aGames );
?>