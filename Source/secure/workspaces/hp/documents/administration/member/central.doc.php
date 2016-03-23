<?php
	global $gl_oVars;
	
	# declare classes
	$cMemberHistory	= new MemberHistory( $gl_oVars->cDBInterface );
	$cPM = new PM( $gl_oVars->cDBInterface );
	$cOnlineList = new OnlineList( $gl_oVars->cDBInterface );
	$cLogin = new Login( $gl_oVars->cDBInterface );
	$cTeam = new Team( $gl_oVars->cDBInterface );
	$cClan = new Clan( $gl_oVars->cDBInterface );
	

	# update onlinelist
	$cLogin->UpdateOnlineList();

	
	$bMemberBanned	= false;
	$iMemberId		= (int)$_GET['member_id'];

	// configure team/clans
	$cClan->SetId($iMemberId);
	$cTeam->SetId($iMemberId);
		
	$cClan->FillBuffers();
	$cTeam->FillBuffers();
	
			
	# fetch memberdata
	$oMemberData 	= $gl_oVars->cMember->GetMemberDataById( $iMemberId );

	# get clan/team
	$aMemberClans  	= $cClan->GetAccounts();
	$aMemberTeams 	= $cTeam->GetAccounts();
	
	
	# check => member banned?
	if( $oMemberData->banned && 
		(int)$oMemberData->ban_start != 0 && (int)$oMemberData->ban_end != 0 )
	{
		if( $gl_oVars->cMember->RefreshBanStatus( $oMemberData ) ){
			$oMemberData = $gl_oVars->cMember->GetMemberDataById( $iMemberId );
			$bMemberBanned = false;
		}else{
			
			$bMemberBanned = true;
			
			# compute ban data
			$ban_time = $oMemberData->ban_end-$oMemberData->ban_start;
			$expire_time = $oMemberData->ban_end-EGL_TIME;
	
	
			# provide templates with data
			
			$gl_oVars->cTpl->assign( "ban_time", ComputeTimeIntervalFromSeconds($ban_time) );
			$gl_oVars->cTpl->assign( "expire_time", ComputeTimeIntervalFromSeconds($expire_time) );
		}//if
	}//if
	
	
	$cpt = new PermissionTree();
	$tpt = new PermissionTree();

	$cpt->SetPermissionFile( EGLFILE_PERMISSIONTREE );
	$tpt->SetPermissionFile( EGLFILE_PERMISSIONTREE );

	$cpt->CreateTree( 'clan');		# read clan permission-tree
	$tpt->CreateTree( 'team');		# read clan permission-tree

	$aCPL = $cpt->GetConstNameArray(); # receive a list of all permissions
	$aTPL = $tpt->GetConstNameArray(); # receive a list of all permissions
		
	$gl_oVars->cTpl->assign( 'cpl', $aCPL );		#cpl => Clan Permission List
	$gl_oVars->cTpl->assign( 'tpl', $aTPL );		#cpl => Clan Permission List
	
	
	
	$gl_oVars->cTpl->assign( 'member_clans', 	$aMemberClans );		#cpl => Clan Permission List
	$gl_oVars->cTpl->assign( 'member_teams', 	$aMemberTeams );		#cpl => Clan Permission List

		
	
	########################################################################################
	# BAN MEMBER
	########################################################################################
	if( $_GET['a'] == "ban:deactivate" )
	{
		if( $bMemberBanned )
		{
			$obj = NULL;
			$obj->ban_start = 0;
			$obj->ban_end 	= 0;
			$obj->banned	= 0;
			
			# change memebrdata
			if( $gl_oVars->cMember->SetMemberDataById( $obj, $iMemberId ) )
			{
				$gl_oVars->cTpl->assign( "success", true );
				
				$gl_oVars->cTpl->assign( "msg_type", 	"success" );
				$gl_oVars->cTpl->assign( "msg_title", 	"Sperre aufgehoben" );
				$gl_oVars->cTpl->assign( "msg_text", 	"Die Sperre wurde erfolgreich aufgehoben" );
			}//if
			else
			{
			}
		
		}//if	
	}//if
	elseif( $_GET['a'] == "ban:activate" )
	{
		if( !$bMemberBanned )
		{
			$obj = NULL;
			if( $_POST['starttime_type'] == 'directly' ) $obj->ban_start = EGL_TIME;
			if( $_POST['starttime_type'] == 'point' ) $obj->ban_start = (ConstrueStrDate( $_POST['ban_start_date'], $_POST['ban_start_time'])  );
			$obj->ban_end 	= 0;
			$obj->banned	= 1;
			
			if( $_POST['endtime_type'] == 'period' )
			{
				$seconds = 0;
				$seconds += $_POST['ban_days']*24*3600;
				$seconds += $_POST['ban_hours']*3600;
				$seconds += $_POST['ban_minutes']*60;
				
				$obj->ban_end = EGL_TIME+$seconds;
			}
			elseif( $_POST['endtime_type'] == 'point' )
			{
				$obj->ban_end 	= (ConstrueStrDate( $_POST['ban_end_date'], $_POST['ban_end_time'])  );
			}
			else
			{
				$obj->ban_start = 0;
				$obj->ban_end 	= 0;
				$obj->banned	= 0;
			}//if
			
			
			# bantime correct?
			if( ($obj->ban_start < EGL_TIME || $obj->ban_end < EGL_TIME) ||
				($obj->ban_start > $obj->ban_end) )
			{
				$gl_oVars->cTpl->assign( "msg_type", 	"error" );
				$gl_oVars->cTpl->assign( "msg_title", 	"Fehler" );
				$gl_oVars->cTpl->assign( "msg_text", 	"Die Sperre kann nicht rückwirkend gesetzt werden." );
			}
			else
			{
				# change memebrdata
				if( $gl_oVars->cMember->SetMemberDataById( $obj, $iMemberId ) )
				{
					if( $_POST['add_history'] == "yes" )
					{
						
						$aExpire = ComputeTimeIntervalFromSeconds($obj->ban_end-$obj->ban_start);
						$cMemberHistory->AddHistoryEntry( array( "member_id" 	=> $iMemberId,
																 "message" 		=> "Member locked for {$aExpire['days']} days {$aExpire['hours']} hours {$aExpire['mins']} mins",
																 "created" 		=> EGL_TIME )
														 );
					}//if									 
					/*
						ACHTUNG: das muss erst beim Mitglied abgefragt werden, welche Sprache er bei sich eingestellt hat
					*/
					
					if( $_POST['send_email'] == 'yes' )
					{
						$cMail = new Mails( 'de' );
						$cMail->Assign( "nick_name", $oMemberData->nick_name );
						$cMail->Assign( "expire_time", $obj->ban_end-EGL_TIME );
						$cMail->Assign( "ban_end", $obj->ban_end );
						$cMail->Assign( "ban_start", $obj->ban_start );
						
						
						/*$email_header = new egl_email_header_t;
						$cMail->SetSenderMail( $email_header->root_admin, $email_header );
						*/
						
						# check & try sending email
						if( !$cMail->SendeMail( 'ban_member.tpl', "Account wurde gesperrt", $oMemberData->email ) )
						{
							#success
						}//if
					}//if
					
					$gl_oVars->cTpl->assign( "success", true );
					
					$gl_oVars->cTpl->assign( "msg_type", 	"success" );
					$gl_oVars->cTpl->assign( "msg_title", 	"Sperre gesetzt" );
					$gl_oVars->cTpl->assign( "msg_text", 	"Die Sperre wurde erfolgreich gesetzt" );
				}//if
				else
				{
				}//if
			}//if
			
		}//if
	}
	else
	{
	}

	
	
	########################################################################################
	# SEND MESSAGE
	########################################################################################
	if( $_GET['a']	== "mail:send" )
	{
		if( $_POST['mail_type'] == "pm" )
		{
			// create message
			if( $cPM->CreateMessage( array( "member_id" 	=> $iMemberId,
											"sender_id"	 	=> -1,
											"receiver_id" 	=> $iMemberId,
											"title" 		=> "Administrator Message",
											"text" 			=> $_POST['mail_message'],
											"created" 		=> EGL_TIME )
									) )
			{
					$gl_oVars->cTpl->assign( "success", true );
					
					$gl_oVars->cTpl->assign( "msg_type", 	"success" );
					$gl_oVars->cTpl->assign( "msg_title", 	"PM geschickt" );
					$gl_oVars->cTpl->assign( "msg_text", 	"Eine PM wurde erfolgreich verschickt." );
			}//if
			
			
		}//if
		else if( $_POST['mail_type'] == "email" )
		{
				
			$cMails = new Mails( $gl_oVars->sLanguage );
			
			$mail_store = new egl_email_header_t();
			$cMails->SetSenderMail( $mail_store->no_response, $mail_store->sender_name );
			
			
			$result = $cMails->SendMail( $oMemberData->email, "Administrator Nachricht", $_POST['mail_message'] );
			if( $result )
			{
				$gl_oVars->cTpl->assign( 'success', true );
				
				$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
				$gl_oVars->cTpl->assign( 'msg_text', 	'Die E-Mail wurde erfolgreich verschickt!' );
			}
			else
			{
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign( 'msg_text', 	'Die E-Mail konnt nicht gesendet werden. Sollte dieser Fehler erneut auftreten, wenden Sie sich bitte an die zuständigen Administratoren.' );
			}
		
		}//if
	}//if
	
	
	
	if( $bMemberBanned )$gl_oVars->cTpl->assign( "MEMBER_BANNED", $bMemberBanned );
	$gl_oVars->cTpl->assign( "member_data", $oMemberData );
	$gl_oVars->cTpl->assign( "historylist", $cMemberHistory->GetHistoryList( $iMemberId, 0, 15 ) );
	$gl_oVars->cTpl->assign( "online_state", $cOnlineList->GetMemberOnlineState($iMemberId) );


?>