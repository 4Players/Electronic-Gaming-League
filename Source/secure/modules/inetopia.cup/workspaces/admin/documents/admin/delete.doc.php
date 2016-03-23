<?php
	global $gl_oVars;

	$iCupId		= (int)$_GET['cup_id'];

	# declare classes and objects
	$cCup 				= new Cup( $gl_oVars->cDBInterface, $iCupId );
	$cGamePool			= new GamePool( $gl_oVars->cDBInterface );

	
	# fetch cup data
	$oCup = $cCup->GetDetailedCup( $iCupId );
	if( $oCup )$oGame = $cGamePool->GetGameById( (int)$oCup->game_id );
	
	
	# ---------------------------------------------------------------------
	# fetch action data
	# ---------------------------------------------------------------------
	if( $oCup )
	{
		if( $_GET['a']	== 'delete' )
		{
			if( $_POST['delete_mode'] == 'all' )
			{
				# delete match & encounts
				$cCup->DeleteMatchEncounts( $iCupId );
				
				# delete participants
				$cCup->DeleteCupParticipants( $iCupId );
				
				# delete cup
				$cCup->DeleteCup( $iCupId );
				
				$gl_oVars->cTpl->assign ( 'success', 	true );
				$gl_oVars->cTpl->assign ( 'msg_type', 	'success' );
				$gl_oVars->cTpl->assign ( 'msg_text', 	'Das Turnier wurde hiermit unwiderruflich gelöscht.' );
				
				PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sModuleId.':gamecups&game_id='.$oCup->game_id  );
			}
			elseif( $_POST['delete_mode'] == 'patches' )
			{
				if( $_POST['delete_matches'] == 'yes' ) $cCup->DeleteMatchesByModuleData( $iCupId );
				if( $_POST['delete_encounts'] == 'yes' ) $cCup->DeleteEncounts( $iCupId );
				if( $_POST['delete_participants'] == 'yes' )  $cCup->DeleteCupParticipants( $iCupId );
				
				$gl_oVars->cTpl->assign ( 'success', 	true );
				$gl_oVars->cTpl->assign ( 'msg_type', 	'success' );
				$gl_oVars->cTpl->assign ( 'msg_text', 	'Einige Turnierdaten wurden hiermit unwiderruflich gelöscht.' );
			}
			else
			{
				$gl_oVars->cTpl->assign ( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign ( 'msg_text', 	'Es muss ein bestimmter Löschmodus ausgewählt sein' );
			}
			
		}//if $_GET
		
	}//if $oCup

	if( $oCup->max_participants > 0 )
		$efficiency				= round( (($oCup->num_participants/$oCup->max_participants)*100), 1);
	
	$gl_oVars->cTpl->assign( 'game',	$oGame );
	$gl_oVars->cTpl->assign( 'cup',		$oCup );
?>