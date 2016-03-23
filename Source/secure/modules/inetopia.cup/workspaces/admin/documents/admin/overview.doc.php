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
				$gl_oVars->cTpl->assign( 'msg_text', 	'Der Turnierbaum konnte nicht erstellt werden - \'{'.$result.'\'.' );
				
				
				PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPag.'&cup_id='.$oCup->id  );
			}
			else
			{
				# set match as started
				$obj = array( 	'encounts_created'			=> 1,
							);
				$cCup->SetCupData( $obj, $iCupId );
				
				
				$gl_oVars->cTpl->assign( 'success', 	true );
				$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
				$gl_oVars->cTpl->assign( 'msg_text', 	'Der Turnierbaum wurde erfolgreich erstellt.' );
				
				PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPage.'&cup_id='.$oCup->id  );
			}//if
		}//if
		
	}//if
	else if( $_GET['a'] == 'finish')
	{
		# set match as started
		$obj = NULL;
		$obj = array( 	'finished'			=> 1,
					);
		$cCup->SetCupData( $obj, $iCupId );
				
		$gl_oVars->cTpl->assign( 'success', 	true );
		$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
		$gl_oVars->cTpl->assign( 'msg_text', 	'Das Turnier wurde beendet.' );
		
		PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPage.'&cup_id='.$oCup->id  );
	}
	else if( $_GET['a'] == 'open')
	{
		# set match as started
		$obj = array( 	'finished'			=> 0,
					);
		$cCup->SetCupData( $obj, $iCupId );		
		
		$gl_oVars->cTpl->assign( 'success', 	true );
		$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
		$gl_oVars->cTpl->assign( 'msg_text', 	'Das Turnier wurde eröffnet.' );
	
		PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPage.'&cup_id='.$oCup->id  );
		
	}
	else if( $_GET['a'] == 'reset')
	{
		$cCup->DeleteEncounts( $iCupId );
		
		# set match as started
		$obj = array( 	'finished'			=> 0,
						'encounts_created'	=> 0,
					);
		$cCup->SetCupData( $obj, $iCupId );		
		
		$gl_oVars->cTpl->assign( 'success', 	true );
		$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
		$gl_oVars->cTpl->assign( 'msg_text', 	'Das Turnier wurde resettet.' );

		PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPage.'&cup_id='.$oCup->id  );
			
	}
	if( $oCup->max_participants > 0 )
		$efficiency				= round( (($oCup->num_participants/$oCup->max_participants)*100), 1);
	
	$gl_oVars->cTpl->assign( 'adminlist', $aCupAdministrator );
	$gl_oVars->cTpl->assign( 'cupadministrator', $aCupAdministrator );	$gl_oVars->cTpl->assign ( 'cup',	$oCup );
	$gl_oVars->cTpl->assign ( 'game',	$oGame );
	$gl_oVars->cTpl->assign ( 'efficiency',	$efficiency );
?>