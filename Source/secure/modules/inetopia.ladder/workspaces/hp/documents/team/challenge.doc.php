<?php
	global $gl_oVars;

	$iTeamId		= (int)$_GET['team_id'];
	$iProcessId		= (int)$_GET['process'];
	$iLadderId		= 0;
	$iLadderpartId	= (int)$_GET['ladderpart_id']; 
	
	
	# class declares
	$cLadderSystem		= new InetopiaLadder( $gl_oVars->cDBInterface );
	$cTeam				= new Team( $gl_oVars->cDBInterface );
	$cMatchStructures 	= new MatchStructures( $gl_oVars->cDBInterface );
	$cMapCollections 	= new MapCollections( $gl_oVars->cDBInterface );

	
	# get :: GetLadderParticipantbyId
	$oOpponent = $cLadderSystem->GetLadderParticipantbyId( PARTTYPE_TEAM, (int)$iLadderpartId );
	$oLadder = $cLadderSystem->GetLadderbyID( (int)$oOpponent->ladder_id );
	$iLadderId = $oOpponent->ladder_id;
	$oMatchStructure = 	$cMatchStructures->GetMatchStructure( $oLadder->matchstructure_id );
	
	# map-collection selected?
	$aMaps = array();
	if( $oMatchStructure->mapcollection_id > 0 )
		$aMaps = $cMapCollections->GetCollectionMaps(  $oMatchStructure->mapcollection_id );
		
		
	# check: i'am in that team??
	if( sizeof($cTeam->TeamSelfTest( (int)$gl_oVars->iMemberId, (int)$oOpponent->participant_id)) )
	{
		$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
		$gl_oVars->cTpl->assign( 'msg_title',	$gl_oVars->aLngBuffer['basic']['c1204']  );
		$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c9500'] );
		
		
		$gl_oVars->cTpl->assign( 'SCREEN_LOCKED',	true );
		return 1;
	}
	# check: team joined that ladder?
	/*
	Konnte nicht über eine Callback funktion erledig werden:
	(1) gc-file : team.challenge = team.orga,team.squad_leader
				Wenn hier team.orga,team.squad_leader als callback benutzt werden, werden weitere einstellungen nicht mehr unterstützt, falls der Admin dies ändern möchte
		Ausweg:
		Und-Verknüpfung: d.h.: page_name = recht & callback.func
			ab v0.9
	*/
	elseif( !$cLadderSystem->IsEnteredLadder($oOpponent->ladder_id, $iTeamId))
	{
		$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
		$gl_oVars->cTpl->assign( 'msg_title',	$gl_oVars->aLngBuffer['basic']['c1204']  );
		$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c9503'] );
		
		
		$gl_oVars->cTpl->assign( 'SCREEN_LOCKED',	true );
	}
	else
	{
		$gl_oVars->cTpl->assign ( 'opponent', $oOpponent );
		$gl_oVars->cTpl->assign ( 'ladder', $oLadder );	

	
		#----------------------------------------------------------------------------
		# Select Mode
		# Prozess-ID [0]->1
		#----------------------------------------------------------------------------
		if( $iProcessId == 0 )
		{
		}
		#----------------------------------------------------------------------------
		# Select Map
		# Prozess-ID [1]->2
		#----------------------------------------------------------------------------
		else if( $iProcessId == 1 )
		{
			$challenge_type = "";
			if( isset($_POST['ctype']))$challenge_type = $_POST['ctype'];
			if( isset($_GET['ctype']))$challenge_type = $_GET['ctype'];
			
			$gl_oVars->cTpl->assign( "challenge_type", $challenge_type );
	
			$map1 = "";
			if( isset($_POST['map1']))$map1 = $_POST['map1'];
			if( isset($_GET['map1']))$map1 = $_GET['map1'];
			
			$gl_oVars->cTpl->assign( "map1", $map1 );
		}
		
		#----------------------------------------------------------------------------
		# send off challenge [date]
		# Prozess-ID [2]->3
		#----------------------------------------------------------------------------
		else if( $iProcessId == 2 )
		{
			$challenge_type = "";
			if( isset($_POST['ctype']))$challenge_type = $_POST['ctype'];
			if( isset($_GET['ctype']))$challenge_type = $_GET['ctype'];
			
			$map1 = "";
			if( isset($_POST['map1']))$map1 = $_POST['map1'];
			if( isset($_GET['map1']))$map1 = $_GET['map1'];
			
			$gl_oVars->cTpl->assign( "map1", $map1 );
			$gl_oVars->cTpl->assign( "challenge_type", $challenge_type );
		}
		
		#----------------------------------------------------------------------------
		# Create challenge!
		# Prozess-ID [2]->3
		#----------------------------------------------------------------------------	
		else if( $iProcessId == 3 )
		{
			$oChallenger = $cTeam->GetTeam( $iTeamId );

			/*
			# CHECK MEMBER DETAILS
			if( $oOpponent->banned )
			{
			}*/
			
			# set date / clock
			list ($day, $month, $year) = explode('.', $_POST['challenge_date']); 
			list ($hour, $min) = explode(':', $_POST['challenge_time']); 
			
			
			# set unix timestamp
			$challenge_type = $_GET['ctype'];
			$challenge_time = mktime( $hour, $min, 0, $month, $day, $year );
			
			if( $_GET['ctype'] == 'singlemap' ) $challenge_type = CHALLENGETYPE_SINGLE_MAP;
			elseif( $_GET['ctype'] == 'doublemap' ) $challenge_type = CHALLENGETYPE_DOUBLE_MAP;
			elseif( $_GET['ctype'] == 'randommap' ) $challenge_type = CHALLENGETYPE_RANDOM_MAP;
			/**************
			ATTENTION:
			
			type of $oOpponent != type of $oChallenger
			****************/
			
			if( $oLadder->challenge_types & $challenge_type )
			{
				$obj_challenge = array( 'ladder_id'			=> $oOpponent->ladder_id,			/* ladder-id */
										'challenger_id' 	=> $oChallenger->id,			/* challenger team-id */
										'opponent_id'		=> $oOpponent->participant_id,	/* opponent team-id */
										'react_id' 			=> $oOpponent->participant_id,
										'challenge_type' 	=> $challenge_type,
										'challenge_time' 	=> $challenge_time,
										'state'				=> CHALLENGESTATE_CHALLENGING,
										'created' 			=> EGL_TIME,
										'map1' 				=> $_GET['map1'],
									  );
										 								
				# try creating challenge
				$iChallengeId = EGL_NO_ID;
				if( !($iChallengeId=$cLadderSystem->CreateChallenge( $obj_challenge )) ) DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, 'Error occured by creating challenge data Ladder::CreateChallenge' );
				else
				{
					$gl_oVars->cTpl->assign( 'success', true );	
					
					$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
					$gl_oVars->cTpl->assign( 'msg_title',	$gl_oVars->aLngBuffer['basic']['c1207']  );
					$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c9501'] );
					
					
					//$oChallenger	= $gl_oVars->oMemberData;
					
					// create E-Mail
					$mailtpl_root = ModuleManager::GetModuleRootByParam( $gl_oVars, $gl_oVars->sModuleId ).'templates'.EGL_DIRSEP.'emails'.EGL_DIRSEP.$gl_oVars->sLanguage.EGL_DIRSEP;
					$mails = new Mails( $gl_oVars->sLanguage, $mailtpl_root );
					$mails->IsHTML(false);		# set als HTML
					
					# register variables
					$mails->Assign( 'opponent_time', 		$oOpponent->participant_name );
					$mails->Assign( 'challenger_name', 		$oChallenger->name	);
					$mails->Assign( 'challenger_id', 		$oChallenger->id );
					$mails->Assign( 'challenge_time', 		$challenge_time );
					
					$mails->Assign( 'ladder_name', 			$oLadder->name );
					
					$email_header = new egl_email_header_t;
					$mails->SetSenderMail( $email_header->no_response, $email_header->sender_name );
				
					
					$aTeamLeader = array();
					//$aTeamLeader = getteamleader..
					
					for( $i=0; $i < sizeof($aTeamLeader); $i++ )
					{
						# try sending email
						if( !$mails->SendeMail( 'team_challenge.tpl', $gl_oVars->aLngBuffer['module']['c1100'], $aTeamLeader[$i]->email/*receiver E-Mail*/ ) )
						{
							DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, 	"Couldn't send E-Mail on InetopiaLadder::Chalenge to . `".$aTeamLeader[$i]->email."` ERROR: ".$mails->GetLastError() );
						}
						else
						{
						}
					}//for
					PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sModuleId.':team.challengedetails&challenge_id='.$iChallengeId.'&team_id='.$iTeamId );
					
					
				}
			}
			else
			{
				# challenge-type not supported
			}
		}//if
	}//if owm-challenge?
		
	
	$gl_oVars->cTpl->assign( "PROCESS", $iProcessId );
	if( sizeof($aMaps) > 0 )$gl_oVars->cTpl->assign( 'MAPS', $aMaps );
?>