<?php
	global $gl_oVars;

	
	$iMatchId = (int)$_GET['match_id'];
	
	$cReports = new MatchReports( $gl_oVars->cDBInterface );
	$cMedia = new Media( $gl_oVars->cDBInterface );
	$cMatch = new Match( $gl_oVars->cDBInterface, $iMatchId );	
	$cMapCollections = new MapCollections( $gl_oVars->cDBInterface );
		
	
	/*
	Check permissons
		-> report_id != participant_id
		-> match not locked !!
	--------------
	
		*/


	/*
	Run Code
	--------------
	
	
	
		*/
		
	# read match data
	$oMatch 		= $cMatch->GetData();
	$pMyPart		= NULL;					# containg informations of myself as participant
	
	
	
	# check report state
		#> membner_type ?
			#> compare member ids
			
		#> team_type ?
			#> get team members
			#> compare team memberids with report id
			
	# ------------------------------------------------------------
	# Match starten
	# ------------------------------------------------------------
	if( $oMatch )
	{
		# Match bereits Beendet ?
		
	
		#----------------------------------------------------------------------------
		# Match = LOCKED ??
		#----------------------------------------------------------------------------
		if( $oMatch->status == MATCH_LOCKED )
		{
			$gl_oVars->cTpl->assign( 'msg_type',	'error' );
			$gl_oVars->cTpl->assign( 'msg_title',	'Fehler' );
			$gl_oVars->cTpl->assign( 'msg_text',	'Das Match wurde gesperrt und kann daher nicht reportet werden.' );
			return 0;
		}
		
		
		#----------------------------------------------------------------------------
		# Match = CLOSED ??
		#----------------------------------------------------------------------------
		else if( $oMatch->status == MATCH_CLOSED )
		{
			$gl_oVars->cTpl->assign( 'msg_type',	'error' );
			$gl_oVars->cTpl->assign( 'msg_title',	'Fehler' );
			$gl_oVars->cTpl->assign( 'msg_text',	'Das Match wurde beendet und kann daher nicht reportet werden.' );
			return 0;
		}
		#----------------------------------------------------------------------------
		# ELSE => RUN REPORT SCRIPT
		#----------------------------------------------------------------------------
		else 
		{

			
			# ------------------------------------------------------------------
			# ------------------------------------------------------------------
			# Fetch Participant-data
			# optmierung möglich [X]
			# ------------------------------------------------------------------
			# ------------------------------------------------------------------
			$aParticipants = array();
			$str_id_list = $oMatch->challenger_id.','.$oMatch->opponent_id;
			
	
			#~2
			#================================================================
			if( $oMatch->participant_type == PARTTYPE_MEMBER )
			{
				$aParticipants = $gl_oVars->cMember->__GetMemberListData( $str_id_list );
				$gl_oVars->cTpl->assign( 'parttype', 'member' );
			}
			#================================================================
			else if( $oMatch->participant_type == PARTTYPE_TEAM )
			{
				$aParticipants = $gl_oVars->cMember->GetClanlistData( $str_id_list );
				$gl_oVars->cTpl->assign( 'parttype', 'team' );
			}	
		
			# sort participants
			/*		ARRAY: 0 => challenger
					ARRAY: 1 => opponent 
			
			*/
			if( $aParticipants[0]->participant_id != $oMatch->challenger_id )
			{
				$temp = $aParticipants[0];
				$aParticipants[0] = $aParticipants[1];
				$aParticipants[1] = $temp;
			}
			
			
			
			
			#-----------------------------------------------------------------
			#-----------------------------------------------------------------
			# get myself participant
			#-----------------------------------------------------------------
			#-----------------------------------------------------------------
			$pMyPart = NULL;
	
	
			#-----------------------------------------------------------------
			#-----------------------------------------------------------------
			# get myself participant
			# the participants - one of my teamlist ??
			#-----------------------------------------------------------------
			#-----------------------------------------------------------------
			if( $gl_oVars->cMember->IsInAccountList( $aParticipants[0], $oMatch->participant_type, $pMyPart ) ||
				$gl_oVars->cMember->IsInAccountList( $aParticipants[1], $oMatch->participant_type, $pMyPart ) )
			{
				# PERMISSION CHECK  => SUCCESSED
				if( $pMyPart == NULL )
				{
					echo " Es ist ein Schwehrwiegender Fehler aufgetreten.";
					exit;
				}
				else
				{
					/*
					
					*/
					# reported by moi?
					if( $pMyPart->participant_id == $oMatch->report_id )
					{
						
						if( $pMyPart->participant_id == $aParticipants[0]->participant_id )
						{
							# ÄNDERUNG AM 14. Mai 2006 
							// if( !$gl_oVars->cMember->IsInAccountList( $aParticipants[1], $oMatch->participant_type, $pMyPart ) )
							if( !$gl_oVars->cMember->IsInAccountList( $aParticipants[0], $oMatch->participant_type, $pMyPart ) )
							{
								
								return 0;
								
							}//if
						}//if
						
						
					}//if
					 
				} // != NULL
				
			}
			else
			{
				# PERMISSION CHECK  => FAILED
	
				$gl_oVars->cTpl->assign( 'msg_type',	'error' );
				$gl_oVars->cTpl->assign( 'msg_title',	'Fehler' );
				$gl_oVars->cTpl->assign( 'msg_text',	'Sie haben keine Berechtigungen für dieses Match' );
				
				
				# NO OTHER ACTIONS
				return 0; # END FILE
			}
			
			/*
			# ==============================================================================
			# ==============================================================================
			# Check individual PAGE ACCESS
			# ==============================================================================
			# ==============================================================================

			$bPageAccess = false;
			if( $oMatch->participant_type == PARTTYPE_MEMBER )
			{
				$bPageAccess = $gl_oVars->cPageAccess->Evaluate( $gl_oVars->sRelDir, $gl_oVars->bLoggedIn, $gl_oVars->sURLPage, EGL_NO_ID, $pMyPart->participant_id );
			}
			else if( $oMatch->participant_type == PARTTYPE_TEAM )
			{
				$bPageAccess = $gl_oVars->cPageAccess->Evaluate( $gl_oVars->sRelDir, $gl_oVars->bLoggedIn, $gl_oVars->sURLPage, EGL_NO_ID, EGL_NO_ID  );
			}
			
			
			if( !$bPageAccess )
			{
				$gl_oVars->cTpl->assign( 'page_access', 	$bPageAccess  );
				$gl_oVars->cTpl->assign( 'msg_type', 		'error' );
				$gl_oVars->cTpl->assign( 'msg_title', 		'Error' );
				$gl_oVars->cTpl->assign( 'msg_text', 		'Permission denied!' );
				return 0;
			}*/
			
			# ==============================================================================
			# ==============================================================================
			# REPORT the match - BY INPUT DATA		
			# ==============================================================================
			# ==============================================================================
			if( $_GET['a'] == 'report' )
			{

				# --------------------------------------------------
				# match currently reported ?
				# ==> second report
				# --------------------------------------------------
				if( $oMatch->report_id != EGL_NO_ID )
				{
					
					# was the first match reporter => ME ?
					if( $oMatch->status != MATCH_REPORTED )
					{
						if( $oMatch->report_id != EGL_NO_ID &&
							$oMatch->report_id == $pMyPart->participant_id )
						{
							$gl_oVars->cTpl->assign( 'msg_type',	'error' );
							$gl_oVars->cTpl->assign( 'msg_text',	'Sie haben bereits einen Report abgegeben' );
						}
						else
						{
							
							
							if( ($_POST['report_state'] == 'accept') || 
							  	($_POST['report_state'] == 'deny' ) &&
							  	strlen($_POST['report_text']) > 0 )
							{
							
								#echo "test";

								
								# Fetch Match data
								$oMatchResults = Match::FetchMatchResults( $oMatch );
	
								/*
									$_POST['report_state']	|	=> accept / deny
								
								*/
							
								# define match_report strcuture, sent to module
								$match_report_t = new match_report_t;
								$match_report_t->report_id					= $_SESSION['member']['id'];
								$match_report_t->report_state				= $_POST['report_state'];
								$match_report_t->aParticipants		 		= $aParticipants;
								$match_report_t->oMyPart		 			= $pMyPart;
	
								
								$match_report_t->oMatchUpdate 				= NULL;					# overgive to report structure, can be written by mdoules
								#$match_report_t->oMatchUpdate->report_id	= $pMyPart->participant_id;
								
								# match accept	=> accepted
								# -------------
								if( $match_report_t->report_state == 'accept')  	
									$match_report_t->oMatchUpdate->status	= MATCH_CLOSED;
									
									
								# match deny	=> create match protest 
								# -------------
								if( $match_report_t->report_state == 'deny')  	
									$match_report_t->oMatchUpdate->status	= MATCH_REPORTED;
								
								$match_report_t->oMatch						= $oMatch;
								$match_report_t->oMatchResults				= $oMatchResults;
								$match_report_t->bSecondReport				= true;
								$match_report_t->iParttype					= $oMatch->participant_type;
		
								# CHECK INPUT
								$result = module_sendmessage( $oMatch->module_id, 'match_second_report', $match_report_t );
								
					
							
								# change data
								if( !$cMatch->SetMatchData( $match_report_t->oMatchUpdate, $oMatch->id ) )
								{
								}//if
				
								
								# REPORT MATCH
								$obj = NULL;
								$obj->match_id 				= $oMatch->id;
								$obj->participant_id 		= $pMyPart->participant_id;		# own id
								$obj->participant_type 		= $oMatch->participant_type;	# part type
								$obj->member_id				= $_SESSION['member']['id'];
								$obj->created				= EGL_TIME;
								$obj->text					= $_POST['report_text'];
								$obj->rating				= Match::TranslateRating( $_POST['report_rating'] );
								
								
								# add report
								if( !$cReports->AddReport( $obj ) )
								{
								}//if
								
								/*
									CREATE PROTESTS
									
									ACHTUNG: Es wird noch nicht überprüft ob es eine EINGABE HAT 
												=> Bitte beachten, dass es schon eine If abfrage obendrüber sein muss !!!
								*/
								
								# ABLEHNUNG ??
								if( $match_report_t->report_state == 'deny' )
								{
									$cProtests = new Protests( $gl_oVars->cDBInterface );
									
									# define protest type/structure
									$protest_obj = NULL;
									$protest_obj->member_id 		= $gl_oVars->oMemberData->id; 
									$protest_obj->match_id 			= $oMatch->id;
									$protest_obj->subject			= "Match-Report Ablehnung";
									$protest_obj->text 				= $_POST['protest_text'];
									$protest_obj->created 			= EGL_TIME;
									
									
									# created protest
									if( $cProtests->CreateProtest( $protest_obj ) )
									{
										
										$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
										$gl_oVars->cTpl->assign( 'msg_text', 	'Dein Protest wurde gerade den zuständigen Admins weitergereicht'  );
										
										//$gl_oVars->cTpl->assign( 'msg_type', 	'warning' );
										//$gl_oVars->cTpl->assign( 'msg_title', 	'Meldung'  );
										//$gl_oVars->cTpl->assign( 'msg_text', 	'Funktion nocht nicht vorhanden. Bitte melden Sie dieses Problem direkt bei den Administratoren.'  );
									}//if
									
								}//if
								elseif( $match_report_t->report_state == 'accept' && $result /*true*/ )
								{
									$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
									$gl_oVars->cTpl->assign( 'msg_text', 	'Vielen Dank, der Matchreport war erfolgreich.'  );
								}
								else
								{
									DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't execute second match-report" );
								}

								
								/*
								ACHTUNG: Prüfungeen, ob screenshots upgeloadded usw.. halt :P
										.... => FEHLT NOCH
								*/
								
							}
							else
							{
								$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
								$gl_oVars->cTpl->assign( 'msg_text', 	'Du musst alle Felder ausfüllen'  );
							}
						
						}//				if( $oMatch->report_id != EGL_NO_ID &&
						#				$oMatch->report_id == $pMyPart->participant_id )

					
					}//if 
					else 
					{
						$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
						$gl_oVars->cTpl->assign( 'msg_text', 	'Das Match wurde bereits vollständig ausgewertet. '  );
					}
					
				}//	if( $oMatch->report_id != EGL_NO_ID )		
				# --------------------------------------------------
				# match not reported ?
				# ==> first report
				# --------------------------------------------------
				else
				{
					# CHECK INPUT
	
					
					#----------------------
					# MATCH COMPLETLY REPORTD ?
					#----------------------
					if( $oMatch->status != MATCH_REPORTED )
					{
						
						
						
						#  declare match result structure				
						$oMatchResults = new match_results_t();
					
						# -------------------------------------------------
						# Scores
						# -------------------------------------------------
						for( $iMap=0; $iMap < $oMatch->num_maps; $iMap++ )
						{
							$pRes = &$oMatchResults->aMapResults[sizeof($oMatchResults->aMapResults)];
							$map_name = $_POST['report_map_'.$iMap];
							
							$pRes = new map_result_t;
							$pRes->map_name = $map_name;

							# fetch rnd 
							for( $iRnd=0; $iRnd < $oMatch->num_rounds; $iRnd++ )
							{
								$rnd_challenger_score 	= $_POST['report_score_'.$iMap.'_round_'.$iRnd.'_challenger'];
								$rnd_opponent_score 	= $_POST['report_score_'.$iMap.'_round_'.$iRnd.'_opponent'];
								
								
								$pRnd = &$pRes->aRounds[sizeof($pRes->aRounds)];
								$pRnd = new round_t;
								$pRnd->challenger_score = $rnd_challenger_score;
								$pRnd->opponent_score = $rnd_opponent_score;
								
							}//for $iRnd 
						}//for $iMap
									
						
						# -------------------------------------------------
						# Match REPORT to module
						# -------------------------------------------------
						

						# define match_report strcuture, sent to module
						$match_report_t = new match_report_t;
						$match_report_t->report_id					= $_SESSION['member']['id'];
						$match_report_t->report_state				= $_POST['report_state'];
						$match_report_t->aParticipants		 		= $aParticipants;
						$match_report_t->oMyPart		 			= $pMyPart;
						
						$match_report_t->oMatchUpdate 				= NULL;					# overgive to report structure, can be written by modules
						$match_report_t->oMatchUpdate->report_id	= $pMyPart->participant_id;
						
						$match_report_t->oMatch						= $oMatch;
						$match_report_t->oMatchResults				= $oMatchResults;
						$match_report_t->bFirstReport				= true;
						$match_report_t->iParttype					= $oMatch->participant_type;
						
						
						# SEND #DATA# TO MODULE
						$result = module_sendmessage( $oMatch->module_id, 'match_first_report', $match_report_t /*writeable*/  );
						
						
						# create db format, to save
						$obj = NULL;
						$obj = Match::ConvertToMatchDBResult( $oMatchResults );
						
						$match_report_t->oMatchUpdate->results		= $obj->results;
						$match_report_t->oMatchUpdate->maps			= $obj->maps;
						
						
						
						# CHANMGE MATCH data
						if( $cMatch->SetMatchData( $match_report_t->oMatchUpdate, $oMatch->id ) )
						{
						}
						
						# -------------------------------------------------
						# Match reports
						# ------------------------------------------------
						
						/*
							ACHTUNG 'überprüfen': Report currently exists ?
						*/
						
						$obj = NULL;
						$obj->match_id 			= $oMatch->id;
						$obj->participant_id 	= $pMyPart->participant_id;
						$obj->participant_type 	= $oMatch->participant_type;
						$obj->member_id			= $_SESSION['member']['id'];
						$obj->created			= EGL_TIME;
						$obj->text				= $_POST['report_text'];
						$obj->rating			= Match::TranslateRating( $_POST['report_rating'] );
						
						# add report
						$cReports->AddReport( $obj );	
						
						
						
						$gl_oVars->cTpl->assign( "msg_type", 	"success" );
						$gl_oVars->cTpl->assign( "msg_title", 	"Match reported" );
						$gl_oVars->cTpl->assign( "msg_text", 	"Vielen Dank, dein Match-Report wurde erfolgreich eingetragen." );
					} // if( $oMatch->status != MATCH_REPORTED )			
	
				}//if currently not reported
	
				# ---
				
			}
			# ==============================================================================
			# ==============================================================================
			# Upload meida file
			# ==============================================================================
			# ==============================================================================
			else if( $_GET['a'] == 'media' )
			{
				
				# get uploadcount which have to be done !
				$iNumUploads = (int)$_POST['media_num_uploads'];
				
				$bError = false;
				
				$iNumActiveUploads	= 0;
				//--------------------------------
				// Fetch Files
				//--------------------------------
				for( $upload=0; $upload < $iNumUploads; $upload++ )
				{
					$pUploadFile = &$_FILES['media_file_'.$upload];
					
					if( !strlen($pUploadFile['tmp_name']) ||
						!strlen($_POST['media_file_'.$upload.'_name']) ) continue;
	
					
					$obj = NULL;
					$obj->match_id 	= $oMatch->id;
					$obj->member_id = $_SESSION['member']['id'];	
					$obj->name 		= $_POST['media_file_'.$upload.'_name'];
					$obj->created 	=  EGL_TIME;
					
					
					# Get FileExtension();
					
					# start create media files
					$media_id=0;
					$upload_result = null;
				
					if( ( $media_id=$cMedia->CreateMediaFile( $obj )) )
					{
						
						$extension = get_file_extension($pUploadFile['name'],-1);
						$filename = md5($oMatch->id.'_'.$media_id.CreateRandomPassword(10)).'.'.$extension;
						
						# copy file
						if( $upload_result=@copy( $pUploadFile['tmp_name'], EGLDIR_MEDIA . $filename ) )
						{
							unset( $obj );
							
							$obj = NULL;
							$obj->file_name = $filename;
							$obj->type 		= $extension;
							
							# set filename
							$cMedia->UpdateMediaFile( $obj, $media_id );
						
							
							$iNumActiveUploads++;							
							
						}else $bError = true;
					}else $bError = true;
				}//for
				
				
				if( $bError )
				{
					$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
					$gl_oVars->cTpl->assign( 'msg_title', 	'error'  );
					$gl_oVars->cTpl->assign( 'msg_text', 	'error' );
				}
				else
				{
					if( $iNumActiveUploads > 0 )
					{
						$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
						$gl_oVars->cTpl->assign( 'msg_title', 	'Erfolgreich'  );
						$gl_oVars->cTpl->assign( 'msg_text', 	'Die Dateien wurden erfolgreich hochgeladen'  );
					}
					else 
					{
						$gl_oVars->cTpl->assign( 'msg_type', 	'info' );
						$gl_oVars->cTpl->assign( 'msg_title', 	'Info'  );
						$gl_oVars->cTpl->assign( 'msg_text', 	'Es konnte keien Media-Dateien hochgeladen werden.'  );
					}
	
				}// if $bError
				
			} // if $_get[a] media
			# ==============================================================================
			# ==============================================================================
			# Display Report or 
			# ==============================================================================
			# ==============================================================================
			else 
			{
				
				# ----------------------------
				# match completly reported ?
				# ----------------------------
				if( $oMatch->status == MATCH_REPORTED )
				{
					$gl_oVars->cTpl->assign( 'match_reported', true );
					
					#$gl_oVars->cTpl->assign( 'match_reporter',	ConvertXArrayObjectArray($pMyPart));
				}
				else
				{
					#----------------------------------------------
					# was the first match reporter => ME ?
					#----------------------------------------------
					if( $oMatch->report_id != EGL_NO_ID &&
						$oMatch->report_id == $pMyPart->participant_id )
					{
						$gl_oVars->cTpl->assign( 'msg_type',	'error' );
						$gl_oVars->cTpl->assign( 'msg_title',	'Fehler' );
						$gl_oVars->cTpl->assign( 'msg_text',	'Sie haben bereits einen Report abgegeben' );
						
						
						# match wurde bereits von mir reported
						$gl_oVars->cTpl->assign( 'my_match_report',	true );
						#$gl_oVars->cTpl->assign( 'match_reporter',	ConvertXArrayObjectArray($pMyPart));
					}
				} //if
				
				
				if( $oMatch->report_id == $aParticipants[0]->participant_id )  $gl_oVars->cTpl->assign( 'match_reporter',	$aParticipants[0] );
				if( $oMatch->report_id == $aParticipants[1]->participant_id )  $gl_oVars->cTpl->assign( 'match_reporter',	$aParticipants[1] );
				
				
				# match currently reported ?
				if( $oMatch->report_id == EGL_NO_ID )
				{
					# fetch match structre
					$oMatchStruct = Match::FetchMatchStructure( $oMatch );
					
					$gl_oVars->cTpl->assign( 'match_struct', $oMatchStruct );
				}
				else
				{
					# YES
				
					
					# fetch / read match results
					$oMatchResult = Match::FetchMatchResults( $oMatch );	
					
					/*
					# convert mapresultdata to smarty tpl format 
					for( $i=0; $i < sizeof($oMatchResult->aMapResults); $i++ )
					{
						$oMatchResult->aMapResults[$i]->aRounds = $oMatchResult->aMapResults[$i]->aRounds ;
						$oMatchResult->aMapResults[$i] = $oMatchResult->aMapResults[$i] ;
					}*/
					
					$gl_oVars->cTpl->assign( 'match_result', $oMatchResult );
					
					if( $oMatchResult->bDetailedRounds ) 
						$gl_oVars->cTpl->assign( 'display_detailed_rounds', true );
				}
				
		
				// get maps
				$aMaps = $cMapCollections->GetCollectionMaps( $oMatch->mapcollection_id );
				//$oCollection = $cMapCollections->GetCollectionById( $iCollectionId );
				
				if( sizeof($aMaps) > 0 )$gl_oVars->cTpl->assign( 'MAPS', 	$aMaps );
				
				
				$gl_oVars->cTpl->assign( 'match', 				$oMatch );
				$gl_oVars->cTpl->assign( 'participants', 		$aParticipants );
				$gl_oVars->cTpl->assign( 'num_media_files', 	5 );
				
				
				
	
			}//if  not actions 
			
			
			}# if Match RUNNING ??
		
	}//if oMatchdata correct ?

?>