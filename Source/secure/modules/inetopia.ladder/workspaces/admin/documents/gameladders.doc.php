<?php

	global $gl_oVars;

	# fetch URL informations
	$iGameId	= (int)$_GET['game_id'];
	//$iLadderId	= (int)$_GET['ladder_id'];
	
	

	# declare classes /objects
	$cLadderSystem	= new InetopiaLadder( $gl_oVars->cDBInterface );
	$cGamePool		= new GamePool( $gl_oVars->cDBInterface );

	# fetch gamedata
	$oGame = $cGamePool->GetGameById( $iGameId );

	
	# fetch cuplist with participants !!
	if( $oGame )
	{
		$aLadders 	= $cLadderSystem->GetDetailedLadderByGameId( $iGameId );
		

		# fetch cup admins
		for( $i=0; $i < sizeof($aLadders); $i++ )
		{
			$aLadders[$i]->adminlist = $cLadderSystem->GetLadderAdministrator( $aLadders[$i]->id );
		}//for
		# set template vars
		$gl_oVars->cTpl->assign( 'ladders',	$aLadders );
	}
	
	$gl_oVars->cTpl->assign( 'game',	$oGame );
?>