<?php
	global $gl_oVars;
	 

	$iCupId	= (int)$_GET['cup_id'];
	

	$cCountry = new Country( $gl_oVars->cDBInterface );
	$cTree 	= new CupTree();
	$cCup 	= new Cup( $gl_oVars->cDBInterface, $iCupId );
	$oCup	= $cCup->GetData();
	
	
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
	#$gl_oVars->cTpl->assign( 'tree', $cTree->display() );
	
	#echo nl2br( print_r( $cCup->aMatches, 1 ));	
	
	#$cCup = new Cup( $gl_oVars->cDBInterface, 1 );
	#$cCup->AssignData( 0, 2 );
	

	
?>
