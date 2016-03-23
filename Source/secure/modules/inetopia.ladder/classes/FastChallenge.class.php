<?php
# ================================ Copyright (c) 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


/**
 * 
 *
 * @copyright 	Inetopia
 * @author		Inetopia <support@inetopia.de>
 * @package 	EGL.Module.FastChallenge
 **/
 
DBTB::RegisterTB( 'LADDER', 'FAST_CHALLENGE_POOL',		'egl_ladder_fastchallenge_pool' );
 
 
class FastChallenge
{
	# -[ variables ]-
	var $pDBInterfaceCon;			# pointer to current mysql object 
	
	# -[ functions ]-

	
	/**
	 * Constructor, class InetopiaLadder
	 *
	 * @param	DBConnection		Pointer to global DB-Connection interface
	 * @return	void				no results
	 **/
	function FastChallenge (&$pDBCon)
	{
		$this->pDBInterfaceCon = NULL;
		
		# save reference
		$this->pDBInterfaceCon = &$pDBCon;
	}//function
	
	
	
	/**
	 * adding new participant to fastchallenge pool
	 *
	 * @param	$obj				array-object
	 * @return	true/false			no results
	 **/
	function AddParticipantToFastChallengePool( $obj )
	{
		if( $this->pDBInterfaceCon->Query ( $this->pDBInterfaceCon->CreateInsertQuery( DBTB::GetTB('LADDER','FAST_CHALLENGE_POOL'), $obj ) ) )
			return $this->pDBInterfaceCon->InsertId();
		return NULL;
	}
	
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $ladder_id
	 */
	function DeleteParticipantFromPool( $pool_participant_id )
	{
		$sql_query = "DELETE FROM `".DBTB::GetTB('LADDER','FAST_CHALLENGE_POOL')."` WHERE id=".(int)$pool_participant_id."";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
	
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $ladder_id
	 */
	function ClearPool( $ladder_id )
	{
		$sql_query = "DELETE FROM `".DBTB::GetTB('LADDER','FAST_CHALLENGE_POOL')."` WHERE ladder_id=".(int)$ladder_id."";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
	
	
	/**
	 * FastChallenge::IsParticipantInPool()
	 * 
	 */
	function GetParticipantInPool( $participant_id, $ladder_id ){
		$sql_query = 	" SELECT * ".
						" FROM `".DBTB::GetTB('LADDER', 'FAST_CHALLENGE_POOL')."` AS fc_pool ".
						" WHERE fc_pool.participant_id=".(int)$participant_id." && fc_pool.ladder_id=".(int)$ladder_id;
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ));
	}
	
	/**
	 * FastChallenge::IsParticipantInPool()
	 * 
	 */
	function GetNumParticipantsFromPool( $ladder_id ){
		$sql_query = 	" SELECT COUNT(*) AS num_participants ".
						" FROM `".DBTB::GetTB('LADDER', 'FAST_CHALLENGE_POOL')."` AS fc_pool ".
						" WHERE fc_pool.ladder_id=".(int)$ladder_id;
		$obj = $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ));
		return $obj->num_participants;
	}	
	
	/**
	 * FastChallenge::IsParticipantInPool()
	 * 
	 */
	function GenerateMatchesFromPool( $ladder_id ){
		global $gl_oVars;

		$mod_root = $gl_oVars->cModuleManager->GetModuleRoot( 'A9CCDCBF-C696-422c-A0D8-91223A9C22E6' );
		$mod_root .= 'templates'.EGL_DIRSEP.'emails'.EGL_DIRSEP;
		$cMails = new Mails( $gl_oVars->sLanguage, $mod_root );
		
		
		$cLadder = new InetopiaLadder( $this->pDBInterfaceCon );
		$cMatchStructures = new MatchStructures( $this->pDBInterfaceCon );
		$cMatch = new Match( $this->pDBInterfaceCon );
		
		$oLadder = $cLadder->GetLadderbyID( (int)$ladder_id );
		if( $oLadder ){
			$sql_query='';
			if( $oLadder->participant_type == PARTTYPE_MEMBER ){
				$sql_query = 	" SELECT fc_pool.* ".
								" FROM `".DBTB::GetTB('LADDER','FAST_CHALLENGE_POOL')."` AS fc_pool, `".DBTB::GetTB( 'GLOBAL','EGL_MEMBERS')."` members ".
								" WHERE ladder_id=".(int)$ladder_id." && members.id=fc_pool.participant_id ".
								" ORDER BY created ASC ";
			}
			else if( $oLadder->participant_type == PARTTYPE_TEAM ){
				$sql_query = 	" SELECT fc_pool.* ".
								" FROM `".DBTB::GetTB('LADDER','FAST_CHALLENGE_POOL')."` AS fc_pool, `".DBTB::GetTB( 'GLOBAL','EGL_TEAMS')."` teams ".
								" WHERE ladder_id=".(int)$ladder_id." && teams.id=fc_pool.participant_id ".
								" ORDER BY created ASC ";
			}
			else{
				return 1;
			}
			$aFastChallengePool = $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
			$oMatchStructure = $cMatchStructures->GetMatchStructure( $oLadder->matchstructure_id );
			// match strukture

			if( $oMatchStructure )
			{
				
				// new generated encounts
				$aEncounts = array();
				
				//....
				if( sizeof($aFastChallengePool) == 0 ){
					// nur einer  im pool
					//echo "<br/> Keine spieler eingetragen";
				}
				else if( sizeof($aFastChallengePool) == 1 ){
					// nur einer  im pool
					//echo "<br/> schick mail an .." . $aFastChallengePool[0]->participant_id;
					
					//$cMails->AssignVar( '', '' );
					//$cMails->SendeMail( 'file', 'title', 'email' );
				}
				else{
					
					$iMatchCount = 0;
					
					// generate matches
					for( $i=0; $i < sizeof($aFastChallengePool)-1; $i+=2 ){
						$match_obj	 = array( 	'module_id'			=> 'A9CCDCBF-C696-422c-A0D8-91223A9C22E6',
												'module_entry_id'	=> $ladder_id,
												'participant_type'	=> $oLadder->participant_type,
												'matchstructure_id'	=> $oLadder->matchstructure_id,
												'status'			=> MATCH_RUNNING,
												'challenger_id'		=> $aFastChallengePool[$i]->participant_id,
												'opponent_id'		=> $aFastChallengePool[$i+1]->participant_id,
												'winner_id'			=> EGL_NO_ID,
												'report_id'			=> EGL_NO_ID,
												'num_rounds'		=> $oMatchStructure->num_rounds,
												'num_maps'			=> $oMatchStructure->num_maps,
												'round_names'		=> $oMatchStructure->round_names,
												'maps'				=> $oMatchStructure->maps,
												'challenge_time'	=> EGL_TIME,
												'created'			=> EGL_TIME,
											);
											
						if( $cMatch->AddMatch ($match_obj) ){
							$iMatchId = $this->pDBInterfaceCon->InsertId();
							
							// define encount for ladder
							$encount_obj = array( 	'ladder_id'			=> $ladder_id,
													'match_id'			=> $iMatchId,
													'is_fastchallenge'	=> 1,
													'created'			=> EGL_TIME,
												);
							$cLadder->CreateEncount( $encount_obj );
							$iMatchCount++;
							
							// send-email				
							//echo "<br>ENCOUNT: ".$match_obj['challenger_id']." VS. ".$match_obj['opponent_id'];
						}
						
						// delete 
						$this->DeleteParticipantFromPool( $aFastChallengePool[$i]->id );
						$this->DeleteParticipantFromPool( $aFastChallengePool[$i+1]->id );

					}//for
					
					// einer zu viel im pool, schick mail an diesen, schade :)
					if( sizeof($aFastChallengePool) % 2 != 0 ){
						// send mail to last 
						//echo "<br/> schick mail an .." . $aFastChallengePool[sizeof($aFastChallengePool)-1]->participant_id;
						
						//$cMails->AssignVar( '', '' );
						//$cMails->SendeMail( 'file', 'title', 'email' );
						//if( !$cMails->SendeMail( 'fc_no_match_generation.tpl', 'test', 'email' ) ){
						//	echo "error";
					}//if
					else
					{
						// alle teilnehmer im pool sollten einem match zugeordnet 
						$this->ClearPool( $ladder_id );
					}//if
				}//if more than 1 players in pool
			
				$cLadder->UpdateLadder( $ladder_id, array( 'fastchallenge_update'	=> EGL_TIME )  );
				
			}
			else
			{
				// no match-strucutre found
			}	
			
		}
		else
		{
			// no ladder found
		}
		return 0;
	}
	
	
	
	
	/**
	 * GetFastChallengeLadders()
	 * 
	 * 
	 */
	 function GetFastChallengeLadders(){
		$sql_query = 	" SELECT * ".
						" FROM `".DBTB::GetTB('LADDER', 'LADDERS')."` AS ladders ".
						" WHERE ladders.fastchallenge_mode=1 ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ));		 
	 }
};

?>