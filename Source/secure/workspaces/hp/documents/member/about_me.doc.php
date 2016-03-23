<?php
	global $gl_oVars;

	
	$cCountry		= new Country( $gl_oVars->cDBInterface );
	$cGamePool 		= new GamePool( $gl_oVars->cDBInterface );
	$cGameAccount	= new GameAccounts( $gl_oVars->cDBInterface );

	# ------------------------------------
	# GetMemberdata
	# ------------------------------------
	
			
	$oMemberDetails		= NULL;
	$member_details_id 	= -1;
	$member_details_id 	= (int)$_GET['member_id'];
	
	if( !$member_details_id  )
	{
	}
	else
	{
		# try to catch data
		if( $member_details_id == $gl_oVars->oMemberData->id ) $oMemberDetails = $gl_oVars->oMemberData;
		else $oMemberDetails = $gl_oVars->cMember->GetMemberDataById( $member_details_id );
		
		
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


			# save profil data into tpl vars
			#$gl_oVars->cTpl->assign( 'member_details',  SetNoInputString( ConvertXArrayObjectArray($oMemberDetails), '<i>Keine Angaben</i>' ) );
			$gl_oVars->cTpl->assign( 'member_details',  $oMemberDetails );
			
			
			# set checked pubkeys
			$aPubKeys = db_read_array_string( $oMemberDetails->profil_public_key );
			for( $ipk=0; $ipk < sizeof($aPubKeys); $ipk++ )
			{
				# set template pubkey as checked
				$gl_oVars->cTpl->assign( 'is_pubkey_'.$aPubKeys[$ipk].'', true );	# yes / no 
			}
			
		}// if member found
	}// if correct ?
	
	
	if( $oMemberDetails )
	{
		# create comment manage object for members
		$cComments = & new Comments( $gl_oVars->cDBInterface, $GLOBALS['g_egltb_member_comments'], "member_id" );
	
		#----------------------------------------------------
		# comment input detected ?
		#----------------------------------------------------
		if( Isset( $_POST['comment_text'] ) &&
			strlen($_POST['comment_text']) > 0 &&
			$gl_oVars->bLoggedIn )
		{
			$msg_obj = NULL;
			$msg_obj = array( 	"member_id"	=> $oMemberDetails->id,
								"author_id" => $gl_oVars->oMemberData->id,
								"text"		=> $_POST['comment_text'],
								"created"	=> EGL_TIME
							);
			# try to create obj
			if( $cComments->CreateComment($msg_obj) )
			{
				# successful
				PageNavigation::Location( $gl_oVars->sURLFile."?page=".$gl_oVars->sURLPage."&member_id=".$oMemberDetails->id."&comment=write#comment_write" );
			}
			
		}#/if

		$aMemberDetailComments	= NULL;
		$iMemberCommentCounter  = -1;
	
		# get comment buffer
		if( $_GET['comment'] == 'write' ||
			$_GET['comment'] == 'show' )
		{
			# try to catch the comments of current displayed member
			$aMemberDetailComments = $cComments->GetComments( $oMemberDetails->id );
			$iMemberCommentCounter = sizeof($aMemberDetailComments);
		}
		
		# counter already read, else => read
		if( $iMemberCommentCounter == -1 )
			$iMemberCommentCounter = $cComments->GetCommentsCount( $oMemberDetails->id );
			
		
		# save data as a var into template
		$gl_oVars->cTpl->assign( 'comments',		$aMemberDetailComments ); 
		$gl_oVars->cTpl->assign( 'comment_count', 	$iMemberCommentCounter );

		# ---------------------------------------------------------------------------------------- 

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
		
		//}
			
		# Send 'get_teaminfo_attachment' to all cmods
		$aCModAttachments = array();
		
		# get activated cMods, to receive attachments for teamdata
		$aCMods = $gl_oVars->cModuleManager->GetActivatedModules();
		
		
		# fetch attachments
		for( $mod=0; $mod < sizeof($aCMods); $mod++ )
		{
			$oAttResult = module_sendmessage( $aCMods[$mod]->ID, 'get_memberinfo_attachment', $__DATA__ );
			if( strlen($oAttResult)) $aCModAttachments[sizeof($aCModAttachments)] = $oAttResult;
			
		}//for
	
	
		/*
		# ----------------------------------------------------------------------------------------------------------		
		# mod attachments
		$gl_oVars->cTpl->assign( 'attachments',	$aCModAttachments );*/
		
		
		$gl_oVars->cTpl->assign( 'countries', $cCountry->GetCountries());
		$gl_oVars->cTpl->assign( 'gameaccounts', $cGameAccount->GetGameAccountsOfMember( $oMemberDetails->id));
		
		
		
			
		$gl_oVars->cTpl->assign( 'member_games', 		$cGamePool->GetGameList($oMemberDetails->games) );
		$gl_oVars->cTpl->assign( 'advanced_view', 		true );
		
	} //if
?>