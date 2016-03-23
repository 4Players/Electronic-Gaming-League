<?php
	global $gl_oVars;

	# fetch url parameters
	$iCupId	= (int)$_GET['cup_id'];

	
	# cups
	$cGamePool = new GamePool( $gl_oVars->cDBInterface );	
	$cCup = new Cup( $gl_oVars->cDBInterface, $iCupId );
	$cTree = new CupTree();
	$cCountry = new Country( $gl_oVars->cDBInterface );


	
	$oCup	= $cCup->GetData();
	$oGame = $cGamePool->GetGameById( (int)$oCup->game_id );
	
	#------------------------------------------------
	# GG	
	#------------------------------------------------	
	if( $_GET['a'] == 'tree_evaluator' )
	{
		$iMatchId 		= (int)$_GET['match_id'];
		$iParticipantId	= (int)$_GET['participant_id'];

		//$cMatch = new Match( $gl_oVars->cDBInterface, $iMatchId );
		//$oMatch = $cMatch->GetData();
		$oEncount = $cCup->GetEncountByMatchId( $iMatchId );
		
		
		if( $oEncount && $iParticipantId != -1 )
		{
			if( $oEncount->challenger_id == $iParticipantId ) $cCup->EvaluateMatchEncount( $oCup, $iMatchId, true, false );
			
			echo $iMatchId;
			
			if( $oEncount->opponent_id == $iParticipantId ) $cCup->EvaluateMatchEncount( $oCup,  $iMatchId, false, true );
		}//if		
	}//if
	
	
	$num_members 	= $oCup->max_participants;
	$rounds			= (log($num_members)/log(2));
	$r_start 		= (int)$_GET['r'];
	$r_max	 		= $rounds+1 ;
	
	# CHECK: Cup right participants ?	
	
	$_next = (int)$_GET['r'] + $r_max;
	$_prev = (int)$_GET['r'] - $r_max;
	
	if( $_prev < 0 ) $_prev = 0;
	if( $_next > ($rounds-$r_max)  ) $_next = $rounds-$r_max;
	if( $_next < 0 ) $_next = 0;
	
	$gl_oVars->cTpl->assign( 'cuptree_prevrnd', 	$_prev );
	$gl_oVars->cTpl->assign( 'cuptree_nextrnd', 	$_next );
	
	
	# create tree mask
	$cTree->CreateTreeMask( $num_members, $r_start, $r_max  );
	
	# get data from db
	$cCup->AssignCupData( $r_start, $r_max, $oCup->participant_type );
	

	
	$gl_oVars->cTpl->assign( 'cup', 				$oCup );
		
	#$gl_oVars->cTpl->assign( 'cup_participants', 	$cCup->aParticipants );
	$gl_oVars->cTpl->assign( 'cup_matches', 		$cCup->aEncounts );
	$gl_oVars->cTpl->assign( 'cup_parmatches', 		$cCup->aPartEncs );
	
	
	
	
	$gl_oVars->cTpl->assign( 'cuptree_membermask', 	$cTree->oTreeMask->aMemberMask );
	$gl_oVars->cTpl->assign( 'cuptree_selectmask',	$cTree->oTreeMask->aSelectMask );
	$gl_oVars->cTpl->assign( 'cuptree_vsmask',		$cTree->oTreeMask->aVSMask );


	$gl_oVars->cTpl->assign( 'cuptree_numrounds',	$cTree->numRounds );
	$gl_oVars->cTpl->assign( 'cuptree_maxrounds',	$cTree->maxRounds );
	$gl_oVars->cTpl->assign( 'cuptree_startround',	$cTree->startRound );
	
	
	
	
	# overgive defines to template-system
	$gl_oVars->cTpl->assign( 'parttype_member',		PARTTYPE_MEMBER );
	$gl_oVars->cTpl->assign( 'parttype_team',		PARTTYPE_TEAM );

	
	
	
	$aMemberCounter = array();
	$aEncountCounter = array();
	for( $i=0; $i < $cTree->numRounds; $i++ )
	{
		$aMemberCounter[$i]=0;
		$aEncountCounter[$i]=0;
	}
	
	$gl_oVars->cTpl->assign( 'cuptree_membercnt',	$aMemberCounter );
	$gl_oVars->cTpl->assign( 'cuptree_encountcnt',	$aEncountCounter );
		
	
	$gl_oVars->cTpl->assign( 'countries',	$cCountry->GetCountries() );
	$gl_oVars->cTpl->assign( 'game',	$oGame );

	
	
	
	# init 
	ini_set('max_execution_time', 100 );
?>
