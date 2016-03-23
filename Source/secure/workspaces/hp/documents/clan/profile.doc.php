<?php
	global $gl_oVars;
	
	$iClanId	= (int)$_GET['clan_id'];

	$cCountry 	= new Country( $gl_oVars->cDBInterface );
	$cClan 		= new Clan( $gl_oVars->cDBInterface );

	# convert memberobbject to array object containing the member data
	$oClan = $gl_oVars->cMember->GetClanAccount( $iClanId );
	
	
	# containing all errors
	$aErrors = array();
	
	# action => save
	if( $oClan )
	if( $_GET['a'] == 'change_profil' )
	{
		$bError = false;
		
		$obj_clan = array( 	//'name'					=> $_POST['name'],
							'tag'					=> $_POST['tag'],
							//'join_password'		=> md5( $_POST['join_password'] ),
							'hp'					=> $_POST['hp'],
							'country_id'			=> $_POST['country_id'],
							'irc'					=> $_POST['irc'],
							'description'			=> $_POST['description'],
							'display_player_logo'	=> $_POST['display_player_logo'],
							'display_team_details'	=> $_POST['display_team_details']
					);

					// change clan-name?
		if( $oClan->name != $_POST['name'] && strlen($_POST['name']) > 0 )
		{
			if( sizeof($cClan->GetClansByName($_POST['name'])) > 0 )
			{
				$bError = true;
	
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4792'] );
			}//if
			else
			{
				$obj_clan['name'] = $_POST['name'];
			}
		}//if

		// password too short?		
		if( strlen($_POST['join_password']) > 0 ){
			$obj_clan['join_password'] = md5( $_POST['join_password'] );
		}else{
			// kein error => passwort wird einfach nicht geändert/gesetzt
			//$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			//$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4793'] );
		}

		// change join password, if necessary
		if( !$bError )
		{
		
			# ---------------------------
			# run mysql update
			# ---------------------------
			# query failed ?
			if( !$cClan->SetClanData( $obj_clan, $iClanId ) )
			{
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4788'] );
			}
			else
			{
				#echo $aMemberData['id'];
				
				$gl_oVars->cTpl->assign( 'success', 	true );
				$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4789'] );
				
				PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLRealPage.'&clan_id='.$iClanId );
				
			}#$qre failed
		}
	}#$_GET['a'] == 'change_profil'
	
	
		
	#---------------------------------
	# Clan not found ? !!
	#---------------------------------
	if( !$oClan )
	{
		$gl_oVars->cTpl->assign( 'msg_type', 	'error' );		
		$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4790'] );
	}
	else
	{
		# finally set template array
		$gl_oVars->cTpl->assign( 'countries', $cCountry->GetCountries() );
		$gl_oVars->cTpl->assign( "clan", 	$oClan );
	}

?>