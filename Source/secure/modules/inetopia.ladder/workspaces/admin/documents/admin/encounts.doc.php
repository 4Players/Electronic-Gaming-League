<?php

	global $gl_oVars;

	# fetch url data
	$iLadderId	= (int)$_GET['ladder_id'];
	
	# classes & objects
	$cLadderSystem	= new InetopiaLadder( $gl_oVars->cDBInterface );
	$cGamePool = new GamePool( $gl_oVars->cDBInterface );
	$cMatch = new Match( $gl_oVars->cDBInterface );
	
	
	# fetch ladderdata
	$oLadder = $cLadderSystem->GetLadderbyID( $iLadderId );
	$oGame = $cGamePool->GetGameById( $oLadder->game_id );
	//-------------------------------------------------
	// delete encount	
	//-------------------------------------------------	
	if( $_GET['a'] == 'del' )
	{
		# fetch advanced url data
		$iEncountId = (int)$_GET['encount_id'];
		
		if( $iEncountId )
		{
			# fetch encount object
			$oEncount = $cLadderSystem->GetEncountById( $iEncountId );
			
			# delete
			$cLadderSystem->DeleteEncount( $iEncountId );
			$cMatch->DeleteMatch ( (int)$oEncount->match_id );
		}
	}//if
	
	
	$encounts_per_page	 	= 50;
	$limit_start			= (int)$_GET['pos'];
	$num_encounts			= $cLadderSystem->GetNumLadderEncounts($iLadderId);
	
	
	# compute pagelists
	$num_pages	= $num_encounts/$encounts_per_page;
	if( !is_int($num_pages) ) $num_pages = ((int)$num_pages)+1;	
	if( $limit_start == 0 ) $curr_page=0;
	else $curr_page = (int)($limit_start/$encounts_per_page);

	
	# fetch last encounts
	$aEncounts = $cLadderSystem->GetMatchesByLadder( $oLadder->participant_type, $oLadder->id, $limit_start, $encounts_per_page );


	# provide template with data

	$gl_oVars->cTpl->assign( 'num_ladder_encounts', $num_encounts );
	$gl_oVars->cTpl->assign( 'encounts_per_page', 	$encounts_per_page );
	$gl_oVars->cTpl->assign( 'num_pages', 			$num_pages );
	$gl_oVars->cTpl->assign( 'curr_page', 			$curr_page );
	$gl_oVars->cTpl->assign( 'ladder', 				$oLadder );
	$gl_oVars->cTpl->assign( 'game',				$oGame );
	$gl_oVars->cTpl->assign( 'encounts',			$aEncounts );
?>