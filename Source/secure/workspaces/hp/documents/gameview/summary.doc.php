<?php
	global $gl_oVars;
	
	// fetch header-informatioons (URL,GET)
	$iGameId		= (int)$_GET['game_id'];
	
	
	#--------------------------------------
	# Game-ID
	#
	#
	# current game-selection
	#--------------------------------------
	if( $iGameId )
	{
		// save new selected game (header)
		//$iGameId = (int)$_GET['game_id'];
		//$_SESSION['member']['game_id'] = $iGameId;
		setcookie( "member[game_id]", $iGameId, EGL_COOKIETIME /*1year*/ );
	}else{
		// no game-id selected?
		$iCookieGameId	= (int)$_COOKIE['member']['game_id'];
		if( $iCookieGameId <= 0 )
		{
			header( "Location: ".$gl_oVars->sURLFile."?page=gameview.gamelist" );
		}//if
		
		$iGameId = $iCookieGameId;
	}
	
	
	
	$cGamePool 	= new GamePool( $gl_oVars->cDBInterface );
	$oGameInfo	= $cGamePool->GetGameById( $iGameId );
	
	# fetch current game_news according to game - cat - ids
	$aGameNews = module_sendmessage( MODULEID_INETOPIA_NEWS, 'get_category_news', $__DATA__, $oGameInfo->cat_id );
	$oGamePoll	= module_sendmessage( MODULEID_INETOPIA_POLLS, 'get_current_poll', $__DATA__, $oGameInfo->cat_id );
	$aGamePollAnswers = module_sendmessage( MODULEID_INETOPIA_POLLS, 'get_poll_answers', $__DATA__, $oGamePoll->id );
	
	
	if( $iGameId )
	{
		# ----------------------------------------
		# Cups
		# ----------------------------------------
		$aGameCups = module_sendmessage( '61A47C28-FE74-488d-B8E4-A11FEDBB935A', 'get_detailed_cups', $__DATA__, (int)$iGameId );
		if( $aGameCups )
		{
			$gl_oVars->cTpl->assign( 'game_cuplist', $aGameCups );
		}
		
		
		# ----------------------------------------
		# Ladder
		# ----------------------------------------
		$aGameCups = module_sendmessage( 'A9CCDCBF-C696-422c-A0D8-91223A9C22E6', 'get_detailed_ladders', $__DATA__, (int)$iGameId );
		if( $aGameCups )
		{
			$gl_oVars->cTpl->assign( 'game_ladderlist', $aGameCups );
		}
		
		
		
		# ----------------------------------------
		# Poll 
		# ----------------------------------------
		$oCurrentPoll = module_sendmessage( MODULEID_INETOPIA_POLLS, 'get_current_poll', $__DATA__, $oGameInfo->cat_id );
		if( $oCurrentPoll )
		{
			$aPollAnswers = module_sendmessage( MODULEID_INETOPIA_POLLS, 'get_poll_answers', $__DATA__, $oCurrentPoll->id );
			
			$bAlreadyVoted = false;
			// member logged in?
			if( $gl_oVars->bLoggedIn )
				$bAlreadyVoted = module_sendmessage( MODULEID_INETOPIA_POLLS, 'already_voted', $oCurrentPoll, $ip_adress, $gl_oVars->iMemberId );
			else 
				$bAlreadyVoted = module_sendmessage( MODULEID_INETOPIA_POLLS, 'already_voted', $oCurrentPoll, $ip_adress, -1 );
			
			$gl_oVars->cTpl->assign( 'currpoll_already_voted', $bAlreadyVoted );
			$gl_oVars->cTpl->assign( 'currpoll', $oGamePoll );
			$gl_oVars->cTpl->assign( 'currpoll_answers', $aGamePollAnswers );
		}
		
	}
	else 
	{
	}

	$gl_oVars->cTpl->assign( 'gameinfo', $oGameInfo );
	$gl_oVars->cTpl->assign( 'gamenews', $aGameNews );
	$gl_oVars->cTpl->assign( 'gamepoll', $aGameNews );
	
	//$gl_oVars->cTpl->assign ( 'GLOBAL_COLOR', 'blue' );

?>