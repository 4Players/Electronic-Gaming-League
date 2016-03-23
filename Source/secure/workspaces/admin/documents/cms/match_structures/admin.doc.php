<?php
	global $gl_oVars;
	
	$iMatchStructureId	= (int)$_GET['ms_id'];
	
	$cGame = new GamePool( $gl_oVars->cDBInterface );
	$cMatchStructures = new MatchStructures( $gl_oVars->cDBInterface );
	$cMatch = new Match( $gl_oVars->cDBInterface, NULL );
	$cMapCollections = new MapCollections( $gl_oVars->cDBInterface );
	
	
	
	$aGames = array();
	$aGames = $cGame->GetGames();

	// get matchstructure data from db
	$oMatchStructure = $cMatchStructures->GetMatchStructure($iMatchStructureId);
	
	// get maps
	$aCollections = $cMapCollections->GetCollections();
	
	
	if( $oMatchStructure )
	if( $_GET['a'] == "change_structure" )
	{
		$aMaps = array();
		for( $m=0; $m < 10; $m++ )
			if( strlen($_POST['map'.$m]) > 0 ) $aMaps[sizeof($aMaps)] = $_POST['map'.$m];
		$num_maps = sizeof($aMaps);
		if( $_POST['num_maps'] > sizeof($aMaps) ) $num_maps =$_POST['num_maps'] ;
		
		$aRoundNames = array();
		for( $r=0; $r < 10; $r++ )
		if( strlen($_POST['round'.$r.'_challenger']) > 0 || strlen($_POST['round'.$r.'_opponent']) > 0 ) $aRoundNames[sizeof($aRoundNames)] = $_POST['round'.$r.'_challenger'].'#'.$_POST['round'.$r.'_opponent'];
		$numRoundNames = sizeof($aRoundNames);
		if( $numRoundNames==0 ) $numRoundNames =1;
		
		$structure_obj = array(	"game_id" 			=> $_POST['game_id'],
								"name" 				=> $_POST['name'],
								"calculator_id" 	=> $_POST['calculator_id'],
								"num_maps" 			=> $num_maps, //$_POST['num_maps'],
								"num_rounds" 		=> $numRoundNames, 
								"maps" 				=> db_create_array_string($aMaps),
								"round_names" 		=> db_create_array_string($aRoundNames),
								"created" 			=> EGL_TIME,
								"fixed"				=> (int)$_POST['fixed'],
								"mapcollection_id"	=> (int)$_POST['mapcollection_id'],
								);
								
		# add structure to DB
		if( $cMatchStructures->SetStructureData( $structure_obj, $iMatchStructureId ))
		{
			$gl_oVars->cTpl->assign( "success", true );
			
			$gl_oVars->cTpl->assign( "msg_type",  "success" );
			$gl_oVars->cTpl->assign( "msg_text",  "Die Match Struktur wurde erfolgreich geändert." );		
			
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPage.'&ms_id='.$iMatchStructureId );
		}
		else 
		{
			$gl_oVars->cTpl->assign( "msg_type",  "error" );
			$gl_oVars->cTpl->assign( "msg_text",  "Die Match Strukture konnte nicht geändert werden." );		
		}//if
		
		
								
	}
	if( $_GET['a'] == "delete" )
	{
		# add structure to DB
		if( $cMatchStructures->DeleteStructure( $iMatchStructureId ))
		{
			$gl_oVars->cTpl->assign( "success", true );
			
			$gl_oVars->cTpl->assign( "msg_type",  "success" );
			$gl_oVars->cTpl->assign( "msg_title", "Gelöscht" );
			$gl_oVars->cTpl->assign( "msg_text",  "Die Match Struktur wurde erfolgreich gelöscht." );		
		}
		else 
		{
			$gl_oVars->cTpl->assign( "msg_type",  "error" );
			$gl_oVars->cTpl->assign( "msg_title", "Fehler" );
			$gl_oVars->cTpl->assign( "msg_text",  "Die Match Strukture konnte nicht gelöscht werden." );		
		}//if
		
	}//if
	if( $_GET['a'] == "preview" )
	{
	}//if
	else
	{
		
		#######################################################################
		# FOR DISPLAYING PREVIEW
		#######################################################################

		$virtual_match_obj = NULL;
		$virtual_match_obj->num_rounds 	= $oMatchStructure->num_rounds;
		$virtual_match_obj->num_maps 	= $oMatchStructure->num_maps;
		$virtual_match_obj->maps 		= $oMatchStructure->maps;
		$virtual_match_obj->round_names = $oMatchStructure->round_names;
		$virtual_match_obj->evaluated = 1;
		
		// create results
		for( $i=0; $i < ($oMatchStructure->num_maps*$oMatchStructure->num_rounds); $i++ )
			$virtual_match_obj->results .="0#0#";
		if( strlen($virtual_match_obj->results) > 0 ) $virtual_match_obj->results = substr( $virtual_match_obj->results, 0, strlen($virtual_match_obj->results)-1);
		
		
		$oVirtualMatchResult = new match_results_t;
		
		# fetch / read match results
		$oVirtualMatchResult = Match::FetchMatchResults( $virtual_match_obj );
	
		$gl_oVars->cTpl->assign( "match_result", $oVirtualMatchResult );
		if( $oVirtualMatchResult->bDetailedRounds ) 
			$gl_oVars->cTpl->assign( 'display_detailed_rounds', true );
			
		#######################################################################
		# FOR DISPLAYING STRUCTURE IN FORMULAR
		#######################################################################
		
		$match_obj = NULL;
		$match_obj->num_rounds = $oMatchStructure->num_rounds;
		$match_obj->num_maps = $oMatchStructure->num_maps;
		$match_obj->maps = $oMatchStructure->maps;
		$match_obj->round_names = $oMatchStructure->round_names;
		$match_obj->evaluated = 1;
		
		// create results
		for( $i=0; $i < ($oMatchStructure->num_maps*$oMatchStructure->num_rounds); $i++ )
			$match_obj->results .="0#0#";
		if( strlen($match_obj->results) > 0 ) $match_obj->results = substr( $match_obj->results, 0, strlen($match_obj->results)-1);

		$oMatchResult = new match_results_t;
		# fetch / read match results
		$oMatchResult = Match::FetchMatchResults( $match_obj );		
		
		$gl_oVars->cTpl->assign( "ms_template", $oMatchResult->aMapResults );
	}
	
	
	
	
	$gl_oVars->cTpl->assign( "matchstructure", $oMatchStructure );
	$gl_oVars->cTpl->assign( "games", $aGames );
	
	// save data to template
	$gl_oVars->cTpl->assign( 'MAP_COLLECTIONS', $aCollections );	
?>