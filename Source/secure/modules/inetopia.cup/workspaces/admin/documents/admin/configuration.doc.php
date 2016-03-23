<?php
	global $gl_oVars;

	$iCupId		= (int)$_GET['cup_id'];

	# declare classes and objects
	$cCup 				= new Cup( $gl_oVars->cDBInterface, $iCupId );
	$cGamePool			= new GamePool( $gl_oVars->cDBInterface );
	$cMatchStructures 	= new MatchStructures( $gl_oVars->cDBInterface );
	$cMyCategory		= new MyCategory( $gl_oVars->cDBInterface );
	$cCountry 			= new Country( $gl_oVars->cDBInterface );

	
	# fetch cup data
	$oCup 				= $cCup->GetData();
	$oGame 				= $cGamePool->GetGameById( (int)$oCup->game_id );
	$aGames 			= $cGamePool->GetGames();
	$aCountries			= $cCountry->GetCountries();
	
	if( $_GET['a'] == 'change')
	{
		# set date / clock
		list ($day, $month, $year) = explode('.', $_POST['start_time_date']); 
		list ($hour, $min) = explode(':', $_POST['start_time_clock']); 
		
		# set unix timestamp
		$start_time	= mktime( $hour, $min, 0, $month, $day, $year );

		if( strlen($_POST['name']) == 0 )
		{
			if( $_POST['participant_type'] == PARTTYPE_MEMBER){
				$_POST['name'] = '1on1 '.$oGame->name.' Cup';
			}//if
			else if( $_POST['participant_type'] == PARTTYPE_TEAM){
				$_POST['name'] = (int)$_POST['num_team_members'].'on'.(int)$_POST['num_team_members'].' '.$oGame->name.' Cup';
			}//elseif
			else{
				$_POST['name'] = $oGame->name.' Cup';
			}//else
			
		}//if strlen(name)=0
		
		$cup_obj = array( 	'name'					=> $_POST['name'],
							'cat_id' 				=> $_POST['cat_id'],
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
							'created'				=> EGL_TIME,
							'country_id'			=> $_POST['country_id'],
						);
							
		# execute query
		if( $gl_oVars->cDBInterface->Query( $gl_oVars->cDBInterface->CreateUpdateQuery( $GLOBALS['g_egltb_cups'], $cup_obj ) . " WHERE id=$iCupId" ) )
		{
			$gl_oVars->cTpl->assign( 'success', 	true );
			$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
			$gl_oVars->cTpl->assign( 'msg_text', 	'Einstellungen wurden vom System erfolgreich übernommen.' );
	
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPage.'&cup_id='.$oCup->id  );
		}
		else
		{
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			$gl_oVars->cTpl->assign( 'msg_text', 	'Das System konnte die Daten nicht übernehmen. Bitte entnehmen Sie weitere Informationen aus den Build-Protokollen.' );
		}

				
	}

	
	$aCupAdministrator = array();
	$aAdministrator = array();
	
	
	
	$oCatRoot = $cMyCategory->GenerateTree( -1, -1 );
	$gl_oVars->cTpl->assign( 'categoryroot', $oCatRoot );


	$gl_oVars->cTpl->assign( 'matchstructures', $cMatchStructures->GetMatchStructures() );
	$gl_oVars->cTpl->assign( 'cup',	$oCup );
	$gl_oVars->cTpl->assign( 'game',	$oGame );
	$gl_oVars->cTpl->assign( 'games',	$aGames );
	$gl_oVars->cTpl->assign( 'countries', $aCountries );		
	
?>