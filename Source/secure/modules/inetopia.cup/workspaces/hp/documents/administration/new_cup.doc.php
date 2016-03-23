<?php
	global $gl_oVars;

	$iGameId	= (int)$_GET['game_id'];
	
	
	# declare classes /objects
	$cCup		= new Cup( $gl_oVars->cDBInterface, NULL /*NO-ID*/ );
	$cGamePool	= new GamePool( $gl_oVars->cDBInterface );

	$oGame = $cGamePool->GetGameById( $iGameId );


	$cGamePool			= new GamePool( $gl_oVars->cDBInterface );
	$cCup				= new Cup( $gl_oVars->cDBInterface, NULL );
	$cMatchStructures	= new MatchStructures( $gl_oVars->cDBInterface );
	$cMyCategory		= new MyCategory( $gl_oVars->cDBInterface );

	
	
	# ---------------------------------------------------------------------
	# fetch action data
	# ---------------------------------------------------------------------
	if( $_GET['a'] )
	{
		# set date / clock
		list ($day, $month, $year) = explode('.', $_POST['start_time_date']); 
		list ($hour, $min) = explode(':', $_POST['start_time_clock']); 
		
		# set unix timestamp
		$start_time	= mktime( $hour, $min, 0, $month, $day, $year );
		if( strlen($_POST['name']) == 0 ) $_POST['name'] = 'Unkown Cupname';

		# generate subcat
		$iCatId = (int)$_POST['cat_id'];
		if( $_POST['create_subcat'] == 'yes' )
		{
			$iCatId = $cMyCategory->CreateCategory( $_POST['name'], (int)$_POST['cat_id'] );
		}
		
		
		$cup_obj = array( 	'name'					=> $_POST['name'],
							'cat_id' 				=> $iCatId,
							'matchstruct_id' 		=> $_POST['matchstruct_id'],
							'participant_type'		=> $_POST['participant_type'],
							'type' 					=> $_POST['type'],
							'check_gameacc_id' 		=> $_POST['check_gameacc_id'],
							'start_time' 			=> $start_time,
							'checkin_time'			=> $_POST['checkin_time'],
							'game_id'				=> $_POST['game_id'],
							'max_participants'		=> $_POST['max_participants'],
							'num_team_members'		=> $_POST['num_team_members'],
							'is_public'				=> $_POST['is_public'],
							'description'			=> $_POST['description'],
							'map_pool'				=> $_POST['map_pool'],
							'created'				=> EGL_TIME );
		
		# execute query
		if( $gl_oVars->cDBInterface->Query( $gl_oVars->cDBInterface->CreateInsertQuery( $GLOBALS['g_egltb_cups'], $cup_obj ) ) )
		{
			$gl_oVars->cTpl->assign( 'success', 	true );
			$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
			$gl_oVars->cTpl->assign( 'msg_title', 	'Cup erstellt' );
			$gl_oVars->cTpl->assign( 'msg_text', 	'Der Cup wurde erfolgreich erstellt' );
		}
		else
		{
			//echo mysql_error();
			//DEBUG( MSGTYPE_ERROR, __LINE__, __FILE__, "" );
		}
	}
	else
	{
	}

	
	# provide template with data
	$oCatRoot = $cMyCategory->GenerateTree( -1, -1 );
	$gl_oVars->cTpl->assign( 'categoryroot', $oCatRoot );
	
	
	$gl_oVars->cTpl->assign( 'game',				$oGame );
	$gl_oVars->cTpl->assign( 'games',				$cGamePool->GetGames());
	$gl_oVars->cTpl->assign( 'matchstructures',		$cMatchStructures->GetMatchStructures() );
	
?>