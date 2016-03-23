<?php

	global $gl_oVars;

	# fetch url data
	$iGameId = (int)$_GET['game_id'];
	
	# classes & objects
	$cLadderSystem		= new InetopiaLadder( $gl_oVars->cDBInterface );
	$cGamePool 			= new GamePool( $gl_oVars->cDBInterface );
	$cMatchStructures 	= new MatchStructures( $gl_oVars->cDBInterface );
	$cMyCategory		= new MyCategory( $gl_oVars->cDBInterface );
	$cCalculator		= new Calculator();
	$cCountry 			= new Country( $gl_oVars->cDBInterface );
	
	
	# fetch ladderdata
	$oGame 			= $cGamePool->GetGameById( $iGameId );
	$aGames 		= $cGamePool->GetGames();
	$aCalculator	= $cCalculator->GetCalculator();
	$aCountries		= $cCountry->GetCountries();
		
	# -------------------------------------------
	# Test	
	# -------------------------------------------	
	if( $_GET['a'] == 'add' )
	{

		
		# set date / clock
		list ($day, $month, $year) = explode('.', $_POST['start_time_date']); 
		list ($hour, $min) = explode(':', $_POST['start_time_clock']); 
		
		$oLaddeGame = $cGamePool->GetGameById( (int)$_POST['game_id'] );

		# set unix timestamp
		$start_time	= mktime( $hour, $min, 0, $month, $day, $year );
		if( strlen($_POST['name']) == 0 )
		{
			if( $_POST['participant_type'] == PARTTYPE_MEMBER )$_POST['name'] = '1on1 '.$oLaddeGame->name. ' Ladder';
			elseif( $_POST['participant_type'] == PARTTYPE_TEAM )
			{
				$_POST['name'] = (int)$_POST['num_team_members'].'on'.(int)$_POST['num_team_members'].' '.$oLaddeGame->name. ' Ladder';
			}//if
		}
		/**	=> DISABLED
		else
		{
			if( strlen($_POST['name']) > 0 &&
				$_POST['name'] )
			{
				$zeichenkette = $_POST['name'];
				$suchmuster = '/([0-9]+)(\ *)([a-zA-z0-9]{0,4})(\ *)([0-9]+)/i';
				if( $_POST['participant_type'] == PARTTYPE_MEMBER )
					$ersetzung = '1${2}${3}${4}1';
				else if( $_POST['participant_type'] == PARTTYPE_TEAM )
					$ersetzung = (int)$_POST['num_team_members'].'${2}${3}${4}'.(int)$_POST['num_team_members'];
				
				$_POST['name'] = preg_replace($suchmuster, $ersetzung, $zeichenkette);
			}//if
		}//if
		***/

		# generate subcat
		$iCatId = (int)$_POST['cat_id'];
		if( $_POST['create_subcat'] == 'yes' )
		{
			$iCatId = $cMyCategory->CreateCategory( $_POST['name'], (int)$_POST['cat_id'] );
		}

		$challenge_types = 0;
		if( $_POST['double_challenge'] == 'yes' ) $challenge_types |= CHALLENGETYPE_DOUBLE_MAP;
		if( $_POST['single_challenge'] == 'yes' ) $challenge_types |= CHALLENGETYPE_SINGLE_MAP;
		if( $_POST['random_challenge'] == 'yes' ) $challenge_types |= CHALLENGETYPE_RANDOM_MAP;

		$ladder_obj = array( 	'name'					=> $_POST['name'],
								'cat_id' 				=> $iCatId,
								'calculator'			=> $_POST['calculator'],
								'matchstructure_id' 	=> $_POST['matchstruct_id'],
								'participant_type'		=> $_POST['participant_type'],
								'challenge_types' 		=> $challenge_types,
								//'check_gameacc_id' 		=> $_POST['check_gameacc_id'],
								'start_time' 			=> $start_time,
								'game_id'				=> $_POST['game_id'],
								'max_participants'		=> $_POST['max_participants'],
								'num_team_members'		=> $_POST['num_team_members'],
								'is_public'				=> $_POST['is_public'],
								'join_time'				=> $_POST['join_time'],
								'first_points_score'	=> $_POST['first_points_score'],
								'signin_locked'			=> $_POST['signin_locked'],
								'check_gameacc_id'		=> $_POST['check_gameacc_id'],
								'fastchallenge_mode'	=> $_POST['fastchallenge_mode'],
								'created'				=> EGL_TIME,
								'country_id'			=> $_POST['country_id'],
							);
							
		
		# execute query
		if( $gl_oVars->cDBInterface->Query( $gl_oVars->cDBInterface->CreateInsertQuery( $GLOBALS['g_egltb_ladders'], $ladder_obj ) ))
		{
			$gl_oVars->cTpl->assign( 'success', 	true );
			$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
			$gl_oVars->cTpl->assign( 'msg_title', 	'Änderungen erfolgreich' );
			$gl_oVars->cTpl->assign( 'msg_text', 	'Laddereinstellungen wurden vom System erfolgreich übernommen' );
		}
		else
		{
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
			$gl_oVars->cTpl->assign( 'msg_text', 	'Das System konnte die Ladder nicht übernehmen' );
		}
	}//if
		

	$oCatRoot = $cMyCategory->GenerateTree( -1, -1 );
	$gl_oVars->cTpl->assign( 'categoryroot', $oCatRoot );
	
	
	# provide template with data
	$gl_oVars->cTpl->assign( 'matchstructures', $cMatchStructures->GetMatchStructures() );
	$gl_oVars->cTpl->assign( 'game', $oGame );
	$gl_oVars->cTpl->assign( 'games', $aGames );
	$gl_oVars->cTpl->assign( 'calculator', $aCalculator );
	$gl_oVars->cTpl->assign( 'countries', $aCountries );	
	
?>