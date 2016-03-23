<?php
# ================================ Copyright (C) 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


//define( "TB_LADDERS",						'egl_ladders' );
//define( "TB_LADDER_JOINS",				'egl_ladder_joins' );


# defines
define( "MODULEID_INETOPIA_LADDER",			'A9CCDCBF-C696-422c-A0D8-91223A9C22E6' );

# requirements
egl_require( dirname(__FILE__) . EGL_DIRSEP.'classes'.EGL_DIRSEP.'InetopiaLadder.class.php' );
egl_require( dirname(__FILE__) . EGL_DIRSEP.'classes'.EGL_DIRSEP.'FastChallenge.class.php' );


class module_inetopia_ladder extends Module
{
	
	//-------------------------------------------------------------------------------
	// Purpose: receives all events
	//-------------------------------------------------------------------------------
	function ProcessMessage( $event, &$data, $wparam=NULL, $lparam=NULL )
	{
		
		switch( $event )
		{
			# ----------------------
			# standard events
			# ----------------------
			case 'info':
			{
				if( get_class($data) == 'module_data_request_t' )
				{
					$data->ID 				= MODULEID_INETOPIA_LADDER;
					$data->sName 			= "Ladder";
					$data->sVersion 		= "0.6";
					$data->sDevelopment 	= "Inetopia";
					$data->sHomepage 		= "http://www.electonicgamingleague.de/modules/";
					$data->sDescription		= "Ladder-Management for players and teams";
					$data->sSourceConst		= "modconst_ladder";
					
					# localize cmod data
					$this->oInfos = $data;
					return 1;
				}
			}break;
			case 'load':
			{
				#save params
				$this->aParams = $data;
			
				return 1;
			}break;
			case 'unload':
			{
				return 1;
			}break;
			case 'install':
			{
				# install tables
				return 1;
			}break;
			case 'uninstall':
			{
				# uninstall tables
				return 1;
			}break;
			
			
			
			
			case 'optimize':
			{
				
				return 1;
			}break;
		
			# ----------------------
			# specific events
			# ----------------------

			case 'on_register_member':
			{
				return 1;
			}break;
			case 'on_unregister_member':
			{
				return 1;
			}break;
			
		
			
			
			case 'on_teamjoin_request':
			{
				
				return 1;
			}break;
			
			
			# ----------------------
			# page events
			# ----------------------
			
	
			case 'match_info':
			{
				
				return 1;
			}break;
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'match_first_report':
			{
				
				return 1;
			}break;
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:	
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'match_second_report':
			{
				/*****
					$data		<class match_report_t>
					$wparam 	NULL
					$lparam		NULL
				*****/
				
				global  $gl_oVars;
				$cLaddersystem 	= new InetopiaLadder( $gl_oVars->cDBInterface);
				$cCaller		= new CallbackManager();
				
				# init root callbacks for Calculator
				
				if( !$cCaller->Init( EGL_SECURE.'calculator'.EGL_DIRSEP, $gl_oVars ) )
				{
					DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't initialise CallbackManager" );
				}
			
				
				#----------------------------------------------
				# MATCH ACCEPTED ?
				#----------------------------------------------
				if( $data->report_state == 'accept' )
				{
					# fetch encount (current) 
					$oEncount = $cLaddersystem->GetEncountByMatchId( $data->oMatch->id );
					
					# fetch ladder data for evaluation
					$oLadder = $cLaddersystem->GetLadderbyID( $oEncount->ladder_id );
					
					# fetch challenger/opponent data from ladder (points..etc)
					$oChallengerPart = $cLaddersystem->GetLadderParticipant( $oEncount->ladder_id, $data->oMatch->challenger_id );
					$oOpponentPart = $cLaddersystem->GetLadderParticipant( $oEncount->ladder_id, $data->oMatch->opponent_id );

				
					# set evaluation
					# -----------------------------------
					# challenger wins
					# -----------------------------------
					if( $data->oMatchResults->total_challenger_score > $data->oMatchResults->total_opponent_score )
					{
						# set challenger as 
						/*
							ARRAY:
									challenger_points		=> new points after evaluation
									opponent_points			=> new points after evaluation
									challenger_points_diff	=> points diff according to last score
									opponent_points_diff	=> points diff according to last score
						*/
						//$calc = explode( '.', $oLadder->calculator );
						$eval_results 	=	$cCaller->Call( $oLadder->calculator, array( 	'challenger_points' => $oChallengerPart->points,
																						  	'opponent_points' 	=> $oOpponentPart->points,
																						  	'winner'			=> 'challenger',	# challenger wins
																						  	'match_results'		=> $data->oMatchResults,																					  	 //'k'					=> 50,
																		  					 //'div'				=> 400 
																						) );						
						
						
						$sql = 	" UPDATE ".$GLOBALS['g_egltb_ladder_participants']." AS parts ".
								" SET last_points=points, points=points+".((int)$eval_results['challenger_points_diff'])." ".
								" WHERE ladder_id=".$oLadder->id." && participant_id=".$data->oMatch->challenger_id;
						$gl_oVars->cDBInterface->Query( $sql );		

						
						$sql = 	" UPDATE ".$GLOBALS['g_egltb_ladder_participants']." AS parts ".
								" SET last_points=points, points=points+".((int)$eval_results['opponent_points_diff'])." ".
								" WHERE ladder_id=".$oLadder->id." && participant_id=".$data->oMatch->opponent_id;
						$gl_oVars->cDBInterface->Query( $sql );		
								
						
						# -----------------------
						$data->oMatchUpdate->evaluated 			= 1;
						$data->oMatchUpdate->evaluate_time 		= EGL_TIME;
						$data->oMatchUpdate->challenger_points	= (int)$eval_results['challenger_points_diff'];
						$data->oMatchUpdate->opponent_points	= (int)$eval_results['opponent_points_diff'];
						$data->oMatchUpdate->winner_id			= $data->oMatch->challenger_id;
						
						# PUNKTE VERGABE
					}
					
					# -----------------------------------
					# opponent wins
					# -----------------------------------
					else if( $data->oMatchResults->total_challenger_score < $data->oMatchResults->total_opponent_score )
					{
						
						
						# opponent as winner
						# set challenger as 
						/*
							ARRAY:
									challenger_points		=> new points after evaluation
									opponent_points			=> new points after evaluation
									challenger_points_diff	=> points diff according to last score
									opponent_points_diff	=> points diff according to last score
						*/
						//$calc = explode( '.', $oLadder->calculator );
						$eval_results 	=	$cCaller->Call( $oLadder->calculator, array( 	'challenger_points' => $oChallengerPart->points,
																					  		'opponent_points' 	=> $oOpponentPart->points,
																					 	 	'winner'			=> 'opponent',		# opponent wins
																						  	'match_results'		=> $data->oMatchResults,																						  	 //'k'					=> 50,
																						  	 //'k'					=> 50,
																		  					 //'div'				=> 400 
																						) );						

						
					
						$sql = 	" UPDATE `".$GLOBALS['g_egltb_ladder_participants']."` AS parts ".
								" SET last_points=points, points=points+".((int)$eval_results['challenger_points_diff'])." ".
								" WHERE ladder_id=".$oLadder->id." && participant_id=".(int)$data->oMatch->challenger_id;
						$gl_oVars->cDBInterface->Query( $sql );		

						
						$sql = 	" UPDATE `".$GLOBALS['g_egltb_ladder_participants']."` AS parts ".
								" SET last_points=points, points=points+".((int)$eval_results['opponent_points_diff'])." ".
								" WHERE ladder_id=".$oLadder->id." && participant_id=".(int)$data->oMatch->opponent_id;
						$gl_oVars->cDBInterface->Query( $sql );		
 								
						
						
						# -----------------------
						$data->oMatchUpdate->evaluated 			= 1;
						$data->oMatchUpdate->evaluate_time 		= EGL_TIME;
						$data->oMatchUpdate->challenger_points	= (int)$eval_results['challenger_points_diff'];
						$data->oMatchUpdate->opponent_points	= (int)$eval_results['opponent_points_diff'];
						$data->oMatchUpdate->winner_id			= $data->oMatch->opponent_id;

											
						# PUNKTE VERGABE
						
					}
					# -----------------------------------
					# noone wins
					# -----------------------------------
					else
					{
						
						# set challenger as 
						/*
							ARRAY:
									challenger_points		=> new points after evaluation
									opponent_points			=> new points after evaluation
									challenger_points_diff	=> points diff according to last score
									opponent_points_diff	=> points diff according to last score
						*/
						//$calc = explode( '.', $oLadder->calculator );
						$eval_results 	=	$cCaller->Call( $oLadder->calculator, array( 	'challenger_points' => $oChallengerPart->points,
																					  		'opponent_points' 	=> $oOpponentPart->points,
																					  		'winner'			=> '',	# noone wins
																						  	'match_results'		=> $data->oMatchResults,																						  	 //'k'					=> 50,
																					  		//'k'				=> 50,
																		  					//'div'				=> 400 
																							) );						
						
						
						$sql = 	" UPDATE `".$GLOBALS['g_egltb_ladder_participants']."` AS parts ".
								" SET last_points=points, points=points+".((int)$eval_results['challenger_points_diff'])." ".
								" WHERE ladder_id=".$oLadder->id." && participant_id=".$data->oMatch->challenger_id;
						$gl_oVars->cDBInterface->Query( $sql );		

						
						$sql = 	" UPDATE `".$GLOBALS['g_egltb_ladder_participants']."` AS parts ".
								" SET last_points=points, points=points+".((int)$eval_results['opponent_points_diff'])." ".
								" WHERE ladder_id=".$oLadder->id." && participant_id=".$data->oMatch->opponent_id;
						$gl_oVars->cDBInterface->Query( $sql );		
								
						
						# -----------------------
						$data->oMatchUpdate->evaluated 			= 1;
						$data->oMatchUpdate->evaluate_time 		= EGL_TIME;
						$data->oMatchUpdate->challenger_points	= (int)$eval_results['challenger_points_diff'];
						$data->oMatchUpdate->opponent_points	= (int)$eval_results['opponent_points_diff'];
						$data->oMatchUpdate->winner_id			= EGL_NO_ID;

											
						// # no one gewonnen ... shit :PP
						//echo "Error: Please contact webadminstrator!";
					}//if
					
				}//if
				
				#----------------------------------------------
				# MATCH DENIED ?
				#----------------------------------------------
				else if( $data->report_state == 'deny' )
				{
					# mache nichts, warte bis admin das regelt :P

					# match - protest erstellen
					
					
				}
				else
				{
				}
					
				return 1;
			}break;
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'match_evaluate':
			{
				/**
				* Modify $data 
				*
				**/
				$data->report_state = 'accept';
				return $this->ProcessMessage( 'match_second_report', $data, $wparam, $lparam );
			}break;
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'match_revoke_evaluation':
			{
				/*****
					$data		<class match_report_t>
					$wparam 	NULL
					$lparam		NULL
				*****/
				global $gl_oVars;
				$oMatch = $data->oMatch;
				
				# declare classes
				$cMatch = new Match ( $gl_oVars->cDBInterface );
				$cLaddersystem = new InetopiaLadder( $gl_oVars->cDBInterface );
				
				# fetch encount (current) 
				$oEncount = $cLaddersystem->GetEncountByMatchId( $data->oMatch->id );
									
				# fetch ladder data for evaluation
				$oLadder = $cLaddersystem->GetLadderbyID( $oEncount->ladder_id );
				
				
				if( $oMatch && $oEncount && $oLadder )
				{

					# ------------------------
					# revoke challenger-points
					# ------------------------
					$sql_query = 	"	UPDATE `{$GLOBALS['g_egltb_ladder_participants']}` AS parts ".
									"	SET points=points-".(int)$oMatch->challenger_points." ".
									"		last_points=points ".
									" 	WHERE ladder_id=".(int)$oLadder->id." && participant_id=".(int)$oMatch->challenger_id;
					$gl_oVars->cDBInterface->Query( $sql_query );
					
					
					# ------------------------
					# revoke opponent-points
					# ------------------------
					$sql_query = 	"	UPDATE `{$GLOBALS['g_egltb_ladder_participants']}` AS parts ".
									"	SET points=points-".(int)$oMatch->opponent_points." ".
									"		last_points=points ".
									" 	WHERE ladder_id=".(int)$oLadder->id." && participant_id=".(int)$oMatch->opponent_id;
					$gl_oVars->cDBInterface->Query( $sql_query );
					
	
					/*
					# set update fields
					$data->oMatchUpdate->winner_id				= EGL_NO_ID;
					$data->oMatchUpdate->challenger_points		= 0;
					$data->oMatchUpdate->opponent_points		= 0;
					$data->oMatchUpdate->evaluated				= 0;
					$data->oMatchUpdate->evaluate_time			= 0;*/
					
					# revoke match
					$obj_match 	= array( 	'winner_id'			=> EGL_NO_ID,
											'challenger_points'	=> 0,
											'opponent_points'	=> 0,
											'evaluated'			=> 0,
											'evaluate_time'		=> 0
										);		
					
					# ....					
					if( !$cMatch->SetMatchData( $obj_match, $oMatch->id ) )
					{
						return 0;
					}
					else
					{
						return 1;
					}
									
					# revoke encount
					# not necessary
				}
				
				return 0;
			}break;
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------	
			case 'get_detailed_ladders':
			{
				global $gl_oVars;
				$cLadder = new InetopiaLadder( $gl_oVars->cDBInterface );
				$iGameId = (int)$wparam;
				return $cLadder->GetDetailedLadderByGameId( $iGameId );
			}break;
			
			
			
			case 'page_init':
			{
			}break;
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#   Input: 	$data 		workspace
			#			$wparam 	template file
			#			$lparam 	module-id
			#  Output:  *true/false
			#-----------------------------------------------------------------------------------------------------
			case 'exec_template':
			{
				global $gl_oVars;
				

				# ----------------------------------------
				# 
				#
				# ----------------------------------------
				if( $data == 'hp' )
				{
					# get current question 
										
					# ------------------------------------
					# polls
					# ------------------------------------

				
				} // if 'hp'
				return  false;
			}break;
			
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'exec_document':
			{
				
				return 1;
			}break;
			
			
		# ----------------------
			# Kommunication Template/Page <=> cMod
			# ----------------------
			
			
			case 'get_admin_links':
			{
				/*
				
				$aLinkPool = array();
				
				# get cmod ID
				$ID = $this->oInfos->ID;
				
				$aLinkPool[sizeof($aLinkPool)] = new module_link_t( 'Ladder', 	"{\$url_file}cmod=$ID&page=admin.ladder.list" );


				# save in output
				$data = $aLinkPool;*/
				return 1;				
				
			}break;
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			# multiplayer (team)
			case 'get_team_links':
			{
				
				global $gl_oVars;
				$aLinkPool = array();
				
				# get cmod ID
				$ID 		= $this->oInfos->ID;
				$iTeamId	= (int)$_GET['team_id'];
				
				$aLngModBuffer 	= array();
				$cLanguage 		= new Language();
				$cLanguage->ParseRootFile( Language::ModuleLanguageFile( $gl_oVars, $ID, $gl_oVars->sWorkspace ), $aLngModBuffer );
				
				
				# search open challenges
				$sql_query = 	" SELECT COUNT(*) AS num_challenges ".
								" FROM `{$GLOBALS['g_egltb_ladder_challenges']}` AS challenges ".
								" LEFT JOIN `{$GLOBALS['g_egltb_ladders']}` AS ladder ".
								" ON ladder.id=challenges.ladder_id ".
								" WHERE ladder.participant_type=".PARTTYPE_TEAM." ".
								" 		&& (challenges.challenger_id=".$iTeamId." || challenges.opponent_id=".$iTeamId.") ".
								"		&& challenges.state=".CHALLENGESTATE_CHALLENGING." ".
								" GROUP BY challenges.id ";
				$oChallenges = $gl_oVars->cDBInterface->FetchObject( $gl_oVars->cDBInterface->Query( $sql_query ) );
								
				
				$num_challenges = (int)$oChallenges->num_challenges;				
				
				//$aLinkPool[sizeof($aLinkPool)] = new module_link_t( 'Ladder beitreten', "{\$url_file}page=$ID:team.joinladder" );
				$aLinkPool[sizeof($aLinkPool)] = new module_link_t( $aLngModBuffer['c9083'].'('.$num_challenges.')', "{\$url_file}page=$ID:team.challengelist" );
				$aLinkPool[sizeof($aLinkPool)] = new module_link_t( $aLngModBuffer['c9084'], "{\$url_file}page=$ID:team.quit" );
				$aLinkPool[sizeof($aLinkPool)] = new module_link_t( $aLngModBuffer['c9085'], "{\$url_file}page=$ID:team.rankbutton" );
				
				
				# save in output
				$data = $aLinkPool;

							
				return 1;
			}break;
			

			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			# single player (member)
			case 'get_member_links':
			{
				global $gl_oVars;
				$aLinkPool = array();
				
				# get cmod ID
				$ID 		= $this->oInfos->ID;
				$iMemberId 	= (int)$gl_oVars->iMemberId;
				
				$aLngModBuffer 	= array();
				$cLanguage 		= new Language();
				$cLanguage->ParseRootFile( Language::ModuleLanguageFile( $gl_oVars, $ID, $gl_oVars->sWorkspace ), $aLngModBuffer );
				
				
				# search open challenges
				$sql_query = 	" SELECT COUNT(*) AS num_challenges ".
								" FROM `{$GLOBALS['g_egltb_ladder_challenges']}` AS challenges ".
								" LEFT JOIN `{$GLOBALS['g_egltb_ladders']}` AS ladder ".
								" ON ladder.id=challenges.ladder_id ".
								" WHERE ladder.participant_type=".PARTTYPE_MEMBER." ".
								" 		&& (challenges.challenger_id=".$iMemberId." || challenges.opponent_id=".$iMemberId.") ".
								"		&& challenges.state=".CHALLENGESTATE_CHALLENGING." ".
								" GROUP BY challenges.id ";
				$oChallenges = $gl_oVars->cDBInterface->FetchObject( $gl_oVars->cDBInterface->Query( $sql_query ) );
								
				
				$num_challenges = (int)$oChallenges->num_challenges;
				$aLinkPool[sizeof($aLinkPool)] = new module_link_t( $aLngModBuffer['c9083'].'('.$num_challenges.')', 		"{\$url_file}page=$ID:member.challengelist" );
				$aLinkPool[sizeof($aLinkPool)] = new module_link_t( $aLngModBuffer['c9084'], "{\$url_file}page=$ID:member.quit" );
				$aLinkPool[sizeof($aLinkPool)] = new module_link_t( $aLngModBuffer['c9085'], "{\$url_file}page=$ID:member.rankbutton" );


				# save in output
				$data = $aLinkPool;
				
				return 1;
			}break;
			
		
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'template_attachment':
			{
				global $gl_oVars;
				/**
				 * $wparam	=> workspace
				 * $lparam 	=> page
				 */
				$workspace = $wparam;
				$page = $lparam;
				
				// member_id
				$iMemberId 	= (int)$_GET['member_id'];
				$iTeamId	= (int)$_GET['team_id'];
				

				# declare classes
				$cLaddersystem = new InetopiaLadder( $gl_oVars->cDBInterface );
				
				# ----------------------------------------------------------------------------------
				# ATTACHE: member.info
				# ----------------------------------------------------------------------------------
				if( $workspace == 'hp' && $page == 'member.info' )
				{
					if( isset($_GET['member_id']) )
					{
						$a1on1Ladders = $cLaddersystem->GetJoined1on1LadderByMemberId( $iMemberId );
						$gl_oVars->cTpl->assign( 'attached_1on1ladders',  $a1on1Ladders );
						$aTeamLadders = $cLaddersystem->GetJoinedTeamLadderByMemberId( $iMemberId );
						$gl_oVars->cTpl->assign( 'attached_teamladders',  $aTeamLadders );
						
						
						// matches
						// 	function GetLadderMatchesByParticipant( $participant_id, $participant_type, $ladder_id, $limit=0 )
						$a1on1LadderMatches = array();
						for( $i=0; $i < sizeof($a1on1Ladders); $i++ ){
							$a1on1LadderMatches[sizeof($a1on1LadderMatches)] = $cLaddersystem->GetLadderMatchesByParticipant( $iMemberId, PARTTYPE_MEMBER, $a1on1Ladders[$i]->ladder_id, 5 );
						}
						$gl_oVars->cTpl->assign( 'attached_1on1ladder_matches',  $a1on1LadderMatches );
						
						
						$aTeamLadderMatches = array();
						for( $i=0; $i < sizeof($aTeamLadders); $i++ ){
							$aTeamLadderMatches[sizeof($aTeamLadderMatches)] = $cLaddersystem->GetLadderMatchesByParticipant(  $aTeamLadders[$i]->team_id, PARTTYPE_TEAM, $aTeamLadders[$i]->ladder_id, 5 );
						}
						
						$gl_oVars->cTpl->assign( 'attached_teamladder_matches',  $aTeamLadderMatches );
						
					}
					return array( 'template_file' => 'member_ladderinfo.tpl' );
				}
				# ----------------------------------------------------------------------------------
				# ATTACHE: member.info
				# ----------------------------------------------------------------------------------
				else if( $workspace == 'hp' && $page == 'team.info' )
				{
						$aTeamLadders = $cLaddersystem->GetJoinedTeamLadderByTeamId( $iTeamId );
						$gl_oVars->cTpl->assign( 'attached_teamladders',  $aTeamLadders );
						
						// matches for team
						$aTeamLadderMatches = array();
						for( $i=0; $i < sizeof($aTeamLadders); $i++ ){
							$aTeamLadderMatches[sizeof($aTeamLadderMatches)] = $cLaddersystem->GetLadderMatchesByParticipant( $iTeamId , PARTTYPE_TEAM, $aTeamLadders[$i]->ladder_id, 5 );
						}
						$gl_oVars->cTpl->assign( 'attached_teamladder_matches',  $aTeamLadderMatches );
						
						
					return  array( 'template_file' => 'team_ladderinfo.tpl' );
				}
				return '';
			}break;
			
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'entry_list':
			{
				global $gl_oVars;
				$cLaddersystem = new InetopiaLadder( $gl_oVars->cDBInterface );
				
				$participant_id		= $wparam;	# overgiven by engine
				$participant_type	= $lparam;	# overgiven by engine
				
				
				/* SET LIMIT*/
				$aLadders = $cLaddersystem->GetLadderEntries( $participant_id, $participant_type );
				
				$aEntries = array();
				for( $i=0; $i < sizeof($aLadders); $i++ )
				{
					$pEntry = &$aEntries[sizeof($aEntries)];
					$pEntry = new module_entry_t;
					$pEntry->sName 	= $aLadders[$i]->name;
					$pEntry->Id 	= $aLadders[$i]->id;
				}//for
				
				return $aEntries;
			}break;
			
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'match_list':
			{
				/*
				global $gl_oVars;
				$cCup = new CCup( $gl_oVars->cDBInterface, NULL );

				$cup_id				= $data->entry_id;  ## entry_id 
				$participant_id		= $data->part_id;	# overgiven by engine
				$participant_type	= $data->part_type;	# overgiven by engine
				$status				= NULL;
				*/
				global $gl_oVars;
				
				$ladder_id			= $data->entry_id;  # entry_id 
				$participant_id		= $data->part_id;	# overgiven by engine
				$participant_type	= $data->part_type;	# overgiven by engine
				$status				= $data->status;	# status (all,reported,viewed
	
				# declare classes
				$cLaddersystem		= new InetopiaLadder( $gl_oVars->cDBInterface );
				
								
				if( $participant_type == PARTTYPE_MEMBER )
				{
					$aMatches = $cLaddersystem->GetLadderMatchesByParticipant( $participant_id, $participant_type, $ladder_id, 0, $status );
				}
				elseif( $participant_type == PARTTYPE_TEAM )
				{
					$aMatches = $cLaddersystem->GetLadderMatchesByParticipant( $participant_id, $participant_type, $ladder_id, 0, $status );
				}
				return $aMatches;
			}break;
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose: Zust�ndig, ob ein Member (abh�ngig von den Admin-Permissions) auf das match adminrechte hat
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'match_access':
			{

				#	if( $obj ) return PAGEACCESS_OK;
				return PAGEACCESS_FAILED;
			}break;
			
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'entry_access':
			{
				
				
			}break;
			
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose: 
			#			
			#  Output: list of errors
			#-----------------------------------------------------------------------------------------------------
			case 'delete_member_request':
			{
				global $gl_oVars;
				
				$iMemberId = (int)$wparam;
				$cLaddersystem = new InetopiaLadder( $gl_oVars->cDBInterface );
				
				//$aTeamLadders = $cLaddersystem->GetJoinedTeamLadderByMemberId( $iMemberId );
				
				$aReponseMessages = array();
				
				# -----------------------------------------
				# 1on1 CHECK
				# -----------------------------------------
				# member in Ladder?
				$a1on1Ladders = $cLaddersystem->GetJoined1on1LadderByMemberId( $iMemberId );
				
				for( $i=0; $i < sizeof($a1on1Ladders); $i++ ){
					$_msg = 'Dieses Mitglied ist momentan in der Ladder '.$a1on1Ladders[$i]->name.' eingeschrieben';
					$aReponseMessages[sizeof($aReponseMessages)] = $_msg;
				}

								
								
				# search open challenges
				$sql_query = 	" SELECT ladder.* ".
								" FROM `{$GLOBALS['g_egltb_ladder_challenges']}` AS challenges ".
								" LEFT JOIN `{$GLOBALS['g_egltb_ladders']}` AS ladder ".
								" ON ladder.id=challenges.ladder_id ".
								" WHERE ladder.participant_type=".PARTTYPE_MEMBER." ".
								" 		&& (challenges.challenger_id=".$iMemberId." || challenges.opponent_id=".$iMemberId.") ".
								"		&& challenges.state=".CHALLENGESTATE_CHALLENGING." ".
								"";
				$a1on1Challenges = $gl_oVars->cDBInterface->FetchArrayObject( $gl_oVars->cDBInterface->Query( $sql_query ) );
				for( $i=0; $i < sizeof($a1on1Challenges); $i++ ){
					$_msg = 'Dieses Mitglied hat eine laufende Forderung in der Ladder '.$a1on1Challenges[$i]->name.'';
					$aReponseMessages[sizeof($aReponseMessages)] = $_msg;
				}
				
				# search open matches
				$sql_query = 	" SELECT ladder.*, ladder_encounts.match_id ".
								" FROM `{$GLOBALS['g_egltb_matches']}` AS matches, `{$GLOBALS['g_egltb_ladder_encounts']}` AS ladder_encounts ".
								" LEFT JOIN `{$GLOBALS['g_egltb_ladders']}` AS ladder ".
								" ON ladder.id=ladder_encounts.ladder_id ".
								" WHERE matches.participant_type=".PARTTYPE_MEMBER." && (matches.challenger_id=".$iMemberId." || matches.opponent_id=".$iMemberId.") ".
								" 		&& matches.id=ladder_encounts.match_id && matches.status!=".MATCH_CLOSED." ";
				$a1on1Matches = $gl_oVars->cDBInterface->FetchArrayObject( $gl_oVars->cDBInterface->Query( $sql_query ) );
				for( $i=0; $i < sizeof($a1on1Matches); $i++ ){
					$_msg = 'Dieses Mitglied hat eine laufendes Match (ID:'.$a1on1Matches[$i]->match_id.') in der Ladder '.$a1on1Matches[$i]->name.'';
					$aReponseMessages[sizeof($aReponseMessages)] = $_msg;
				}
				
				
				# -----------------------------------------
				# TEAM CHECK
				# -----------------------------------------

				
				/*
				# search open team challenges, member has joined
				$sql_query = 	" SELECT * ".
								" FROM `{$GLOBALS['g_egltb_team_joins']}` AS team_joins ".
								" "
								" WHERE team_joins.member_id=".$iMemberId." ".
								"";
				*/
				
				
				# search open team matches, member has joined
							
				return $aReponseMessages;
			}break;
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose: 
			#			
			#  Output: list of errors
			#-----------------------------------------------------------------------------------------------------
			case 'delete_member':
			{
			
				
				return 1;	
			}			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'page_access':
			{
				# $data ->  $aAccesslist
				# wparam -> $ocModAdmin
				# lparam -> page

				
				if( sizeof($wparam) > 0 ) return PAGEACCESS_OK;
				return PAGEACCESS_FAILED;
			}break;
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'admin_page_access':
			{
				# $data ->  $aAccesslist
				# wparam -> $ocModAdmin
				# lparam -> page
							
				$page			= $lparam;
				$acModAdmin 	= $wparam;
				$aAccesslist 	= $data;

				/*
				
					=> sollter nicht zum Einsatz kommen
				
				*/
				
				
				switch( $lparam /* PAGE */ )
				{
					case '':
					{

						
					}break;
					default:
					{
					}break;
				}
				
				
				return PAGEACCESS_FAILED;
			}break;
			
			
			
			
			
			/**
			 * fetch ladders by game-id
			 * 
			 * 
			 */
			case 'get_ladders':
			{
				global $gl_oVars;
				
				$iGameId	= (int)$wparam;
				$aLadders 	= array();
				
				# declare classes
				$cLaddersystem = new InetopiaLadder( $gl_oVars->cDBInterface );
				$aLadders = $cLaddersystem->GetDetailedLadderByGameId( $iGameId );
				
				return $aLadders;
			}break;
			

			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			default:
			{
				return MODULERESULT_UNKNOWN;
				//return Module::ProcessMessage( $event, $data, $wparam, $lparam );
			}break;
			
			
		}//switch
		
		return 1;
	}	
};


?>