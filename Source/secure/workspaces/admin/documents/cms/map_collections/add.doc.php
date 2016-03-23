<?php
	global $gl_oVars;
	
	// define classes/objects
	$cMapCollections = new MapCollections( $gl_oVars->cDBInterface );
	$cGame = new GamePool( $gl_oVars->cDBInterface );
	
	
	// get maps
	$aCollections = $cMapCollections->GetCollections();

	$aGames = array();
	$aGames = $cGame->GetGames();
		
	
	if( $_GET['a'] == 'add' ){
		$collection_obj
					= array( 	'name'		=> $_POST['name'],
								'game_id'	=> $_POST['game_id'],
								'created'	=> EGL_TIME,
							);
		
		$cMapCollections->NewCollection( $collection_obj );
		$iNewCollectionId = $gl_oVars->cDBInterface->InsertId();
		PageNavigation::Location( $gl_oVars->sURLFile.'?page=cms.map_collections.admin&collection_id='.$iNewCollectionId );
	}
	
	
	// save data to template
	$gl_oVars->cTpl->assign( 'GAMES', 			$aGames );
	$gl_oVars->cTpl->assign( 'MAP_COLLECTIONS', $aCollections );
?>