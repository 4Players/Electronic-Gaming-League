<?php
	// EGL zugriffs-variable für Datenbank,Templatesystem..etc
	global $gl_oVars;
	
	
	// classes/objects
	$cLaddersystem = new InetopiaLadder( $gl_oVars->cDBInterface );

	$rank_text = array();	
	$name_text = array();	
	$ladder_text = array();	

	$rankbutton_cfg_file = ModuleManager::GetModuleRootByParam( $gl_oVars, $gl_oVars->sModuleId ).'rankbutton.cfg.php';
	if( file_exists( $rankbutton_cfg_file )){
		include( $rankbutton_cfg_file );
	}
	else{
		// setup default values
				
		$rank_text = array( 	'size'			=> 3,
								'color'			=> 0x000000,
								'x'				=> 305,
								'y'				=> 12,
								'hide'			=> 0,
								'rank_text'		=> '{RANK}.',
								'max_length'	=> 0,
						  );
						  
		// define rank-text
		$name_text = array( 	'size'			=> 1,
								'color'			=> 0xFFFFFF,
								'x'				=> 10,
								'y'				=> 3,
								'hide'			=> 0,
								'member_text'	=> '{MEMBER_NAME}: `{MEMBER_ID}`',
								'team_text'		=> '{CLAN_TAG}>{TEAM_NAME}: `{TEAM_ID}`',
								'max_length'	=> 55,
						  );
		
		// define ladder-text
		$ladder_text = array( 	'size'			=> 3,
								'color'			=> 0xFFFFFF,
								'x'				=> 10,	
								'y'				=> 12,
								'hide'			=> 0,
								'ladder_text'	=> '{GAME_TAG} {LADDER_NAME}',
								'max_length'	=> 40,
							);
			
		$image_source	= array( 'button_image'	=> 'rankbutton.png' );
	}

	
		
	$code          		= $_GET['code'];
	$ladder_id      	= (int)$_GET['ladder_id'];
	$participant_id 	= (int)$_GET['participant_id'];
	
	// fetch ladder-data
	$oLadder = $cLaddersystem->GetLadderByID( $ladder_id );
	
	// ladder data
	if( $oLadder )
	{
		/*
		// prüfe Zugriffscode
		$sql_query =  	" SELECT MD5(password+id) AS hash, id, nick_name AS hash ".
						" FROM `".$GLOBALS['egl_members']."` AS members ".
						" WHERE MD5(password+id)='".mysql_escape_string($code)."'";
		$oMember =  $gl_oVars->cDBInterface->FetchObject( $gl_oVars->cDBInterface->Query( $sql_query ) );
		if( !$oMember)
		{
			die( "NO ACCESS" );
		}//if member*/
		
		if( $oLadder->participant_type == PARTTYPE_MEMBER )
		{
			$sql_query =  	" SELECT members.id AS participant_id, members.nick_name AS participant_name, ladder.id AS ladder_id, ladder.name AS ladder_name, points, parts.participant_id  ".
			         		" FROM `".DBTB::GetTB('LADDER','LADDER_PARTICIPANTS')."` AS parts , `".DBTB::GetTB('LADDER','LADDERS')."` AS ladder ".
							" LEFT JOIN `".DBTB::GetTB('GLOBAL','EGL_MEMBERS')."` AS members ".
							" ON members.id=parts.participant_id ".
			         		" WHERE parts.ladder_id=ladder.id AND ladder_id=".(int)$ladder_id." ".
			         		" ORDER BY parts.points DESC, parts.created ASC "; 
			$aLadderParts =  $gl_oVars->cDBInterface->FetchArrayObject( $gl_oVars->cDBInterface->Query( $sql_query ) );
			$bOK 	= false;
			$oPART 	= NULL;
			$iRank	= 1;
			foreach( $aLadderParts as $__part ){
				if( $__part->participant_id == $participant_id ){
					$oPART = $__part;
					$bOK = true; break;
				}//if
				else{
					$iRank++;
				}
			}//foreach
		}
		else if( $oLadder->participant_type == PARTTYPE_TEAM )
		{
			$sql_query =  	" SELECT teams.clan_id AS participant_clan_id, clans.name AS participant_clan_name, clans.tag AS participant_clan_tag, teams.id AS participant_id, teams.name AS participant_name, teams.tag AS participant_tag, ladder.id AS ladder_id, ladder.name AS ladder_name, points, parts.participant_id  ".
			         		" FROM `".DBTB::GetTB('LADDER','LADDER_PARTICIPANTS')."` AS parts , `".DBTB::GetTB('LADDER','LADDERS')."` AS ladder ".
							" LEFT JOIN `".DBTB::GetTB('GLOBAL','EGL_TEAMS')."` AS teams ".
							" ON teams.id=parts.participant_id ".
							" LEFT JOIN `".DBTB::GetTB('GLOBAL','EGL_CLANS')."` AS clans ".
							" ON teams.clan_id=clans.id ".
			         		" WHERE parts.ladder_id=ladder.id AND ladder_id=".(int)$ladder_id." ".
			         		" ORDER BY parts.points DESC, parts.created ASC  "; 
			$aLadderParts =  $gl_oVars->cDBInterface->FetchArrayObject( $gl_oVars->cDBInterface->Query( $sql_query ) );
			$bOK 	= false;
			$oPART 	= NULL;
			$iRank	= 1;
			foreach( $aLadderParts as $__part ){
				if( $__part->participant_id == $participant_id ){
					$oPART = $__part;
					$bOK = true; break;
				}//if
				else{
					$iRank++;
				}
			}//foreach			
		}
		else
		{
		}

		header("Content-type: image/png");
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		
		

		$image_file = EGL_PUBLIC."images".EGL_DIRSEP.$image_source['button_image'];
		$pIMG    = imagecreatefrompng( $image_file );
		
	
		// generate rank-button
		if( $bOK )
		{
			if( $pIMG )
			{
	
				$rank_color 	= imagecolorallocate($pIMG, ($rank_text['color'] & 0xff0000) >> 16, ($rank_text['color'] & 0x00ff00) >> 8, ($rank_text['color'] & 0x0000ff) >> 0 );
				$name_color 	= imagecolorallocate($pIMG, ($name_text['color'] & 0xff0000) >> 16, ($name_text['color'] & 0x00ff00) >> 8, ($name_text['color'] & 0x0000ff) >> 0 );
				$ladder_color 	= imagecolorallocate($pIMG, ($ladder_text['color'] & 0xff0000) >> 16, ($ladder_text['color'] & 0x00ff00) >> 8, ($ladder_text['color'] & 0x0000ff) >> 0 );
					
				
				# -------------------------------------------------------------------------
				if( $rank_text['hide'] != true )
				{
					// draw rank
					$string	= $rank_text['rank_text']; //$iRank.'.';
					$string = str_replace( '{RANK}', $iRank, $string );
					
					if( (int)$rank_text['max_length'] > 0 && strlen($string) > (int)$rank_text['max_length'] ){
						$string = substr( $string, 0, (int)$rank_text['max_length'] );
					}
					
					imagestring($pIMG, $rank_text['size'], $rank_text['x'], $rank_text['y'], $string, $rank_color);
				}

				# -------------------------------------------------------------------------
				if( $name_text['hide'] != true )
				{
					// draw participant-name					
					$string	= $oPART->participant_name;
					if( $oLadder->participant_type == PARTTYPE_TEAM)
					{
						$string	= $name_text['team_text'];
						
						$string = str_replace( '{TEAM_NAME}', $oPART->participant_name, $string );
						$string = str_replace( '{TEAM_TAG}', $oPART->participant_tag, $string );
						$string = str_replace( '{TEAM_ID}', $oPART->participant_id, $string );
						
						if( $oPART->participant_clan_id != EGL_NO_ID  )
						{
							$string = str_replace( '{CLAN_NAME}', $oPART->participant_clan_name, $string );
							$string = str_replace( '{CLAN_TAG}', $oPART->participant_clan_tag, $string );
							$string = str_replace( '{CLAN_ID}', $oPART->participant_clan_id, $string );
						}
						else{
							$string = str_replace( '{CLAN_NAME}', '', $string );
							$string = str_replace( '{CLAN_TAG}', '', $string );
							$string = str_replace( '{CLAN_ID}', '', $string );
						}
					}
					elseif( $oLadder->participant_type == PARTTYPE_MEMBER )
					{
						$string	= $name_text['member_text'];
						$string = str_replace( '{MEMBER_NAME}', $oPART->participant_name, $string );
						$string = str_replace( '{MEMBER_ID}', $oPART->participant_id, $string );
					}
					
					// check length
					if( (int)$name_text['max_length'] > 0 && strlen($string) > (int)$name_text['max_length'] ){
						$string = substr( $string, 0, (int)$name_text['max_length'] );
					}
					
					imagestring($pIMG, $name_text['size'], $name_text['x'], $name_text['y'], $string, $name_color);
				}
					
				# -------------------------------------------------------------------------
				if( $ladder_text['hide'] != true )
				{
					// draw ladder-name					
					$string	= $ladder_text['ladder_text']; //$oLadder->game_token.'  '.$oLadder->name;
					
					$string = str_replace( '{LADDER_NAME}', $oLadder->name, $string );
					$string = str_replace( '{LADDER_ID}', $oLadder->id, $string );

					$string = str_replace( '{GAME_NAME}', $oLadder->game_name, $string );
					$string = str_replace( '{GAME_TAG}', $oLadder->game_token, $string );
					$string = str_replace( '{GAME_ID}', $oLadder->game_id, $string );
					
					if( (int)$ladder_text['max_length'] > 0 && strlen($string) > (int)$ladder_text['max_length'] ){
						$string = substr( $string, 0, (int)$ladder_text['max_length'] );
					}					
					imagestring($pIMG, $ladder_text['size'], $ladder_text['x'], $ladder_text['y'], $string, $ladder_color);
				}
				
					
			}
			//echo "gefunden $iRank";
		}//if
		
		imagepng($pIMG);
		imagedestroy($pIMG);
		
	}//if

?>