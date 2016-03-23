<?php
	global $gl_oVars;


	# var defines
	//$oClan 		= $gl_oVars->cMember->GetClanAccount( (int)$_GET['clan_id'] );
	$iTeamId	= (int)$_GET['team_id'];
	
	
	# define / declare classes/objects
	#--------------------------------------------
	$cTeam		= new Team( $gl_oVars->cDBInterface );
	$cCountry	= new Country( $gl_oVars->cDBInterface );
	
	
	# fetch data
	#--------------------------------------------
	$oTeam 			= $cTeam->GetTeam( $iTeamId );
	
	


	# containing all errors
	$aErrors = array();
	
	# action => save
	if( $oTeam )
	if( $_GET['a'] == 'change_profil' )
	{
		$bError = false;
		
		$obj_team = array( 	//'name'					=> $_POST['name'],
							'tag'					=> $_POST['tag'],
							//'join_password'			=> md5( $_POST['join_password'] ),
							'server'				=> $_POST['server'],
							'country_id'			=> $_POST['country_id'],
							'description'			=> $_POST['description'],
							'display_player_logo'	=> $_POST['display_player_logo']
					);
					
					
		if( $oTeam->name != $_POST['name'] && strlen($_POST['name']) > 0 )
		{
			if( sizeof($cTeam->GetTeamsByName($_POST['name'])) > 0 )
			{
				$bError = true;
	
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c5103'] );
			}//if
			else
			{
				$obj_team['name'] = $_POST['name'];
			}
		}//if
		
				
		// change join password, if necessary
		if( strlen($_POST['join_password']) > 0 ){
			$obj_team['join_password'] = md5( $_POST['join_password'] );
		}
				

		if( !$bError )
		{
			# ---------------------------
			# run mysql update
			# ---------------------------
			# query failed ?
			if( !$cTeam->SetTeamData( $obj_team, (int)$oTeam->id ) )
			{
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c5106'] );
			}
			else
			{
				
				$gl_oVars->cTpl->assign( 'success', 	true );
				$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c5104'] );
					
				PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPage.'&team_id='.$iTeamId );
					
			}#$qre failed
		}//if $bError
	}#$_GET['a'] == 'change_profil'
	
	
	
	#---------------------------------
	# Clan not found ? !!
	#---------------------------------
	if( !$oTeam )
	{
		$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c5105'] );
		$gl_oVars->cTpl->assign( 'msg_type', 	'error' );		
	}
	else
	{
	
	
		# finally set template array
	
		# save profil data into tpl vars
		$gl_oVars->cTpl->assign( "team", 	$oTeam );
		//$gl_oVars->cTpl->assign( 'clan',  	$oClan );
	
		# finally set template array
		$gl_oVars->cTpl->assign( 'countries', $cCountry->GetCountries() );
	}

?>