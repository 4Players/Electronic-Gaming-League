<?php
	global $gl_oVars;
	
	// define classes/objects
	$cMapCollections = new MapCollections( $gl_oVars->cDBInterface );
	
	
	// get maps
	$aCollections = $cMapCollections->GetCollections();
	
	
	// save data to template
	$gl_oVars->cTpl->assign( 'MAP_COLLECTIONS', $aCollections );
?>