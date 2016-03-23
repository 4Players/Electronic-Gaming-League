<?php
	global $gl_oVars;

	$iCupId		= (int)$_GET['cup_id'];

	# declare classes and objects
	$cCup 				= new Cup( $gl_oVars->cDBInterface, $iCupId );
	$cGamePool			= new GamePool( $gl_oVars->cDBInterface );

	
	# fetch cup data
	$oCup = $cCup->GetDetailedCup( $iCupId );
	if( $oCup )
	{
		$oGame = $cGamePool->GetGameById( (int)$oCup->game_id );
		# ------------------------------------------
		# 
		# ------------------------------------------
		if( $_GET['a'] == 'change' )
		{
			
			$ladder_data = array( 'rules_text'	=> $_POST['rules_text'] );
			
			$qre = $gl_oVars->cDBInterface->Query( $gl_oVars->cDBInterface->CreateUpdateQuery( $GLOBALS['g_egltb_cups'], $ladder_data )." WHERE id=".$iCupId );
			if( $qre )
			{
				PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sModuleId.':'.$gl_oVars->sURLPage.'&cup_id='.$iCupId );
			}
			else 
			{
			}
			
		}//if
	}//if

	
	$gl_oVars->cTpl->assign( 'game',	$oGame );
	$gl_oVars->cTpl->assign( 'cup',		$oCup );
?>