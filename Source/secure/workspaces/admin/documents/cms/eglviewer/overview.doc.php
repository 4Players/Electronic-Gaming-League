<?php
	global $gl_oVars;

	$iCatId		= (int)$_GET['cat_id'];
	if( !isset($_GET['cat_id'])) $iCatId = -1;
	

	# declare classes
	$cMyCats = new MyCategory( $gl_oVars->cDBInterface );
	
	
	//----------------------------------------------------
	// Kategorie
	//----------------------------------------------------
	if( $_GET['a'] == "newcat" )
	{
		//$obj = array( "name" => $_POST['cat_name'], "cat_id" => $iCatId );
		$cMyCats->CreateCategory(  $_POST['cat_name'], $iCatId );
		
	}//if
	else if( $_GET['a'] == "deletecat" )
	{
		$work_CatId = (int)$_GET['work_catid'];	// arbeitet mit dieser ID
		
		//$obj = array( "name" => $_POST['cat_name'], "cat_id" => $iCatId );
		$cMyCats->DeleteCategory( $work_CatId, true );
		
	}//if
	else
	{
	}
	
	
	# fetch data
	$oCatRoot = $cMyCats->GenerateTree( $iCatId );
	$aPath = $cMyCats->GetPath( $oCatRoot->oProperties->id );
	

	//$gl_oVars->cTpl->assign( "cats_per_line", $iCatsPerLine );
	//$gl_oVars->cTpl->assign( "cat_lines", (int)(sizeof($oCatRoot->aNodes)/$iCatsPerLine)+1 );
	$gl_oVars->cTpl->assign( "CatRoot", $oCatRoot );
	$gl_oVars->cTpl->assign( "path", $aPath );
	$gl_oVars->cTpl->assign( "CAT_ID", $iCatId );
?>