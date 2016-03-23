<?php
	global $gl_oVars;
	
	$iCupId	= (int)$_GET['cup_id'];

	
	$cCup		= new Cup( $gl_oVars->cDBInterface, $iCupId );
	$cGamePool	= new GamePool( $gl_oVars->cDBInterface );
	
	
	# fetch data
	$oCup		= $cCup->GetData();

	
	if( $oCup->finished )
	{
		# top 2 winner 
		$aWinner = $cCup->GetCupWinner( $oCup, 3 );
		$gl_oVars->cTpl->assign( 'ranking', $aWinner );
	}	
	
	$aAdminlist = $cCup->GetCupAdministrator( $oCup->id );
	
	/*
	$cCup->EvaluateMatchEncount( $oCup, 6, 1, 0);
	$cCup->EvaluateMatchEncount( $oCup, 7, 1, 0);
	
	
	$cCup->EvaluateMatchEncount( $oCup, 36, 1, 0);
	$cCup->EvaluateMatchEncount( $oCup, 37, 1, 0);
	
	$cCup->EvaluateMatchEncount( $oCup, 52, 1, 0);
	*/
	
	# fetch news 
	if( $oCup->cat_id > 0)
	{
		$aCupNews = module_sendmessage( MODULEID_INETOPIA_NEWS, 'get_category_news', $__DATA__, $oCup->cat_id );
		$gl_oVars->cTpl->assign ( 'cupnews', $aCupNews );
	}
	
	# provide template with cup informations
	$gl_oVars->cTpl->assign ( 'cup', $oCup );
	$gl_oVars->cTpl->assign ( 'adminlist', $aAdminlist );
	$gl_oVars->cTpl->assign ( 'games', $cGamePool->GetGames() );
	
	
	//$gl_oVars->cTpl->assign ( 'GLOBAL_COLOR', 'yellgreen' );
	return 1;
?>