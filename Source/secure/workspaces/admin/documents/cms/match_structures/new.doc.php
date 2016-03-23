<?php
	global $gl_oVars;
	
	// define GamePool
	$cGame = new GamePool( $gl_oVars->cDBInterface );
	$cMatchStructures = new MatchStructures( $gl_oVars->cDBInterface );
	$cMapCollections = new MapCollections( $gl_oVars->cDBInterface );
	
	
	$aGames = array();
	$aGames = $cGame->GetGames();
	
	
	// get maps
	$aCollections = $cMapCollections->GetCollections();
	
	
	###############################################
	if( $_GET['a'] == "add_structure" )
	{
		$aMaps = array();
		if( strlen($_POST['map1']) > 0 ) $aMaps[sizeof($aMaps)] = $_POST['map1'];
		if( strlen($_POST['map2']) > 0 ) $aMaps[sizeof($aMaps)] = $_POST['map2'];
		if( strlen($_POST['map3']) > 0 ) $aMaps[sizeof($aMaps)] = $_POST['map3'];
		if( strlen($_POST['map4']) > 0 ) $aMaps[sizeof($aMaps)] = $_POST['map4'];
		$num_maps = sizeof($aMaps);
		if( $_POST['num_maps'] > sizeof($aMaps) ) $num_maps =$_POST['num_maps'] ;	// empty maps??
		
		$aRoundNames = array();
		if( strlen($_POST['round1_challenger']) > 0 || strlen($_POST['round1_opponent']) > 0 ) $aRoundNames[sizeof($aRoundNames)] = $_POST['round1_challenger'].'#'.$_POST['round1_opponent'];
		if( strlen($_POST['round2_challenger']) > 0 || strlen($_POST['round2_opponent']) > 0 ) $aRoundNames[sizeof($aRoundNames)] = $_POST['round2_challenger'].'#'.$_POST['round2_opponent'];
		if( strlen($_POST['round3_challenger']) > 0 || strlen($_POST['round3_opponent']) > 0 ) $aRoundNames[sizeof($aRoundNames)] = $_POST['round3_challenger'].'#'.$_POST['round3_opponent'];
		$numRoundNames = sizeof($aRoundNames);
		if( $numRoundNames==0 ) $numRoundNames =1;
		
				
		$structure_obj = array(	"game_id" 			=> $_POST['game_id'],
								"name" 				=> $_POST['name'],
								"calculator_id" 	=> $_POST['calculator_id'],
								"num_maps" 			=> $num_maps,
								"num_rounds" 		=> $numRoundNames, 
								"maps" 				=> db_create_array_string($aMaps),
								"round_names" 		=> db_create_array_string($aRoundNames),
								"created" 			=> EGL_TIME,
								"fixed"				=> (int)$_POST['fixed'],
								"mapcollection_id"	=> (int)$_POST['mapcollection_id'],
								);

								
		# add structure to DB
		if( $cMatchStructures->AddStructure( $structure_obj ))
		{
			$gl_oVars->cTpl->assign( "success", true );
			
			$gl_oVars->cTpl->assign( "msg_type",  "success" );
			$gl_oVars->cTpl->assign( "msg_text",  "Die Match Struktur wurde erfolgreich erstellt." );		

			$iNewMatchStructureId = $gl_oVars->cDBInterface->InsertId();
			PageNavigation::Location( $gl_oVars->sURLFile.'?page=cms.match_structures.admin&ms_id='.$iNewMatchStructureId );
		}
		else 
		{
			$gl_oVars->cTpl->assign( "msg_type",  "error" );
			$gl_oVars->cTpl->assign( "msg_text",  "Die Match Struktur konnte nicht erstellt werden." );		
		}//if
		
		
	}//if
	
	
	
	$gl_oVars->cTpl->assign( "games", $aGames );
	
	// save data to template
	$gl_oVars->cTpl->assign( 'MAP_COLLECTIONS', $aCollections );
?>