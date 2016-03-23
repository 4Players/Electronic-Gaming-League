<?php
# ================================ Copyright � 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



egl_require( dirname(__FILE__) . EGL_DIRSEP.'classes'.EGL_DIRSEP.'Cup.class.php' );
egl_require( dirname(__FILE__) . EGL_DIRSEP.'classes'.EGL_DIRSEP.'CupTree.class.php' );



define( "TB_CUPS",					'egl_cups' );					# cups
define( "TB_CUP_PARTICIPANTS",		'egl_cup_participants' );		# teilnehmer
define( "TB_CUP_ENCOUNTERS",		'egl_cup_encounters' );			# begegnungen (matches)

define( "MODULEID_INETOPIA_CUP",	'61A47C28-FE74-488d-B8E4-A11FEDBB935A' );


class module_inetopia_cup extends Module
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
					$data->ID 				= MODULEID_INETOPIA_CUP;
					$data->sName 			= 'Cups';
					$data->sVersion 		= '0.6';
					$data->sDevelopment 	= 'Inetopia';
					$data->sHomepage 		= 'http://www.electonicgamingleague.de/modules/'.MODULEID_INETOPIA_CUP.'/';
					$data->sDescription		= "Cup-Management for players and clans";
					//$data->sSourceConst		= "cmodconst_cup";
					
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
			
			
			case 'get_cups':
			{
				# wparam => game_id
				global $gl_oVars;
				$iGameId	= (int)$wparam;
				
				$cCup = new Cup( $gl_oVars->cDBInterface );
				return $cCup->GetDetailedGameCups( $iGameId );
			}break;
					
			
			case 'get_detailed_cups':
			{
				# wparam => game_id
				global $gl_oVars;
				$iGameId	= (int)$wparam;
				
				$cCup = new Cup( $gl_oVars->cDBInterface );
				return $cCup->GetDetailedGameCups( $iGameId );
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
			
			/*
				$result = cmod_sendmessage( $oMatch->cmod_id, 'match_second_report', $oMatch, $pMyPart->participant_id, $oMatch->participant_type );
				$result = cmod_sendmessage( $oMatch->cmod_id, 'match_first_report', $oMatch, $oMatchResults, $pMyPart->participant_id );
			*/
			
			
			
			case 'match_info':
			{
				
				return 1;
			}break;
			
			
			case 'match_entityid_check':
			{
				// $wparam : cup_id (entity_id)
				global $gl_oVars;
				
				$iCupId = (int)$wparam;
				
				$cCup = new Cup( $gl_oVars->cDBInterface, $iCupId );
				$oCup = $cCup->GetData();
				
				
								
				return 1;
			}
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'match_first_report':
			{
				
				//echo "REPORT_ID: ".$data->report_id;
				return 1;
			}break;
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'match_second_report':
			{
				global  $gl_oVars;
				$cCup = new Cup( $gl_oVars->cDBInterface, NULL );
			
				if( $data->report_state == 'accept' )
				{
					# fetch encount (current) 
					$oEncount = $cCup->GetEncountByMatchId( $data->oMatch->id );
					
					# fetch cup data for evaluation
					$oCup = $cCup->GetCup($oEncount->cup_id);
					
					
					# set evaluation
					if( $data->oMatchResults->total_challenger_score > $data->oMatchResults->total_opponent_score )
					{
						# challer as winner
						$cCup->EvaluateMatchEncount( $oCup, $data->oMatch->id, true, false );
						
						# -----------------------
						$data->oMatchUpdate->evaluated = 1;
						$data->oMatchUpdate->evaluate_time = EGL_TIME;
						
						# PUNKTE VERGABE
					}
					else if( $data->oMatchResults->total_challenger_score < $data->oMatchResults->total_opponent_score )
					{
						# opponent as winner
						$cCup->EvaluateMatchEncount( $oCup, $data->oMatch->id, false, true );
						
						
						# -----------------------
						$data->oMatchUpdate->evaluated = 1;
						$data->oMatchUpdate->evaluate_time = EGL_TIME;
						
						# PUNKTE VERGABE
						
					}
					else
					{
						# no one gewonnen ... shit :PP
						echo "Error: Please contact webadminstrator!";
					}//if
					
				}//if
				
				
				else if( $data->report_state == 'deny' )
				{
					#echo "dann hal tnicht :)";
					# mache nichts, warte bis admin das regelt :P
				}
				
				return 1;
			}break;
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'match_evaluate':
			{
				/*****
					$data		<class match_report_t>
					$wparam 	NULL
					$lparam		NULL
				*****/
				
				global  $gl_oVars;
				$cCup = new Cup( $gl_oVars->cDBInterface, NULL );
				
			
				# fetch encount (current) 
				$oEncount = $cCup->GetEncountByMatchId( $data->oMatch->id );
				
				# fetch cup data for evaluation
				$oCup = $cCup->GetCup($oEncount->cup_id);
					
				# set evaluation
				if( $data->oMatchResults->total_challenger_score > $data->oMatchResults->total_opponent_score )
				{
					# challer as winner
					$cCup->EvaluateMatchEncount( $oCup, $data->oMatch->id, true, false );
					
					# -----------------------
					$data->oMatchUpdate->evaluated = 1;
					$data->oMatchUpdate->evaluate_time = EGL_TIME;
					
					# PUNKTE VERGABE
				}
				else if( $data->oMatchResults->total_challenger_score < $data->oMatchResults->total_opponent_score )
				{
					# opponent as winner
					$cCup->EvaluateMatchEncount( $oCup, $data->oMatch->id, false, true );
					
						
					# -----------------------
					$data->oMatchUpdate->evaluated = 1;
					$data->oMatchUpdate->evaluate_time = EGL_TIME;
					
					# PUNKTE VERGABE
					
				}//if
				else 
				{
					# Keiner gewonnen ?	
				}
								
				return 1;
			}break;
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'match_revoke_evaluation':
			{
								
				return 0;
			}break;
		
			/*
			case 'match_revolk_administration':
			{
				return 1;
			}break;*/
			
			
			case 'page_init':
			{
								
				
			}break;
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#   Input: 	$data =>  RelDir
			#			$wparam => $page_tpl
			#			$lparam => $gl_oVars->bModuleActivated
			#  Output:  *true/false
			#-----------------------------------------------------------------------------------------------------
			case 'exec_template':
			{
				global $gl_oVars;
				
				/*
					$data =>  workspace
					$wparam => $page_tpl
					$lparam => $gl_oVars->bModuleActivated
				*/
				
				return  true;
			}break;
			
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'exec_document':
			{
				
				
				return 1;
			}break;
			
			
			case 'exec_admin_module':
			{
				
				
				return 1;
			}break;
			
			
			# ----------------------
			# Kommunication Template/Page <=> Module
			# ----------------------
			
			
			case 'get_admin_links':
			{
				
				$aLinkPool = array();
				
				# get module ID
				$ID = $this->oInfos->ID;
				
				$aLinkPool[sizeof($aLinkPool)] = new module_link_t( 'Cups', 	"{\$url_file}page={$ID}:admin.cuplist" );


				# save in output
				$data = $aLinkPool;
				return 1;				
				
			}break;
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			# multiplayer (team)
			case 'get_team_links':
			{
				
				/*
				$aLinkPool = array();
				
				# get cmod ID
				$ID = $this->oInfos->ID;
				
				$aLinkPool[sizeof($aLinkPool)] = new module_link_t( 'Upcoming Cups', 	"{\$url_file}page=$ID:team_join");
				#$aLinkPool[sizeof($aLinkPool)] = new cmod_link_t( 'Gespielte Cups', 	"{\$url_file}cmod=$cmID&page=cup.tree&cup_id=1" );
				#$aLinkPool[sizeof($aLinkPool)] = new cmod_link_t( 'Offene Matches', 	"{\$url_file}page=match.list&_cmid=$cmID" );
				

				# save in output
				$data = $aLinkPool;*/
				return array();
			}break;
			

			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			# single player (member)
			case 'get_member_links':
			{
				/*'
				global $gl_oVars;
				
				$aLinkPool = array();
				
				# get cmod ID
				$ID = $this->oInfos->ID;
				
				$aLinkPool[sizeof($aLinkPool)] = new module_link_t( 'Upcoming Cups', 			"{\$url_file}page=$ID:member_join" );
				#$aLinkPool[sizeof($aLinkPool)] = new module_link_t( 'Gespielte Cups', 		"{\$url_file}cmod=$cmID&page=cup.tree&cup_id=1" );
				#$aLinkPool[sizeof($aLinkPool)] = new module_link_t( 'Offene Matches', 		"{\$url_file}page=match.list&member_id=".$gl_oVars->iMemberId."&_cmid=$cmID" );
				

				# save in output
				$data = $aLinkPool;
				return 1;*/
				return array();
			}break;
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			# attachments on team.info..  => templates
			case 'template_attachment':
			{
				/**
				 * $wparam 	=> workspace
				 * $lparam  => page
				 * 
				 */
				
				global $gl_oVars;
				$workspace = $wparam;
				$page = $lparam;

				
				# -------------------------------------------------------------------------------------
				# ATTACHED: member.info
				# -------------------------------------------------------------------------------------
				if( $workspace == 'hp' && $page == 'member.info' )
				{
					# fetch data for attachment
					$aCups		= array();
					$iParttype 	= PARTTYPE_MEMBER;
					$iPartId	= (int)$_GET['member_id'];
					
				
					// declare cup
					$cCup = new Cup( $gl_oVars->cDBInterface, NULL );	
					
					$aCupsPlayed  = $cCup->GetPaticipantCups( $iPartId, $iParttype );
					$aCupsEntered = $cCup->GetEnteredCups( $iPartId, $iParttype );
				
					
					for( $cup=0; $cup < sizeof($aCupsPlayed); $cup++ )
					{
						$winner_match_count = $aCupsPlayed[$cup]->roundwinner_sum/$iPartId;
						/* -1 => da letzte begegnung nur als WINNER angabe vorhanden ist */
						
						
						if( isint($winner_match_count) && $winner_match_count-1 == (log($aCupsPlayed[$cup]->max_participants)/log(2)) )
						{
							#echo "test";
							$aCupsPlayed[$cup]->is_winner = 1;
						}
						else
						{
							/* ADD +1 => real round */
							#$aCupsPlayed[$cup]->lost_round = (int)($aCupsPlayed[$cup]->roundwinner_sum/$iPartId)+1;
						}//if
					} //for
					
					
					
					# set variables to attachment
					$gl_oVars->cTpl->assign( 'attach_cupsplayed', 		$aCupsPlayed );
					$gl_oVars->cTpl->assign( 'attach_cupsentered', 		$aCupsEntered );
					$gl_oVars->cTpl->assign( 'attach_participant_id', 	$iPartId );
	
					//$gl_oVars->cTpl->assign( 'ATTACH_MODULE_ID', 		$this->oInfos->ID );
					
					return array( 'template_file' => 'cup_details.tpl' );
				}
				# -------------------------------------------------------------------------------------
				# ATTACHED: team.info
				# -------------------------------------------------------------------------------------
				elseif( $workspace == 'hp' && $page == 'team.info' )
				{
					
					# fetch data for attachment
					$aCups		= array();
					$iParttype 	= PARTTYPE_TEAM;
					$iPartId	= (int)$_GET['team_id'];
					
				
					$cCup = new Cup( $gl_oVars->cDBInterface, NULL );	
				
					
					$aCupsPlayed  = $cCup->GetPaticipantCups( $iPartId, $iParttype );
					$aCupsEntered = $cCup->GetEnteredCups( $iPartId, $iParttype );
				
					
					for( $cup=0; $cup < sizeof($aCupsPlayed); $cup++ )
					{
						# cumpute the count of matches won
						$winner_match_count = $aCupsPlayed[$cup]->roundwinner_sum/$iPartId;
						
						if( isint($winner_match_count) && $winner_match_count == (log($aCupsPlayed[$cup]->max_participants)/log(2)) )
						{
							$aCupsPlayed[$cup]->is_winner = 1;
						}
						else
						{
							/* ADD +1 => real round */
							# $aCupsPlayed[$cup]->lost_round = (int)($aCupsPlayed[$cup]->roundwinner_sum/$iPartId)+1;
						}//if
					} //for
					
					
					# set variables to attachment
					$gl_oVars->cTpl->assign( 'attach_cupsplayed', 		$aCupsPlayed );
					$gl_oVars->cTpl->assign( 'attach_cupsentered', 		$aCupsEntered );
					$gl_oVars->cTpl->assign( 'attach_participant_id', 	$iPartId );
									
					//$gl_oVars->cTpl->assign( 'ATTACH_MODULE_ID', 		$this->oInfos->ID );
					return array( 'template_file' => 'cup_details.tpl' );
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
				$cCup = new Cup( $gl_oVars->cDBInterface, NULL );
				
				$participant_id		= $wparam;	# overgiven by engine
				$participant_type	= $lparam;	# overgiven by engine
				
				
				/* SET LIMIT*/
				
				
				$aCups = $cCup->GetCupEntries( $participant_id, $participant_type );
				
				
				$aEntries = array();
				for( $i=0; $i < sizeof($aCups); $i++ )
				{
					$pEntry = &$aEntries[sizeof($aEntries)];
					$pEntry = new module_entry_t;
					$pEntry->sName 	= $aCups[$i]->name;
					$pEntry->Id 	= $aCups[$i]->id;
				}//for
				
				return $aEntries;
			}break;
			
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'match_list':
			{
				global $gl_oVars;
				$cCup = new Cup( $gl_oVars->cDBInterface, NULL );

				
				$cup_id				= $data->entry_id; /* entry_id */
				$participant_id		= $data->part_id;	# overgiven by engine
				$participant_type	= $data->part_type;	# overgiven by engine
				$status				= NULL;
				
				if( $status == 'all' ) $data->status = NULL;
				if( $status == 'open' ) $data->status = MATCH_RUNNING;
				if( $status == 'closed' ) $data->status = MATCH_CLOSED;
					
				
				# fetch matches
				$aMatches = $cCup->GetCupMatches( $cup_id, $participant_id, $participant_type, $status );
				
				//echo nl2br( print_r( $aMatches, 1));
				echo mysql_error();
				return $aMatches;

				/*
				
				$id_list = array();
				for( $i=0; $i < sizeof($aMatches); $i++ )
				{
					# ON Member => add only no id of yoursel, because the data is avaiable !!
					if( $participant_type == PARTTYPE_MEMBER )
					{
						# add id's to ID-LIST, without 
						if( $aMatches[$i]->challenger_id == $participant_id ) 	$id_list[sizeof($id_list)] = $aMatches[$i]->opponent_id;
						if( $aMatches[$i]->opponent_id == $participant_id ) 	$id_list[sizeof($id_list)] = $aMatches[$i]->challenger_id;
					}
					# ON Team => add both IDS, because you don't have data about yourself
					else if( $participant_type == PARTTYPE_TEAM )
					{
						$id_list[sizeof($id_list)] = $aMatches[$i]->opponent_id;
						$id_list[sizeof($id_list)] = $aMatches[$i]->challenger_id;
					}
					# if team
				}//for

				
				
				# filter doublicates
				# ---------------------------------------------				
				
				$tmp_idlist = array();
				for( $j=0; $j < sizeof($id_list); $j++ )
				{
					for( $k=0; $k < sizeof($tmp_idlist); $k++ )
						if( $id_list[$j] == $tmp_idlist[$k] )
							break;
					if( $k == sizeof($tmp_idlist) )
						$tmp_idlist[sizeof($tmp_idlist)] = $id_list[$j];
				}//for
				
						
				# save new id-list
				$id_list = $tmp_idlist;
				
				
				#==============================================================================
				# Fetch challenger/opponent data for matches	| MEMBERS
				#==============================================================================
				if( $participant_type == PARTTYPE_MEMBER )
				{
					$aMembers 	= $gl_oVars->cMember->__GetMemberListData( db_create_array_string( $id_list ) );
					$oMyself	= $gl_oVars->oMemberData;			
						
					
					# Deutsch:
					#----------
					#Hier ist es wichtig, welche participant_id genutzt wird, da die eigenen Daten ($oMyself) vorhanden sind 
					#und  die anderen NICHT !!!
					#
					#
					
					
					# sort memberdata to each match
					for( $match=0; $match < sizeof($aMatches); $match++ )
					{
						$bIsChallenger = false;
						
						# myself => challenger ??
						if( $aMatches[$match]->challenger_id == $participant_id )
						{
							$aMatches[$match]->challenger_name = $oMyself->nick_name;
							$bIsChallenger = true;
						}
						
						# myself => opponent ??
						else if( $aMatches[$match]->opponent_id == $participant_id )
						{
							$aMatches[$match]->opponent_name = $oMyself->nick_name;
						}
						
						# search other  participant(-match)
						for( $member=0; $member < sizeof($aMembers); $member++ )
						{
							if( $bIsChallenger )
							{
								if( $aMembers[$member]->participant_id == $aMatches[$match]->opponent_id )
								{
									$aMatches[$match]->opponent_name = $aMembers[$member]->participant_name;
								}
							}
							else
							{
								if( $aMembers[$member]->participant_id == $aMatches[$match]->challenger_id )
								{
									$aMatches[$match]->challenger_name = $aMembers[$member]->participant_name;
								}//if
							}//if
							
						}//for
						
						
						if( $aMatches[$match]->challenger_id == EGL_NO_ID ) $aMatches[$match]->challenger_name = "Unknown";
						if( $aMatches[$match]->opponent_id == EGL_NO_ID ) $aMatches[$match]->opponent_name = "Unknown";
					}//for
					
					
				}
				#==============================================================================
				# Fetch challenger/opponent data for matches		| TEAMS
				#==============================================================================
				else if( $participant_type == PARTTYPE_TEAM )
				{
					if( sizeof($id_list) > 0 )
					{
						
						# get ID of myself (team.id/,`clan.id`)
						$aTeams 	= $gl_oVars->cMember->GetClanlistData( db_create_array_string( $id_list ) );
						$oMyself	= NULL;
						
						# try selecting data of myself					
						for( $i=0; $i < sizeof($aTeams); $i++ )
						{
							if( $aTeams[$i]->participant_id == $participant_id )
								$oMyself = $aTeams[$i];
						}
						
						# ERROR
						if( !$oMyself )
						{
							echo "ERROR!";
							DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't find \$oMyself in a Matchlist!" );
							return 0;
						}
					
						# set opponent & challenger data to each match
						for( $match=0; 	$match < sizeof($aMatches); $match++ )
						{
							for( $team=0; $team < sizeof($aTeams); $team++ )
							{
								if( $aTeams[$team]->participant_id == $aMatches[$match]->challenger_id )
								{
									$aMatches[$match]->challenger_name 					= $aTeams[$team]->participant_name;
									$aMatches[$match]->challenger_clan_name 			= $aTeams[$team]->participant_clan_name;
									$aMatches[$match]->challenger_clan_tag 				= $aTeams[$team]->participant_clan_tag;
									$aMatches[$match]->challenger_clan_id 				= $aTeams[$team]->participant_clan_id;
									$aMatches[$match]->challenger_logo_file			 	= $aTeams[$team]->participant_logo_file;
									$aMatches[$match]->challenger_country_id 			= $aTeams[$team]->country_id;
									$aMatches[$match]->challenger_country_name 			= $aTeams[$team]->country_name;
									$aMatches[$match]->challenger_country_image_file 	= $aTeams[$team]->country_image_file;
								}
								else if( $aTeams[$team]->participant_id == $aMatches[$match]->opponent_id )
								{
									$aMatches[$match]->opponent_name 					= $aTeams[$team]->participant_name;
									$aMatches[$match]->opponent_clan_name 				= $aTeams[$team]->participant_clan_name;
									$aMatches[$match]->opponent_clan_tag 				= $aTeams[$team]->participant_clan_tag;
									$aMatches[$match]->opponent_clan_id 				= $aTeams[$team]->participant_clan_id;
									$aMatches[$match]->opponent_logo_file			 	= $aTeams[$team]->participant_logo_file;
									$aMatches[$match]->opponent_country_id 				= $aTeams[$team]->country_id;
									$aMatches[$match]->opponent_country_name 			= $aTeams[$team]->country_name;
									$aMatches[$match]->opponent_country_image_file 		= $aTeams[$team]->country_image_file;
								}//if
							}//for $team
							
							if( $aMatches[$match]->challenger_id == EGL_NO_ID ) $aMatches[$match]->challenger_name = "Unknown";
							if( $aMatches[$match]->opponent_id == EGL_NO_ID ) $aMatches[$match]->opponent_name = "Unknown";
						}//for $match
					
					} // if anz. Matches > 0
					
					
				}//elseif
				return $aMatches;
				*/
			}break;
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose: Zust�ndig, ob ein Member (abh�ngig von den Admin-Permissions) auf das match adminrechte hat
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'match_access':
			{
				# $data 	=> matchdata
				# $wparam	=> match_id
				/*
				global $gl_oVars;
				
				$iMatchId	= $wparam;	# => match_id
				
				
				# define sql_query
				$sql_query	= 	" SELECT * ".
								" FROM ".$GLOBALS['g_egltb_cup_encounts']." AS encounts ".
								" LEFT JOIN ".$GLOBALS['g_egltb_cups']." AS cups ".
								" ON encounts.cup_id=cups.id".
								" LEFT JOIN ".$GLOBALS['g_egltb_matches']." AS matches ".
								" ON encounts.match_id=matches.id ".
								" WHERE matches.id=$iMatchId " ;
				
				$obj = $gl_oVars->cDBInterface->FetchObject( $gl_oVars->cDBInterface->Query( $sql_query ) );
				if( $obj ) return PAGEACCESS_OK;
				*/
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
					case 'admin.cup':
					{
						$iCupId = (int)$_GET['cup_id'];
						
						$num_admin_perms = sizeof($acModAdmin);
						
						for( $i=0; $i < $num_admin_perms; $i++ )
							if( $iCupId == $acModAdmin[$i]->data )
							{
								return PAGEACCESS_OK;
							}
						
						
					}break;
					default:
					{
					}break;
				}
				
				
				return PAGEACCESS_FAILED;
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