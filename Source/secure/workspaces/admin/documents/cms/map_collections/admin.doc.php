<?php
	global $gl_oVars;
	
	$iCollectionId	= (int)$_GET['collection_id'];
	
	
	// define classes/objects
	$cMapCollections = new MapCollections( $gl_oVars->cDBInterface );
	$cGame = new GamePool( $gl_oVars->cDBInterface );

	$aGames = array();
	$aGames = $cGame->GetGames();
	
	// get maps
	$aMaps = $cMapCollections->GetCollectionMaps( $iCollectionId );
	$oCollection = $cMapCollections->GetCollectionById( $iCollectionId );
	
	
	
	if( $_GET['a'] == 'collection' )
	{
		$update_obj = array( 	'name'		=> $_POST['name'],
								'game_id'	=> $_POST['game_id'],
							);
		$cMapCollections->SetCollectionData( $update_obj, $iCollectionId );
		PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPage.'&collection_id='.$iCollectionId );
	
	}
	else if( $_GET['a'] == 'maps' )
	{
		// add new maps
		for( $i=0; $i < 5; $i++ ){
			$new_map = $_POST['map_name_new_'.$i];
			if( strlen($new_map) > 0)
			{
				$newmap_obj = array( 	'map_name'		=> $new_map,
										'collection_id'	=> $iCollectionId,
										'created'		=> EGL_TIME,
								);
				$cMapCollections->NewMap($newmap_obj);
			}
		}//for
		
		// update exists maps
		for( $i=0; $i < sizeof($aMaps); $i++ ){
			$oMap = $aMaps[$i];
			$newmap_name = $_POST['map_name_'.$i];
			if( $newmap_name != $oMap->map_name && strlen($newmap_name) > 0 )
			{
				$map_obj = array( 		'map_name'		=> $newmap_name,
								);
				$cMapCollections->SetMapData($map_obj,$oMap->id);
			}
			// delete map?
			elseif( strlen($newmap_name) == 0 ) {
				$cMapCollections->DeleteMap( $oMap->id );
			}
		}//for
		PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPage.'&collection_id='.$iCollectionId );
	}
	else if( $_GET['a'] == 'delete' ){
		
		$cMapCollections->DeleteCollectionMaps ($iCollectionId);
		$cMapCollections->DeleteCollection ($iCollectionId);
		
		PageNavigation::Location( $gl_oVars->sURLFile.'?page=cms.map_collections.overview' );
	}	
	
	
	
	// save data to template
	$gl_oVars->cTpl->assign( 'MAPS', 		$aMaps );
	$gl_oVars->cTpl->assign( "GAMES", 		$aGames );	
	$gl_oVars->cTpl->assign( "COLLECTION", 	$oCollection );	
?>