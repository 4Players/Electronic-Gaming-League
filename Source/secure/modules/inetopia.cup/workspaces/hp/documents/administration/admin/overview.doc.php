<?php
	global $gl_oVars;

	$iCupId		= (int)$_GET['cup_id'];

	# declare classes and objects
	$cCup 				= new Cup( $gl_oVars->cDBInterface, $iCupId );
	$cGamePool			= new GamePool( $gl_oVars->cDBInterface );
	$cAdministrator		= new Administrator( $gl_oVars->cDBInterface );

	
	# fetch cup data
	$oCup = $cCup->GetDetailedCup( $iCupId );
	$oGame = $cGamePool->GetGameById( (int)$oCup->game_id );
	if( $oCup )$aCupAdministrator = $cCup->GetCupAdministrator( $iCupId );
	
	
	
	# ---------------------------------------------------------------------
	# fetch action data
	# ---------------------------------------------------------------------
	if( $oCup )
	if( $_GET['a']	== 'start' )
	{
		$oCup = $cCup->GetCup( $iCupId );
		
		# start already done ?
		if( $oCup->encounts_created )
		{
			
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
			$gl_oVars->cTpl->assign( 'msg_text', 	'Der Turnierbaum wurde bereits erstellt. \'#'.$result.'\'' );
			
		}
		else
		{
			$result = 0;
			# create match_start
			if( strlen($result=$cCup->CreateMatchStart( $iCupId )) > 1 )
			{
				# ERROR 
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
				$gl_oVars->cTpl->assign( 'msg_text', 	'Das Turnierbaum konnte nicht erstellt werden - \'{'.$result.'\'.' );
			}
			else
			{
				# set match as started
				$obj = NULL;
				$obj->encounts_created = 1;
				$cCup->SetCupData( $obj, $iCupId );
				
				
				$gl_oVars->cTpl->assign( 'success', 	true );
				$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
				$gl_oVars->cTpl->assign( 'msg_title', 	'Baum erstellt' );
				$gl_oVars->cTpl->assign( 'msg_text', 	'Das Turnierbaum wurde erfolgreich erstellt.' );
			}//if
		}//if
		
	}//if
	else if( $_GET['a'] == 'finish')
	{
		# set match as started
		$obj = NULL;
		$obj->finished = 1;
		$cCup->SetCupData( $obj, $iCupId );
				
		$gl_oVars->cTpl->assign( 'success', 	true );
		$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
		$gl_oVars->cTpl->assign( 'msg_title', 	'Turnier beendet' );
		$gl_oVars->cTpl->assign( 'msg_text', 	'Das Turnier wurde beendet.' );
	}
	else if( $_GET['a'] == 'open')
	{
		# set match as started
		$obj = NULL;
		$obj->finished = 0;
		$cCup->SetCupData( $obj, $iCupId );		
		
		$gl_oVars->cTpl->assign( 'success', 	true );
		$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
		$gl_oVars->cTpl->assign( 'msg_title', 	'Turnier eröffnet' );
		$gl_oVars->cTpl->assign( 'msg_text', 	'Das Turnier wurde eröffnet.' );
		
	}
	else if( $_GET['a'] == 'reset')
	{
		$cCup->DeleteEncounts( $iCupId );
		
		# set match as started
		$obj = NULL;
		$obj->finished = 0;
		$obj->encounts_created = 0;
		$cCup->SetCupData( $obj, $iCupId );		
		
		$gl_oVars->cTpl->assign( 'success', 	true );
		$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
		$gl_oVars->cTpl->assign( 'msg_title', 	'Turnier resettet' );
		$gl_oVars->cTpl->assign( 'msg_text', 	'Das Turnier wurde resettet.' );

			
	}

	

	if( $oCup->max_participants > 0 )
		$efficiency				= round( (($oCup->num_participants/$oCup->max_participants)*100), 1);
	
	$gl_oVars->cTpl->assign( 'adminlist', $aCupAdministrator );
	$gl_oVars->cTpl->assign( 'cupadministrator', $aCupAdministrator );	$gl_oVars->cTpl->assign ( 'cup',	$oCup );
	$gl_oVars->cTpl->assign ( 'game',	$oGame );
	$gl_oVars->cTpl->assign ( 'efficiency',	$efficiency );
?>