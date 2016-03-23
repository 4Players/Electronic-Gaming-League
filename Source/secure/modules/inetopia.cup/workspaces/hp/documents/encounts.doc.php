<?php
	global $gl_oVars;
	
	
	$cCountry = new Country( $gl_oVars->cDBInterface );

	
	# fetch data
	$iCupId	= (int)$_GET['cup_id'];

	$cTree 	= new CupTree();
	$cCup 	= new Cup( $gl_oVars->cDBInterface, $iCupId );
	$oCup	= $cCup->GetData();
	
	if( !$oCup )
	{
		# ERROR
		
		return 0;
	}
	

	/*
	$num_members 	= $oCup->max_participants;
	$rounds			= (log($num_members)/log(2));
	$r_start 		= (int)$_GET['r'];
	$r_max	 		= 5 ;
	*/
	
  
	# get data from db
	$cCup->AssignCupData( 0, -1, $oCup->participant_type );
	

	$gl_oVars->cTpl->assign( 'cup', 				$oCup );
		
	#$gl_oVars->cTpl->assign( 'cup_participants', 	$cCup->aParticipants );
	$gl_oVars->cTpl->assign( 'cup_matches', 		$cCup->aEncounts );
	$gl_oVars->cTpl->assign( 'cup_parmatches', 		$cCup->aPartEncs );
	return 1;
?>