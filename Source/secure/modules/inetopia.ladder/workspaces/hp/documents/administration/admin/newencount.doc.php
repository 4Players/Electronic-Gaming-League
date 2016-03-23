<?php

	global $gl_oVars;

	# fetch url data
	$iLadderId	= (int)$_GET['ladder_id'];
	$iGameId = (int)$_GET['game_id'];
	
	
	# classes & objects
	$cLadderSystem	= new InetopiaLadder( $gl_oVars->cDBInterface );
	$cGamePool = new GamePool( $gl_oVars->cDBInterface );
	$cMatchStructures = new MatchStructures( $gl_oVars->cDBInterface );
	$cMatch = new Match( $gl_oVars->cDBInterface );

	
	# fetch ladderdata
	$oLadder = $cLadderSystem->GetLadderbyID( $iLadderId );
	$oGame = $cGamePool->GetGameById( $oLadder->game_id );
	$oMatchStructure = $cMatchStructures->GetMatchStructure( $oLadder->matchstructure_id );
	
	
	# ---------------------------------------------------------------------------------
	# CREATE
	# ---------------------------------------------------------------------------------
	if( $_GET['a'] == 'create' )
	{
		$bParticipantsExists = true;
		
		// check missing
		if( $bParticipantsExists )
		{
			if( $oMatchStructure )
			{
				$challenge_time = 0;
				list ($day, $month, $year) = explode('.', $_POST['challenge_time_date']); 
				list ($hour, $min) = explode(':', $_POST['challenge_time_clock']); 
				
		
				# set unix timestamp
				$challenge_time	= mktime( $hour, $min, 0, $month, $day, $year );			
				
				$_MAPS_ 	= "";
				$_NUM_MAPS_ = 0;
	
				# manual input
				if( strlen($_POST['map1']) > 0 || strlen($_POST['map2']) > 0 )
				{
					# evaulate DOUBLE-MAP-CHALLENGE 
					if( $_POST['challenge_type'] == CHALLENGETYPE_DOUBLE_MAP )
					{
						$_MAPS_		= $_POST['map1'].','.$_POST['map2'];
						$_NUM_MAPS_ = 2;
					}
					# evaulate DOUBLE-MAP-CHALLENGE 
					elseif( $_POST['challenge_type']  == CHALLENGETYPE_SINGLE_MAP )
					{
						$_MAPS_		= $_POST['map1'];
						$_NUM_MAPS_ = 1;
					}
					# evaulate DOUBLE-MAP-CHALLENGE 
					elseif(  $_POST['challenge_type']  == CHALLENGETYPE_RANDOM_MAP )
					{
						// currently not exists
					}
					else
					{
						// what the shit?
						
						# use 815 match structure
						$_MAPS_ = $oMatchStructure->maps;
						$_NUM_MAPS_ = $oMatchStructure->num_maps;
					}
				}
				else
				{
					# use match structure
					$_MAPS_ = $oMatchStructure->maps;
					$_NUM_MAPS_ = $oMatchStructure->num_maps;
				}
				
				
				# define match object
				$obj_match = array( 	'module_id'			=> MODULEID_INETOPIA_LADDER,
										'module_entry_id'	=> $oLadder->id,
										'participant_type'	=> $oLadder->participant_type,
										'matchstructure_id'	=> $oMatchStructure->id,
										'status'			=> MATCH_RUNNING,
										'num_rounds'		=> $oMatchStructure->num_rounds,	
										'round_names'		=> $oMatchStructure->round_names,	
										'maps'				=> $_MAPS_,
										'num_maps'			=> $_NUM_MAPS_,
										'challenge_time'	=> $challenge_time,
										'challenger_id'		=> $_POST['challenger_id'],
										'opponent_id'		=> $_POST['opponent_id'],
										'created'			=> EGL_TIME
									);
				# set default match-id
				$iMatchId = EGL_NO_ID;
				
				# try creating match, getting match-id, created
				if( $cMatch->AddMatch( $obj_match ) )
				{
					$iMatchId = $gl_oVars->cDBInterface->InsertId();
					
					# define match object
					$obj_encount = array( 	'ladder_id'	=> $oLadder->id,
											'match_id'	=> $iMatchId,
											'created'	=> EGL_TIME
										);
	
					# first $iMatchId check => create encount
					if( $iMatchId && $cLadderSystem->CreateEncount( $obj_encount ) )
					{
						$gl_oVars->cTpl->assign ( 'success',	true );
						
						$gl_oVars->cTpl->assign ( 'msg_type',	'success' );
						$gl_oVars->cTpl->assign ( 'msg_title',	'Begegnung erstellt' );
						$gl_oVars->cTpl->assign ( 'msg_text',	'Die Begegnung wurde vom System erfolgreich übernommen.' );
					}
					else
					{
						$gl_oVars->cTpl->assign ( 'msg_type',	'error' );
						$gl_oVars->cTpl->assign ( 'msg_title',	'Fehler' );
						$gl_oVars->cTpl->assign ( 'msg_text',	'Die Begegnung wurde nicht vollständig eingetragen. Bitte entnehmen Sie weitere Informationen aus den Build-Protokollen.' );
					}
					
				}
				else
				{
					$gl_oVars->cTpl->assign ( 'msg_type',	'error' );
					$gl_oVars->cTpl->assign ( 'msg_title',	'Fehler' );
					$gl_oVars->cTpl->assign ( 'msg_text',	'Das Match konnte nicht erstellt werden. Bitte entnehmen Sie weitere Informationen aus den Build-Protokollen.' );
				}
									
			}
			else
			{
				$gl_oVars->cTpl->assign ( 'msg_type',	'error' );
				$gl_oVars->cTpl->assign ( 'msg_title',	'Fehler' );
				$gl_oVars->cTpl->assign ( 'msg_text',	'Es ist ein Fehler aufgetreten - Es muss eine gültige Match Struktur in den Ladder-Konfigurationen ausgewählt sein.' );
			}	
		}
		else
		{
			# member doesn't exists
			
			
			
		}
		
	}//if
	
	# provide template with data
	$gl_oVars->cTpl->assign( 'ladder', 	$oLadder );
	$gl_oVars->cTpl->assign( 'game', $oGame );
	if($oMatchStructure)$gl_oVars->cTpl->assign( 'matchstructure', $oMatchStructure );
?>