<?php
	global $gl_oVars;

	
	# var defines
	$oClan 		= $gl_oVars->cMember->GetClanAccount( (int)$_GET['clan_id'] );
	$iTeamId	= (int)$_GET['team_id'];
	
	$cTeam		= new Team( $gl_oVars->cDBInterface );
	
	
	$oTeam = $cTeam->GetTeam_clandata( $iTeamId );
	
	# provide team/clan data to template file
	$gl_oVars->cTpl->assign( 'team', $oTeam);
	$gl_oVars->cTpl->assign( 'clan', $oClan);
	
	
	$aTeamGames			= db_read_array_string( $oTeam->games );
	
	$aSelectedGames 	= array();
	$aUnselectedGames	= array();


	if( $_GET['a'] == 'add' )
	{
		$game_id = (int)$_POST['game_id'];
		
		#check
		for( $i=0; $i < sizeof($aTeamGames); $i++ )
			if( $aTeamGames[$i] == $game_id )
				break;
		
		#add
		if( $i == sizeof($aTeamGames) && $game_id > 0 )
		{
			$aTeamGames[sizeof($aTeamGames)] = $game_id;
		
			#save obj
			$obj = NULL;
			$obj->games = db_create_array_string($aTeamGames);
		
			# change/update data
			$cTeam->SetTeamData( $obj, $oTeam->id );
		}
	}
	if( $_GET['a'] == 'remove' )
	{
		$aNewGames 	= array();
		$game_id 	= (int)$_GET['game_id'];
		
		
		for($i=0; $i< sizeof($aTeamGames); $i++)
			if( $aTeamGames[$i]!=$game_id)
				$aNewGames[sizeof($aNewGames)] = $aTeamGames[$i];

		#save obj
		$obj = NULL;
		$obj->games = db_create_array_string($aNewGames);
		
		
		# change/update data
		$cTeam->SetTeamData( $obj, $oTeam->id);
		$aTeamGames = $aNewGames;
	}
	
	



	#===============================================================
	# Read
	#===============================================================

	# read all games
	$cGamePool = new GamePool( $gl_oVars->cDBInterface );
	$aGames = $cGamePool->GetGames();
	
	
	# filter selected games
	for($g=0; $g < sizeof($aTeamGames); $g++ )
		for($i=0; $i < sizeof($aGames); $i++ )
			if( $aTeamGames[$g] == $aGames[$i]->id )
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
	$gl_oVars->cTpl->assign( "selected_games", 	 $aSelectedGames  );

?>