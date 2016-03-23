<?php
	global $gl_oVars;

	# var defines
	$aMemberGames		= db_read_array_string( $gl_oVars->oMemberData->games );
	$aSelectedGames 	= array();
	$aUnselectedGames	= array();


	
	if( $_GET['a'] == 'add' )
	{
		$game_id = (int)$_POST['game_id'];
		
		#check
		for( $i=0; $i < sizeof($aMemberGames); $i++ )
			if( $aMemberGames[$i] == $game_id )
				break;
		
		#add
		if( $i == sizeof($aMemberGames) && $game_id > 0 )
		{
			
			#add
			$aMemberGames[sizeof($aMemberGames)] = $game_id;
		
			#save obj
			$obj = NULL;
			$obj->games = db_create_array_string($aMemberGames);
			
		
			# change/update data
			$gl_oVars->cMember->SetMemberData($obj);
		}
	}
	if( $_GET['a'] == 'remove' )
	{
		$aNewGames 	= array();
		$game_id 	= (int)$_GET['game_id'];
		
		
		for($i=0; $i< sizeof($aMemberGames); $i++)
			if( $aMemberGames[$i]!=$game_id)
				$aNewGames[sizeof($aNewGames)] = $aMemberGames[$i];

		#save obj
		$obj = NULL;
		$obj->games = db_create_array_string($aNewGames);
		
		
		# change/update data
		$gl_oVars->cMember->SetMemberData($obj);
		$aMemberGames = $aNewGames;
	}
	
	



	#===============================================================
	# Read
	#===============================================================

	# read all games
	$cGamePool = new GamePool( $gl_oVars->cDBInterface );
	$aGames = $cGamePool->GetGames();

	
	# filter selected games
	for($g=0; $g < sizeof($aMemberGames); $g++ )
		for($i=0; $i < sizeof($aGames); $i++ )
			if( $aMemberGames[$g] == $aGames[$i]->id )
				$aSelectedGames[sizeof($aSelectedGames)] = $aGames[$i];
	
	# filter unselected games
	for( $g=0; $g < sizeof($aGames); $g++ )
	{
		for( $u=0; $u < sizeof($aSelectedGames); $u++ )
			if( $aSelectedGames[$u]->id == $aGames[$g]->id )
				break;

		if( $u == sizeof($aSelectedGames) )
			$aUnselectedGames[sizeof($aUnselectedGames)] = $aGames[$g];
	}
				
	
	# save all games
	$gl_oVars->cTpl->assign( "unselected_games",   $aUnselectedGames );
	$gl_oVars->cTpl->assign( "selected_games",  $aSelectedGames );

?>