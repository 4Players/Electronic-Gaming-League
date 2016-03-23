<?php

	global $gl_oVars;

	# fetch url data
	$iLadderId	= (int)$_GET['ladder_id'];
	//$iGameId = (int)$_GET['game_id'];
	
	
	# classes & objects
	$cLadderSystem	= new InetopiaLadder( $gl_oVars->cDBInterface );
	$cGamePool = new GamePool( $gl_oVars->cDBInterface );
	$cMatchStructures = new MatchStructures( $gl_oVars->cDBInterface );
	$cMatch = new Match( $gl_oVars->cDBInterface );


	# fetch ladderdata
	$oLadder = $cLadderSystem->GetLadderbyID( $iLadderId );
	
	# ladder available?
	if( $oLadder )
	{
		$oGame = $cGamePool->GetGameById( $oLadder->game_id );
		
		
		# ------------------------------------------
		# 
		# ------------------------------------------
		if( $_GET['a'] == 'change' )
		{
			
			$ladder_data = array( 'rules_text'	=> $_POST['rules_text'] );
			
			$qre = $gl_oVars->cDBInterface->Query( $gl_oVars->cDBInterface->CreateUpdateQuery( $GLOBALS['g_egltb_ladders'], $ladder_data )." WHERE id=".$iLadderId );
			if( $qre )
			{
				PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sModuleId.':'.$gl_oVars->sURLPage.'&ladder_id='.$iLadderId );
				
				//echo $gl_oVars->sURLFile.'?page='.$gl_oVars->sModuleId.':'.$gl_oVars->sURLPage.'&ladder_id='.$iLadderId;
			}
			else 
			{
			}
			
		}
				
	
		# provide template with data
		$gl_oVars->cTpl->assign( 'ladder', 	$oLadder );
		$gl_oVars->cTpl->assign( 'game', $oGame );
	}
?>