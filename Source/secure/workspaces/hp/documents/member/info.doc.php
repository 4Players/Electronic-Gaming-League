<?php
	global $gl_oVars;

	
	$cCountry		= new Country( $gl_oVars->cDBInterface );
	$cGamePool 		= new GamePool( $gl_oVars->cDBInterface );
	$cGameAccount	= new GameAccounts( $gl_oVars->cDBInterface );
	$cAdministrator = new Administrator( $gl_oVars->cDBInterface );

	# ------------------------------------
	# GetMemberdata
	# ------------------------------------
	
			
	$oMemberDetails		= NULL;
	//$member_details_id 	= -1;
	$member_details_id 	= (int)$_GET['member_id'];
	$bMemberBanned		= false;
	
	if( !$member_details_id  )
	{
	}
	else
	{
		# try to catch data
		/*if( $member_details_id == $gl_oVars->oMemberData->id ) 
			$oMemberDetails = $gl_oVars->oMemberData;
		else*/
		
		$oMemberDetails = $gl_oVars->cMember->GetMemberDataById( $member_details_id );
	
		/*********************
		* CHECK STATUS
		* 	=> SET FREE
		**********************/
		if( $gl_oVars->cMember->RefreshBanStatus( $oMemberDetails ) ){
			$oMemberDetails = $gl_oVars->cMember->GetMemberDataById( $member_details_id );
		}
		
		
		
		# failed ?
		if( !$oMemberDetails)
		{
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			//$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
			$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4332'] );
		}
		else
		{
			# ----------
			# Member found
			# ----------
			
			$aMemberGames = $cGamePool->GetGameList( $oMemberDetails->games );
			$gl_oVars->cTpl->assign( 'member_games',  $aMemberGames);

			$oAdmin = $cAdministrator->GetAdminByMemberId($member_details_id);
			$gl_oVars->cTpl->assign( 'administrator', $oAdmin );
			

			# save profil data into tpl vars
			#$gl_oVars->cTpl->assign( 'member_details',  SetNoInputString( ConvertXArrayObjectArray($oMemberDetails), '<i>Keine Angaben</i>' ) );
			$gl_oVars->cTpl->assign( 'member_details',  $oMemberDetails );
			
			
			# set checked pubkeys
			$aPubKeys = db_read_array_string( $oMemberDetails->profil_public_key );
			$oMemberDetails->publickeys = array();
			for( $ipk=0; $ipk < sizeof($aPubKeys); $ipk++ )
			{
				$oMemberDetails->publickeys[$aPubKeys[$ipk]] = true;
				
				# set template pubkey as checked
				$gl_oVars->cTpl->assign( 'is_pubkey_'.$aPubKeys[$ipk].'', true );	# yes / no 
			}
			
		}// if member found
	}// if correct ?
	
	
	if( $oMemberDetails )
	{
		
			
		# check => member banned?
		if( $oMemberDetails->banned && 
			(int)$oMemberDetails->ban_start != 0 && (int)$oMemberDetails->ban_end != 0 )
		{
			$bMemberBanned = true;
			
			# compute ban data
			$ban_time = $oMemberDetails->ban_end-$oMemberDetails->ban_start;
			$expire_time = $oMemberDetails->ban_end-EGL_TIME;
	
			
			
			
			# provide templates with data
			$gl_oVars->cTpl->assign( "ban_time", ComputeTimeIntervalFromSeconds($ban_time) );
			$gl_oVars->cTpl->assign( "expire_time", ComputeTimeIntervalFromSeconds($expire_time) );

			$gl_oVars->cTpl->assign( "MEMBER_BANNED", true );
		}//if		
			
	
		# -----------------------------
		# member found ?=
		# -----------------------------
		//if( $oMemberDetails )
		//{
		$cClan = new Clan( $gl_oVars->cDBInterface );
		$cTeam = new Team( $gl_oVars->cDBInterface );
		
		$cClan->SetId($member_details_id);
		$cTeam->SetId($member_details_id);
		
		$cClan->FillBuffers();
		$cTeam->FillBuffers();
	
		# get clan 
		$aMemberClans  = $cClan->GetAccounts();
		$oMemberTeams = $cTeam->GetAccounts();
		
		
		$gl_oVars->cTpl->assign( 'member_clans', $aMemberClans );
		$gl_oVars->cTpl->assign( 'member_teams', $oMemberTeams );
		
		
		$gl_oVars->cTpl->assign( 'countries', $cCountry->GetCountries());
		$gl_oVars->cTpl->assign( 'gameaccounts', $cGameAccount->GetGameAccountsOfMember( $oMemberDetails->id));
		
	} //if
?>