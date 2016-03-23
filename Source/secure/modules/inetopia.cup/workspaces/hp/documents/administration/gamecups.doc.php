<?php

	global $gl_oVars;

	# fetch URL informations
	$iGameId	= (int)$_GET['game_id'];
	$iCupId		= (int)$_GET['cup_id'];
	
	

	# declare classes /objects
	$cCup		= new Cup( $gl_oVars->cDBInterface, NULL /*NO-ID*/ );
	$cGamePool	= new GamePool( $gl_oVars->cDBInterface );

	$oGame = $cGamePool->GetGameById( $iGameId );

	
	# fetch cuplist with participants !!
	if( $oGame )
	{
		$aCups 	= $cCup->GetDetailedGameCups( $iGameId );
		# fetch cup admins
		for( $i=0; $i < sizeof($aCups); $i++ )
		{
			$aCups[$i]->adminlist = $cCup->GetCupAdministrator( $aCups[$i]->id );
		}//for
		# set template vars
		$gl_oVars->cTpl->assign( 'cups',	$aCups );
	}
		
	
	$gl_oVars->cTpl->assign( 'game',	$oGame );
?>