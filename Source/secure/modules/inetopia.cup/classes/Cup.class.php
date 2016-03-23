<?php
# ================================ Copyright � 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-
define( "PARTTYPE_MEMBER",		1 );
define( "PARTTYPE_TEAM",		2 );



# -[ objectlist ] -
class cup_round_t
{
	var $iRound			= EGL_NO_ID;
	var $aEncounts		= array();
	var $aParticipants 	= array();
};


class cup_part_info_t
{
	var $id				= EGL_NO_ID;
	var $name			= "";
};


class cup_partenc_t		# participant encount
{
	var $match_id			= EGL_NO_ID;
	var $participant_id		= EGL_NO_ID;
	var $participant_name	= "";
	var $is_winner			= false;
};

/*
	Informationstr�ger f�r Gewinner
*/
class cup_rnd_enc_details_t
{
	var $cup_id				= EGL_NO_ID;
	var $loser_id			= EGL_NO_ID;
	var $winner_id			= EGL_NO_ID;
	var $round				= -1;
	var $subindex			= -1;
	var $is_freeticket		= false;
	
	var $participant		= NULL;
};


# -[ class ] -
class Cup
{
	# -[ variables ]-
	var $pDBInterfaceCon= NULL;
	var $oCup			= NULL;
	var $iCupId			= EGL_NO_ID;
	var $aParticipants	= array();
	var $aEncounts		= array();
	var $aPartEncs		= array();
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function Cup ( &$pDBCon, $iId=NULL )
	{
		$this->pDBInterfaceCon 		= &$pDBCon;
		$this->iCupId				= $iId;
	}
	
	
	function GetTBCups() { return 'egl_cups';}
	function GetTBCupParticipants() { return 'egl_cup_participants';}
	function GetTBCupEncounts() { return 'egl_cup_encounts';}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//			
	// Output : 
	//-------------------------------------------------------------------------------	
	function AssignCupData( $round_start, $round_max, $type  )
	{
		if( $round_max == -1 ) $round_max = 9999;
		
		# for members
		if( $type == PARTTYPE_MEMBER )
		{
			$sql_encounts = 	" SELECT cup_enc.id, cup_enc.is_freeticket, cup_enc.match_id, cup_enc.challenger_id, cup_enc.opponent_id,cup_enc.winner_id, cup_enc.subindex, cup_enc.round, memb.id AS participant_id,memb.nick_name AS participant_name,memb.country_id AS participant_country_id ".
								" FROM ".$GLOBALS["g_egltb_cup_encounts"]." AS cup_enc ".
								" LEFT JOIN ".$GLOBALS["g_egltb_members"]." AS memb ".
								" ON (cup_enc.challenger_id=memb.id || cup_enc.opponent_id=memb.id ) ".
								" WHERE cup_id=".$this->iCupId." AND round >= $round_start AND round < ".($round_start+$round_max+1)." ".
								" ORDER BY round ASC, subindex ASC ";
		}
		else if( $type = PARTTYPE_TEAM )
		{
			/*
				-- clan_acc.country_id --
			*/
			$sql_encounts = 	" SELECT cup_enc.id, cup_enc.is_freeticket, cup_enc.match_id, cup_enc.challenger_id, cup_enc.opponent_id,cup_enc.winner_id, cup_enc.subindex, cup_enc.round, teams.country_id AS participant_country_id, teams.id AS participant_id,teams.name AS participant_name, clan_acc.name AS participant_clan_name, clan_acc.tag AS participant_clan_tag, clan_acc.id AS participant_clan_id ".	#, clan_acc.country_id AS participant_country_id
								" FROM ".$GLOBALS["g_egltb_cup_encounts"]." AS cup_enc ".
								" LEFT JOIN ".$GLOBALS['g_egltb_teams']." AS teams ".
								" ON (cup_enc.challenger_id=teams.id || cup_enc.opponent_id=teams.id ) ".
								" LEFT JOIN ".$GLOBALS['g_egltb_clan_accounts']." AS clan_acc ".
								" ON (clan_acc.id=teams.clan_id) ".
								" WHERE cup_id=".$this->iCupId." AND cup_enc.round >= $round_start AND cup_enc.round < ".($round_start+$round_max+1)." ".
								" ORDER BY round ASC, subindex ASC ";
		}

		
		$aEncounts = $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_encounts ) );
		
		# for clans
		//....
		
		/*
			format:
			-----------
			Encounts array[1...max_round][1..match]
			Participants  array[1..members]
			
		*/

		
				
		$a_OrderedEncounts 	= array();
		$aParicipants 		= array();
		$aEnCountMatches	= array();
		$aCountrylist		= array();
		
		
		

		# -----------------------------------------
		# Sort Encounts to the right round index !!
		# -----------------------------------------
		

		for( $m=0; $m < sizeof($aEncounts); $m++ )
		{
			$_index = $aEncounts[$m]->round-$round_start;
			#$_index = sizeof($a_OrderedEncounts);
			
			# current encount in list ?
			for( $r=0; $r < sizeof($a_OrderedEncounts[$_index]); $r++ )
				if( $a_OrderedEncounts[$_index][$r]->id == $aEncounts[$m]->id )
					break;
					
			##NO ? => ADD
			if( $r == sizeof($a_OrderedEncounts[$_index]) )
				$a_OrderedEncounts[$_index][sizeof($a_OrderedEncounts[$_index])] = $aEncounts[$m];
		}
		
		

		
		
		

		# ---------------------------------------
		# filter member data to buffer from all $aEncounts
		# ---------------------------------------
		for( $i=0; $i < sizeof($aEncounts); $i++ )
		{
			for( $_m=0; $_m < sizeof($aEncounts); $_m++ )
			{
				if( $aEncounts[$i]->participant_id == $aParicipants[$_m]->id )
			 		break;
			}
			 		
			#
			if( $_m == sizeof($aEncounts))
			{
				$pParticipant = &$aParicipants[sizeof($aParicipants)];
				$pParticipant = new cup_part_info_t;
				
				$pParticipant->id 			= $aEncounts[$i]->participant_id;
				$pParticipant->name 		= $aEncounts[$i]->participant_name;
				$pParticipant->winner_id 	= $aEncounts[$i]->winner_id;
				$pParticipant->encount_id 	= $aEncounts[$i]->id;
				$pParticipant->match_id 	= $aEncounts[$i]->match_id;
				$pParticipant->challenger_id= $aEncounts[$i]->challenger_id;
				$pParticipant->opponent_id	= $aEncounts[$i]->opponent_id;
				
		
				$pParticipant->clan_name 	= $aEncounts[$i]->participant_clan_name;
				$pParticipant->clan_tag 	= $aEncounts[$i]->participant_clan_tag;
				$pParticipant->clan_id 		= $aEncounts[$i]->participant_clan_id;
				$pParticipant->country_id 	= $aEncounts[$i]->participant_country_id;
			
				
				#echo "<br>".$aEncounts[$i]->participant_name;
			}//if
			
		}//for
		
	
		$this->aEncounts = $a_OrderedEncounts;
		$this->aParticipants = $aParicipants;
		
		
		
		

		# to each round
		for( $r=0; $r < sizeof($this->aEncounts); $r++ )
		{
			$this->aPartEncs[$r] = array();
			
			# to each member of round
			for( $enc=0; $enc < sizeof($this->aEncounts[$r]); $enc++ )
			{
				
				$pPart 				= $this->aEncounts[$r][$enc]; 
				$pParEncTop 		= &$this->aPartEncs[$r][sizeof($this->aPartEncs[$r])];
				$pParEncBottom 		= &$this->aPartEncs[$r][sizeof($this->aPartEncs[$r])];
				
				
				# add top member
				# seatch top
				
				$pParEncTop = new cup_partenc_t;
				$pParEncTop->match_id 		= $pPart->match_id;
				$pParEncTop->winner_id 		= $pPart->winner_id;
				
				$pParEncBottom = new cup_partenc_t;
				$pParEncBottom->match_id 	= $pPart->match_id;
				$pParEncBottom->winner_id 	= $pPart->winner_id;
				

				$bTopFound	= false;
				$bBottomFound = false;
				for( $m=0; $m < sizeof($this->aParticipants); $m++ )
				{
					# add top
					if( $pPart->challenger_id == $this->aParticipants[$m]->id )
					{

						$pParEncTop->participant_id 			= $this->aParticipants[$m]->id;
						$pParEncTop->participant_name 			= $this->aParticipants[$m]->name;
						$pParEncTop->participant_clan_name	 	= $this->aParticipants[$m]->clan_name;
						$pParEncTop->participant_clan_tag 		= $this->aParticipants[$m]->clan_tag;
						$pParEncTop->participant_clan_id 		= $this->aParticipants[$m]->clan_id;
						$pParEncTop->participant_country_id		= $this->aParticipants[$m]->country_id;
						$pParEncTop->participant_encount_id 	= $this->aParticipants[$m]->encount_id;
						$pParEncTop->participant_match_id 		= $this->aParticipants[$m]->match_id;
						$pParEncTop->participant_challenger_id 	= $this->aParticipants[$m]->challenger_id;
						$pParEncTop->participant_opponent_id 	= $this->aParticipants[$m]->opponent_id;
						
						
						if( $pPart->is_freeticket ) 
							$pParEncTop->is_freeticket 		= true;
						
						#echo "<br>ClanName: ".$this->aParticipants[$m]->clan_tag;
						if( $pPart->winner_id == $pParEncTop->participant_id )
						{
							$pParEncTop->is_winner = true;
						}//if
						$bTopFound = true;
					}//if

					
					# add bottom
					if( $pPart->opponent_id == $this->aParticipants[$m]->id )
					{
						$pParEncBottom->participant_id 				= $this->aParticipants[$m]->id;
						$pParEncBottom->participant_name 			= $this->aParticipants[$m]->name;
						$pParEncBottom->participant_clan_name 		= $this->aParticipants[$m]->clan_name;
						$pParEncBottom->participant_clan_tag 		= $this->aParticipants[$m]->clan_tag;
						$pParEncBottom->participant_clan_id 		= $this->aParticipants[$m]->clan_id;
						$pParEncBottom->participant_country_id	 	= $this->aParticipants[$m]->country_id;
						$pParEncBottom->participant_encount_id	 	= $this->aParticipants[$m]->encount_id;
						$pParEncBottom->participant_match_id 		= $this->aParticipants[$m]->match_id;
						$pParEncBottom->participant_challenger_id 	= $this->aParticipants[$m]->challenger_id;
						$pParEncBottom->participant_opponent_id 	= $this->aParticipants[$m]->opponent_id;
						
						if( $pPart->is_freeticket ) 
							$pParEncBottom->is_freeticket 	= true;
						
						#echo "<br>ClanName: ".$this->aParticipants[$m]->clan_tag;
						if( $pPart->winner_id == $pParEncBottom->participant_id )
						{
							$pParEncBottom->is_winner = true;
						}//if
						$bBottomFound = true;
					}//if
					
				}//for
				
				
			}//for
		}//for
		
		/*
		for( $i=0; $i < $round_start; $i++ )
		{
			DeleteItemOfArray( $this->aPartEncs, 0 );
		}*/
		
		#echo str_replace( ' ', '&nbsp;', nl2br( print_r( $this->aPartEncs, 1 )));
		#echo str_replace( ' ', '&nbsp;', nl2br( print_r( $this->aEncounts, 1 )));
		
		#DeleteItemOfArray( $this->aEncounts, 0 );
			/*	
		#DeleteItemOfArray( $this->aPartEncs, 0 );
		#echo str_replace( ' ', '&nbsp;', nl2br( print_r( $this->aPartEncs, 1 )));
		#exit;
		*/
		return 1;
	}// AssignData
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------	
	function CreateCupMatches( $type, $cup_id, $numMembers )
	{
		$numMembers;
		$numRounds = (log($numMembers)/log(2))+1;
		
		for( $i=0; $i < $numRounds;  $i++ )
		{
			$nMembers = pow( 2, ($numRounds) - $i);
			$nMatches = $nMembers/2;
			
			for( $m=0; $m < $nMatches; $m++ )
			{
				$obj = NULL;
					
				$obj->cup_id 	= $cup_id;
				$obj->type_id 	= $type;
				$obj->round 	= $i;
				$obj->subindex 	= $m;
				$obj->created 	= EGL_TIME;
				
				$this->pDBInterfaceCon->Query ( $this->pDBInterfaceCon->CreateInsertQuery( $GLOBALS['g_egltb_cup_matches'], $obj ) );	
					
			}//for
		}//for
		
		return true;
	}
	
	
	
	/**
	* Cup::GetCup()
	*
	*/	
	function GetCup( $cup_id )
	{
		$sql_query = "SELECT * FROM `".$GLOBALS['g_egltb_cups']."` WHERE id=$cup_id";
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query )); 
	}
	
	
	/**
	* Cup::GetDetailedCup()
	*
	*/
	function GetDetailedCup( $cup_id )
	{
		$sql_query = 	" SELECT cups.*, COUNT(parts.id) AS num_participants ".
						" FROM `".$GLOBALS['g_egltb_cups']."` AS cups ".
						" LEFT JOIN `".$GLOBALS['g_egltb_cup_participants']."` AS parts ".
						" ON cups.id=parts.cup_id ".
						" WHERE cups.id=$cup_id ".
						" GROUP BY parts.cup_id ";
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query )); 
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: create a list of particiapants accordingly to cup_id
	// Output : array of participant-ids
	//-------------------------------------------------------------------------------			
	function GetCupParticipants( $cup_id )
	{
		$sql_query = "SELECT * FROM `".$GLOBALS['g_egltb_cup_participants']."` WHERE cup_id=$cup_id";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query )); 	
	}

	
	//-------------------------------------------------------------------------------
	// Purpose: create a list of particiapants accordingly to cup_id
	// Output : array of participant-ids
	//-------------------------------------------------------------------------------			
	function GetNumCupParticipants( $cup_id )
	{
		$sql_query = 	" SELECT COUNT(*) AS num_participants ".
						" FROM `".$GLOBALS['g_egltb_cup_participants']."` as parts".
						" WHERE cup_id=$cup_id".
						" GROUP BY parts.cup_id ";
		$obj = $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ));
		return (int)$obj->num_participants;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------			
	function GetDetailedCupParticipants( $cup_id, $participant_type )
	{
		# --------------------------------------------------------------------
		# select memberdata
		# --------------------------------------------------------------------
		if( $participant_type == PARTTYPE_MEMBER )
		{
			$sql_query	= 	" SELECT members.nick_name AS participant_name, members.id AS participant_id, cup_parts.checked,cup_parts.created,cup_parts.id".
							" FROM ".$GLOBALS['g_egltb_cup_participants']." AS cup_parts ".
							" LEFT JOIN ".$GLOBALS['g_egltb_members']." AS members ".
							" ON cup_parts.participant_id = members.id ".
							" WHERE cup_parts.cup_id=$cup_id ".
							" ORDER BY cup_parts.created ASC ";
			return $this->pDBInterfaceCon->FetchArrayObject($this->pDBInterfaceCon->Query( $sql_query ));
			
		}
		# --------------------------------------------------------------------
		# select clan/team data
		# --------------------------------------------------------------------
		elseif ($participant_type == PARTTYPE_TEAM )
		{
			$sql_query = 	" SELECT cup_parts.checked, cup_parts.id, cup_parts.created, teams.id AS participant_id, teams.name AS participant_name, clan_accs.id AS participant_clan_id, clan_accs.name AS participant_clan_name, clan_accs.tag AS participant_clan_tag, cup_parts.id AS p_id ".
							" FROM ".$GLOBALS['g_egltb_cup_participants']." AS cup_parts ".
							" LEFT JOIN ".$GLOBALS['g_egltb_teams']." AS teams ".
							" ON (cup_parts.participant_id=teams.id) ".
							" LEFT JOIN ".$GLOBALS['g_egltb_clan_accounts']." AS clan_accs ".
							" ON clan_accs.id=teams.clan_id ".
							" WHERE cup_parts.cup_id=$cup_id ".
							" ORDER BY cup_parts.created ASC ";
			return $this->pDBInterfaceCon->FetchArrayObject($this->pDBInterfaceCon->Query( $sql_query ));
		}//if
		return 0;	
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------			
	function SelectRandomParticipant( &$part_array )
	{
		if( sizeof($part_array) == 0 ) return NULL;

		$temp 	= NULL;
		while( !$temp )
		{
			$rnd 	= rand( 0, sizeof($part_array)-1);
			if( !isset( $part_array[$rnd] ) ) continue;

			$temp = $part_array[$rnd];	 #save
			DeleteItemOfArray( $part_array, $rnd);		# delete item
			break;
		}//while
		return $temp;
		
	}//SelectRandomParticipant
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------	
	function ExecuteGlobaleCheckin( $cup_id )
	{
		$sql_query 	= 	" UPDATE {$GLOBALS['g_egltb_cup_participants']} ".
						" SET  checked=1 ".
						" WHERE cup_id={$cup_id}";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
		
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------	
	function ExecuteGlobaleCheckout( $cup_id )
	{
		$sql_query 	= 	" UPDATE {$GLOBALS['g_egltb_cup_participants']} ".
						" SET checked=0 ".
						" WHERE cup_id={$cup_id}";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------			
	function ComputeNextRndIndex( $in_index, &$new_index, &$bUp )
	{
		
		$runde = 0;
		$index = $in_index+1;

		# compute new index	
		$new_index = ($index/2);
		$bUp	   = false;
		
		
		if( is_float($new_index) ) $bUp = true;
		$new_index = round($new_index)-1;
		
		return 1;
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : object :: TB->egl_cup_encounts
	//-------------------------------------------------------------------------------			
	function GetEncountByMatchId( $match_id )
	{
		$sql_query	= 	" SELECT * ".
						" FROM  ".$GLOBALS['g_egltb_cup_encounts']."  AS c_encounts ".
						" WHERE match_id=".(int)$match_id;
		return $this->pDBInterfaceCon->FetchObject($this->pDBInterfaceCon->Query( $sql_query ));
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------			
	function SetEncountData( $encount_id, $obj )
	{
		$sql_query = 	$this->pDBInterfaceCon->CreateUpdateQuery( $GLOBALS['g_egltb_cup_encounts'], $obj ).
						" WHERE id=".(int)$encount_id;
		return $this->pDBInterfaceCon->Query( $sql_query );		
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------			
	function EvaluateMatchEncount( $oCup, $match_id, $bChallengerWin, $bOpponentWin )
	{
		$cMatch = new Match( $this->pDBInterfaceCon, NULL );
		

		# compute max rounds
		$numRounds = (log($oCup->max_participants)/log(2))+1;
		#$max_rounds	= $numRounds;
		
		
		# define query
		/*
		$sql_query = 	" SELECT matches.*, matches.id AS match_id, encounts.*, encounts.id AS encount_id ".
						" FROM ".$GLOBALS['g_egltb_matches']." AS matches, ".$GLOBALS['g_egltb_cup_encounts']." AS encounts ".
						" WHERE encounts.match_id=matches.id AND matches.id=$match_id";
		*/
		$sql_query = 	" SELECT encounts.*, encounts.id AS encount_id ".
						" FROM `".$GLOBALS['g_egltb_cup_encounts']."` AS encounts ".
						" WHERE encounts.match_id=$match_id";
		
		$oMatchEncount = $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ));
	
		
		if( !$oMatchEncount )
		{
			//echo "Fehler1";
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "'\$oMatchEncount' -  not found \nMYSQL:Error: ". $this->pDBInterfaceCon->GetLastError() );
			return 0;
		}
		
		
		# compute new index/ up/down
		$new_subindex 	= -1;
		$new_round		= $oMatchEncount->round+1;
		$bUp			= false;
		Cup::ComputeNextRndIndex( $oMatchEncount->subindex, $new_subindex, $bUp );
		
	
		/*
		Hier wird ein Left-Join benutzt, da die letzte begegnung KEIN MATCH BEINHALTET sondern NUR EIN BEGEGENUN G !!!!!
		
		
		*/
		
		# define query
		/*
		$sql_query = 	" SELECT matches.*, matches.id AS match_id, encounts.*, encounts.id AS encount_id ".
						" FROM ".$GLOBALS['g_egltb_cup_encounts']." AS encounts ".
						" LEFT JOIN ".$GLOBALS['g_egltb_matches']." AS matches ".
						" ON (encounts.match_id=matches.id) ".
						" WHERE (encounts.cup_id=".$oMatchEncount->cup_id.") && (encounts.subindex=$new_subindex && encounts.round=$new_round ) ";
		*/
		$sql_query = 	" SELECT encounts.*, encounts.id AS encount_id ".
						" FROM `".$GLOBALS['g_egltb_cup_encounts']."` AS encounts ".
						" WHERE (encounts.cup_id=".$oMatchEncount->cup_id.") && (encounts.subindex=$new_subindex && encounts.round=$new_round ) ";
		

		# fetch new matchencount data
		$oNextMatchEncount = $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ));
		
		if( !$oNextMatchEncount )
		{
			// echo "Fehler2";
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "'\$oNextMatchEncount' -  not found SQL-Error: ". $this->pDBInterfaceCon->GetLastError() );
			return 0;
		}
		#--------------------------------------------------------
		# set winner to old match encount
		#--------------------------------------------------------
		$match_obj 		= array();		# match data
		$encount_obj 	= array();		# encount data
		$tmp_winner_id	= EGL_NO_ID;
		
		
		if( $bChallengerWin ) 		$match_obj['winner_id'] = $oMatchEncount->challenger_id;
		else if( $bOpponentWin ) 	$match_obj['winner_id'] = $oMatchEncount->opponent_id;
		else
		{
			# DEBUG
			return 0;	# otherwise return 0;
		}
		
		# save winner_id for setting up the last round
		$tmp_winner_id = $match_obj['winner_id'];
		
		
		# save to encount data
		//$match_obj;		/* Only containing winner_id | encount_obj <=> match_obj */
		$encount_obj = array( 	'winner_id'	=> $tmp_winner_id,
							);
		
		
		# close last match /* => MATCH REPORT ist daf�r zust�ndig*/
		#$match_obj->status = MATCH_CLOSED;
		
		$cMatch->SetMatchData( $match_obj,  $oMatchEncount->match_id /* match_id*/ );
		$this->SetEncountData( $oMatchEncount->encount_id, $encount_obj );
		
		
		#--------------------------------------------------------
		# enter new participant to new match && encount
		#--------------------------------------------------------
		$match_obj 		= array();
		$encount_obj 	= array();
		
		if( $bUp )	$match_obj['challenger_id'] = $tmp_winner_id;		# from up		=> challenger_id
		if( !$bUp )	$match_obj['opponent_id'] 	= $tmp_winner_id;		# from down		=> opponent_id
		
		# close last match /* => MATCH REPORT ist daf�r zust�ndig*/
		#$match_obj->status = MATCH_RUNNING;
		
		# set same encount data
		//$encount_obj = $match_obj; ERROR on  php5 => pointer to match_obj is saved
		$encount_obj = array( 	//'winner_id'			=> $match_obj['winner_id'],
								//'challenger_id'		=> $match_obj['challenger_id'],
								//'opponent_id'		=> $match_obj['opponent_id'],
							);
		if( isset($match_obj['challenger_id'])) $encount_obj['challenger_id'] = $match_obj['challenger_id'];
		if( isset($match_obj['opponent_id'])) $encount_obj['opponent_id'] = $match_obj['opponent_id'];
		
		# ----------------------------------------------------------
		# check whether it's the last encount
				# => set match & encount to winne
				# => set match as finished
				
			
		# last round ?	
		if( $numRounds-1 == $oNextMatchEncount->round )
		{
			$encount_obj['winner_id'] = $tmp_winner_id;
			
			#	ES GIBT KEIN LETZTES MATCH, nur eine letzte begegnung mit match_id = -1;
			
			# set encount winner_id
			$this->SetEncountData( $oNextMatchEncount->encount_id, $encount_obj );	
			
			# FINISH CUP
			/*
				WIRD AB SOFORT MANUEL ERLEDIGT!!!
			*/
			// $this->FinishCup( $oCup );

		}//if
		else
		{
			$match_obj['challenge_time'] = EGL_TIME;	# set match -challenge time to current time
			
			$cMatch->SetMatchData( $match_obj, $oNextMatchEncount->match_id );			
			$this->SetEncountData( $oNextMatchEncount->encount_id, $encount_obj );
			
		}//if
	}//fucntion Evaluate..CupEncount
	
	
	
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: set winner IDs
	// Output : true/false
	//-------------------------------------------------------------------------------	
	function FinishCup( $oCup )
	{
		# definine update object
		$obj = NULL;
		$obj->finished = 1;
		
		# execute query
		return $this->pDBInterfaceCon->Query( $this->pDBInterfaceCon->CreateUpdateQuery( $GLOBALS['g_egltb_cups'], $obj  ));
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: creates the match start, containing creating encounts and matches
	// Output : true/false
	//-------------------------------------------------------------------------------	
	function CreateMatchStart(  $cup_id /*, $bRemoveUnchecked=true*/  )
	{
		$cMatch = new Match( $this->pDBInterfaceCon, NULL );
		$cMatchStructure = new MatchStructures( $this->pDBInterfaceCon );
		
		$oCup 	= $this->GetCup( $cup_id );
		$oMatchStructure = $cMatchStructure->GetMatchStructure( $oCup->matchstruct_id );
		
		# currently created?
		if( $oCup->encounts_created )
		{
			return _RESMSG('CUPERR_ENCOUNTS_CURRENTLY_CREATED');
		}

		# cup found ?
		if( ! $oCup )
		{
			return _RESMSG('CUPERR_CUP_NOT_FOUND');
		}
	
		if( ! $oMatchStructure )
		{
			return _RESMSG('CUPERR_MATCHSTRUCTUTRE_NOT_FOUND');
		}
		
		
		# check -> encounts => currently created ??
		$sql_query = " SELECT id FROM {$GLOBALS['g_egltb_cup_encounts']} AS encounts WHERE cup_id=".(int)$oCup->id;
		$aEncounts = $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
		if( sizeof($aEncounts) > 0 )
		{
			return _RESMSG('CUPERR_ENCOUNTS_CURRENTLY_CREATED');
		}

		//if( $bRemoveUnchecked )
		//{
			# delete checkedout participants
			$this->pDBInterfaceCon->Query( "DELETE FROM ".$GLOBALS['g_egltb_cup_participants']." WHERE cup_id=".$oCup->id." AND checked=0 " );
		//}
		
		
				
		# get participants
		$aParticipants = $this->GetCupParticipants( $oCup->id );
		$numParticipants = sizeof($aParticipants);
		
		if( $numParticipants <= 1 ) return 0;
				

		# 0815 cup compution
		if( ispow(sizeof($aParticipants))  )
		{
			
			# change max_participants ??
			if($numParticipants != $oCup->max_participants )
			{
				$obj_cup = NULL;
				$obj_cup->max_participants = $numParticipants; 
				$this->SetCupData($obj_cup,$oCup->id);
			}
			
			
			# compute rounds
			$numRounds = (log($numParticipants)/log(2))+1;
			
			
			# ONLY FOR SELECT Participant encounts
			$aParticipantEncountBuffer	= $aParticipants;
			
	
			# create all matches for the cup and encounts
			for( $i=0; $i < $numRounds;  $i++ )
			{
				$nRndParticipants 	= pow( 2, ($numRounds) - ($i+1) );
				$nRndEncounts		= $nRndParticipants/2;
						
				if( $nRndEncounts<1) $nRndEncounts = 1;	
				#echo "Runde($nRndEncounts)<br>";
				
				
	
				$nPartCounter=0;
				for( $e=0; $e < $nRndEncounts; $e++ )
				{
					$match_id 		= EGL_NO_ID;
					$challenger_id 	= EGL_NO_ID;
					$opponent_id 	= EGL_NO_ID;
					
					
					/*
					Description:
					----------
					Falls es die letzte runde ist, darf kein match mehr erstellt werden sondern nur eine Begegnung (ENCOUNT).
					
					
					
					*/
					if( $i < $numRounds-1 )
					{
						# create match => cMatch
						$m_obj = NULL;
						$m_obj->module_id			= MODULEID_INETOPIA_CUP;
						$m_obj->module_entry_id		= $oCup->id;		# module_entry_id contains the ID of the cup
						$m_obj->challenger_id 		= EGL_NO_ID;
						$m_obj->opponent_id 		= EGL_NO_ID;
						$m_obj->winner_id 			= EGL_NO_ID;
						$m_obj->report_id 			= EGL_NO_ID;
						$m_obj->participant_type 	= $oCup->participant_type;
						$m_obj->status  			= MATCH_RUNNING;
						
						$m_obj->challenge_time  	= $oCup->start_time;
						$m_obj->created  			= EGL_TIME;
						
						# read map data	=> elsewhere
						$m_obj->maps  				= $oMatchStructure->maps;
						$m_obj->round_names  		= $oMatchStructure->round_names;
						$m_obj->num_rounds   		= $oMatchStructure->num_rounds;
						$m_obj->num_maps  	 		= $oMatchStructure->num_maps;
						$m_obj->mapcollection_id 	= $oMatchStructure->mapcollection_id;
						$m_obj->fixed 				= $oMatchStructure->fixed;
						#$m_obj->results  	 		= CMatch::NoMatchResults( $oMatchStructure->num_maps, $oMatchStructure->num_rounds );
						
						
						# ONLY SET Participant Encounts in Round 0
						if( $i == 0 )
						{
							$challenger = $this->SelectRandomParticipant( $aParticipantEncountBuffer );
							$opponent = $this->SelectRandomParticipant( $aParticipantEncountBuffer );
							
							$challenger_id 	= $m_obj->challenger_id 	= $challenger->participant_id;
							$opponent_id	= $m_obj->opponent_id	 	= $opponent->participant_id;
						}
						
						# create match
						if( !$this->pDBInterfaceCon->Query ( $this->pDBInterfaceCon->CreateInsertQuery( $GLOBALS['g_egltb_matches'], $m_obj ) ) )
						{
							DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Coudn't create Cup > Match, Cup-ID: ".$oCup->id."\nMYSQL: ".$this->pDBInterfaceCon->GetLastError() );
							return 0;
						}
		
						# get created match_id
						$match_id = $this->pDBInterfaceCon->InsertId();
					}
					
					
					#----------------------------------------------------------
					$obj = NULL;
						
					$obj->cup_id 		= $oCup->id;
					$obj->match_id		= $match_id;
					$obj->winner_id		= EGL_NO_ID;
					$obj->round 		= $i;
					$obj->subindex 		= $e;
					$obj->challenger_id = $challenger_id;
					$obj->opponent_id 	= $opponent_id;
					$obj->created 		= EGL_TIME;
					
	
					# create encount
					if( !$this->pDBInterfaceCon->Query ( $this->pDBInterfaceCon->CreateInsertQuery( $GLOBALS['g_egltb_cup_encounts'], $obj ) ) )
					{
						DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Coudn't create Cup > Ecnount, Cup-ID: ".$oCup->id."\nMYSQL: ".$this->pDBInterfaceCon->GetLastError() );
					}
						
				}//for
				
				
				
			}//for		
		}# if( sizeof($aParticipants) == $oCup->max_participants )
		else
		{
			 /*
			 	Sollte die anzahl der Teilnehmer keine 2er potenz sein ....
			 		=> suche n�hste 2er potenz
			 		=> 
			 
			 */
			 		 
			$next_pow		= getnextpow( $numParticipants, 2 );
			$numFreeTickets	= $next_pow - $numParticipants;
			

			# set new max_participants
			if( $next_pow != $oCup->max_participants )
			{
				$obj_cup = NULL;
				$obj_cup->max_participants = $next_pow; 
				$cCup = new Cup( $this->pDBInterfaceCon, $oCup->id);
				$cCup->SetCupData($obj_cup);	
			}
			
			 
			# compute rounds
			$numRounds = (log($next_pow)/log(2))+1;
 			 
			
			# ONLY FOR SELECT Participant encounts
			$aParticipantEncountBuffer	= $aParticipants;

			
			# later, containuing all free ticket encounts
			$aFreeTicketEncounts = array();
			
			
			$numCntFreeTickets = 0;
			
			###############################################################
			# create matches to each round
			###############################################################
			for( $i=0; $i < $numRounds; $i++ )
			{
				$nRndParticipants 	= pow( 2, ($numRounds) - ($i+1) );
				$nRndEncounts		= $nRndParticipants/2;
						
	
				$nPartCounter=0;
				for( $e=0; $e < $nRndEncounts; $e++ )
				{
					$bFreeTicket=false;
					
					$match_id 		= EGL_NO_ID;
					$challenger_id 	= EGL_NO_ID;
					$opponent_id 	= EGL_NO_ID;
					
					
					/*
					Description:
					----------
					Falls es die letzte runde ist, darf kein match mehr erstellt werden sondern nur eine Begegnung (ENCOUNT).
					
					
					
					*/
					if( $i < $numRounds-1 )
					{
						# create match => cMatch
						$m_obj = NULL;
						$m_obj->module_id			= MODULEID_INETOPIA_CUP;
						$m_obj->module_entry_id		= $oCup->id;		#module_entry_id contains the ID of the cup
						$m_obj->challenger_id 		= EGL_NO_ID;
						$m_obj->opponent_id 		= EGL_NO_ID;
						$m_obj->winner_id 			= EGL_NO_ID;
						$m_obj->report_id 			= EGL_NO_ID;
						$m_obj->participant_type 	= $oCup->participant_type;
						$m_obj->status  			= MATCH_RUNNING;
						
						
						$m_obj->challenge_time  	= $oCup->start_time;	# set first match_challenge time as cup start time
						$m_obj->created  			= EGL_TIME;
						
						# read map data	=> elsewhere
						$m_obj->maps  				= $oMatchStructure->maps;
						$m_obj->round_names  		= $oMatchStructure->round_names;
						$m_obj->num_rounds   		= $oMatchStructure->num_rounds;
						$m_obj->num_maps  	 		= $oMatchStructure->num_maps;
						$m_obj->mapcollection_id 	= $oMatchStructure->mapcollection_id;
						$m_obj->fixed 				= $oMatchStructure->fixed;
						#$m_obj->results  	 		= CMatch::NoMatchResults( $oMatchStructure->num_maps, $oMatchStructure->num_rounds );

						
						# ONLY SET Participant Encounts in Round 0
						if( $i == 0 )
						{
							if( $numFreeTickets > $numCntFreeTickets )
							{
								$bFreeTicket = true;
								
								# only challenger
								$challenger = $this->SelectRandomParticipant( $aParticipantEncountBuffer );
								#$opponent = $this->SelectRandomParticipant( $aParticipantEncountBuffer );
								
								$challenger_id = $m_obj->challenger_id 	= $challenger->participant_id;
								# opponent_id no USED !!
								$m_obj->opponent_id	 	= EGL_NO_ID;
								$m_obj->status			= MATCH_CLOSED;		# MATCH CLOSED !!!!
			
								# save freeticket data
								$aFreeTicketEncounts[sizeof($aFreeTicketEncounts)] = $m_obj;
								
								$numCntFreeTickets++;
							}
							else
							{
								$challenger 	= $this->SelectRandomParticipant( $aParticipantEncountBuffer );
								$opponent 		= $this->SelectRandomParticipant( $aParticipantEncountBuffer );
								
								$challenger_id 	= $m_obj->challenger_id 	= $challenger->participant_id;
								$opponent_id 	= $m_obj->opponent_id	 	= $opponent->participant_id;
							}//if
						}//if
					
					
					
						# create match
						if( !$this->pDBInterfaceCon->Query ( $this->pDBInterfaceCon->CreateInsertQuery( $GLOBALS['g_egltb_matches'], $m_obj ) ) )
						{
							DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Coudn't create Cup > Match, Cup-ID: ".$oCup->id."\nMYSQL: ".$this->pDBInterfaceCon->GetLastError() );
							return 0;
						}

						# get created match_id
						$match_id = $this->pDBInterfaceCon->InsertId();
					
						# add free tickets to global array
						if( $i == 0 && $bFreeTicket ) $aFreeTicketEncounts[sizeof($aFreeTicketEncounts)-1]->match_id = $match_id;
					}
						

					# create encount
					#----------------------------------------------------------
					$obj = NULL;
							
					$obj->cup_id 		= $oCup->id;
					$obj->match_id		= $match_id;
					$obj->winner_id		= EGL_NO_ID;
					$obj->round 		= $i;
					$obj->subindex 		= $e;
					$obj->challenger_id = $challenger_id;
					$obj->opponent_id 	= $opponent_id;
					$obj->created 		= EGL_TIME;
					
					if( $bFreeTicket ) $obj->is_freeticket = 1;
					
						
					/*
					if( $bFreeTicket )
					{
						$obj->winner_id	= $m_obj->winner_id;
						//....
					}*/

					# create encount
					if( !$this->pDBInterfaceCon->Query ( $this->pDBInterfaceCon->CreateInsertQuery( $GLOBALS['g_egltb_cup_encounts'], $obj ) ) )
					{
						DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Coudn't create Cup > Encount, Cup-ID: ".$oCup->id."\nMYSQL: ".$this->pDBInterfaceCon->GetLastError() );
						return 0;
					}
						
				}//for
				
				
			}//for $i,$numRounds
			
			
			
			
			#-------------------------------------------------------------------------------------
			# set autowins to free ticket encount
			#-------------------------------------------------------------------------------------
			for( $f=0; $f < sizeof($aFreeTicketEncounts); $f++ )
			{
				$this->EvaluateMatchEncount( $oCup, $aFreeTicketEncounts[$f]->match_id, true, false );
			}//for( $f=0; $f < sizeof($aFreeTicketEncounts); $f++ )

		}//if ..
		
		
		
		#echo "<br><br><br>";
		
		return 1;
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------	
	function GetNumOpenCupMatches( $participant_id_list, $type )
	{
		$sql_query 	= 	" SELECT COUNT(cup_matches.id) AS num_matches FROM ".$GLOBALS['g_egltb_cups']." AS cups " .
						" LEFT JOIN ".$GLOBALS['g_egltb_cup_matches']." AS cup_matches ".
						" ON (cups.id=cup_matches.cup_id && cups.participant_type = $type) ".
						" WHERE ( FIND_IN_SET( cup_matches.challenger_id, '$participant_id_list') || FIND_IN_SET( cup_matches.opponent_id,'$participant_id_list')) AND winner_id <= 0 ".
						" GROUP BY cup_matches.cup_id ";
						
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------	
	function GetOpenCupMatches( $participant_id, $type )
	{
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------	
	function GetUpComingCupParticipants($timestamp=0, $part_type=0, $participant_id=0 )
	{
		$sql_cups = " SELECT cups.id, COUNT(cup_parts.cup_id) AS num_participants FROM ".$GLOBALS["g_egltb_cups"]." AS cups ".
					" LEFT JOIN ".$GLOBALS["g_egltb_cup_participants"]." AS cup_parts ".
					" ON (cup_parts.cup_id=cups.id) " .
					" WHERE (cups.start_time > $timestamp && cups.participant_type = $part_type) ".
					" GROUP BY cup_parts.cup_id " .
					" ORDER BY cups.start_time ASC, cups.game_id DESC";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_cups ) );
	}
	

	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------	
	function GetUpComingCups_ByParticipant($timestamp=0, $part_type=0, $participant_id=0, $is_public=1 )
	{
		$sql_cups = 
					" SELECT cups.*, cup_parts.cup_id, cup_parts.checked, cup_parts.participant_id, ". 
					" COUNT(cup_parts2.cup_id) AS num_participants, ".
					" games.id AS game_id, games.logo_small_file AS game_logo ".
					" FROM `".$GLOBALS["g_egltb_cups"]."` AS cups ".
					" LEFT JOIN `".$GLOBALS['g_egltb_cup_participants']."` AS cup_parts2 ".
					" ON (cup_parts2.cup_id=cups.id) ".
					" LEFT JOIN `".$GLOBALS["g_egltb_cup_participants"]."` AS cup_parts ".
					" ON (cup_parts.cup_id=cups.id) && (cup_parts.participant_id=$participant_id) " .
					" LEFT JOIN `".$GLOBALS['g_egltb_game_pool']."` AS games ".
					" ON cups.game_id = games.id ".
					" WHERE (cups.start_time > $timestamp && cups.participant_type = $part_type) && is_public={$is_public}" .
					" GROUP BY cups.id ".
					" ORDER BY cups.start_time ASC, cups.game_id DESC";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_cups ) );
	}
	
	
	
	/*
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------	
	function GetUpComingCupsEntered($timestamp=0, $part_type=0, $participant_id=0)
	{
		$sql_cups = " SELECT cups.*, COUNT(cup_parts.cup_id) AS num_participants FROM ".$GLOBALS["g_egltb_cups"]." AS cups ".
					" LEFT JOIN ".$GLOBALS["g_egltb_cup_participants"]." AS cup_parts ".
					" ON (cup_parts.cup_id=cups.id) && (cup_parts.participant_id=$participant_id) " .
					" WHERE (cups.start_time > $timestamp && cups.participant_type = $part_type) GROUP BY cup_parts.cup_id";
					" ORDER BY cups.start_time ASC, cups.game_id DESC";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_cups ) );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------	
	function GetCupList( $part_type=0 )
	{
		$str_type = "";
		if( $type ) $str_type = " WHERE (cups.partcipant_type = $part_type) ";
		$sql_cups = " SELECT cups.*  FROM ".$GLOBALS["g_egltb_cups"]." AS cups ".
					" ORDER BY cups.game_id DESC,cups.start_time ASC";
					
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_cups ) );
	}*/
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------	
	function GetActiveCups( $timestamp=EGL_TIME )
	{
		$sql_cups = " SELECT  games.logo_small_file AS game_logo, games.name AS game_name, cups.*, COUNT(cup_parts.cup_id) AS num_participants ".
					" FROM ".$GLOBALS["g_egltb_cups"]." AS cups ".
					" LEFT JOIN ".$GLOBALS['g_egltb_game_pool']." AS games ".
					" ON cups.game_id = games.id ".
					" LEFT JOIN ".$GLOBALS["g_egltb_cup_participants"]." AS cup_parts ".
					" ON cup_parts.cup_id=cups.id " .
					" WHERE (cups.start_time > $timestamp && !cups.encounts_created) ".
					" GROUP BY cups.id ".
					" ORDER BY cups.start_time ASC, cups.game_id DESC";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_cups ) );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: Gibt eine Liste der letzten Cups(limit) zur�ck 
	//
	// Output : 
	//-------------------------------------------------------------------------------	
	function GetLastCups( $timestamp=EGL_TIME, $limit_start=0, $limit_end=0 )
	{
		$sql_cups = 	" SELECT  games.logo_small_file AS game_logo, games.name AS game_name, cups.* ".
						" FROM ".$GLOBALS['g_egltb_cups']." AS cups ".
						" LEFT JOIN ".$GLOBALS['g_egltb_game_pool']." AS games ".
						" ON cups.game_id = games.id ".
						" ORDER BY cups.start_time DESC, cups.game_id DESC".
						" LIMIT $limit_start,$limit_end ";
					 
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_cups ) );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------	
	function IsEnteredCup( $cup_id, $participant_id )
	{
		$sql_query = 	" SELECT COUNT(*) AS num_parts ".
						" FROM ".$GLOBALS["g_egltb_cup_participants"]." AS cupparts".
						" WHERE participant_id=$participant_id && cup_id=$cup_id ".
						" GROUP BY participant_id ";
						
		$data = $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
		return $data->num_parts;
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------		
	function CheckinParticipant( $cup_id, $part_id )
	{
		$sql_query 	= 	" UPDATE ".$GLOBALS['g_egltb_cup_participants']." ".
						" SET checked=1 ".
						" WHERE cup_id=$cup_id && participant_id=$part_id ";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------		
	function CheckoutParticipant( $cup_id, $part_id )
	{
		$sql_query 	= 	" UPDATE ".$GLOBALS['g_egltb_cup_participants']." ".
						" SET checked=0 ".
						" WHERE cup_id=$cup_id && participant_id=$part_id ";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}

	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------		
	function CheckinParticipantById( $cuppart_id )
	{
		$obj = NULL;
		$obj->checked = 1;
		$this->SetCupParticipantData( $obj, $cuppart_id );
	}
	

	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------		
	function CheckoutParticipantById( $cuppart_id )
	{
		$obj = NULL;
		$obj->checked = 0;
		$this->SetCupParticipantData( $obj, $cuppart_id );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------		
	function SetCupData($object,$cup_id=NULL)
	{
		if( !$cup_id ) $cup_id = $this->iCupId;
		if( !$cup_id ) return false;
		
		$sql_query = $this->pDBInterfaceCon->CreateUpdateQuery( $GLOBALS["g_egltb_cups"], $object )." WHERE id=$cup_id";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------		
	function SetCupParticipantData($object,$cuppart_id)
	{
		$sql_query = $this->pDBInterfaceCon->CreateUpdateQuery( $GLOBALS['g_egltb_cup_participants'], $object )." WHERE id=$cuppart_id";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}	
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------		
	function CreateCupParticipant( $object )
	{
		$sql_query = $this->pDBInterfaceCon->CreateInsertQuery( $GLOBALS["g_egltb_cup_participants"], $object );
		$qre = $this->pDBInterfaceCon->Query( $sql_query );
		if( $qre ) return $this->pDBInterfaceCon->InsertId();
		return -1;		
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------		
	function DeleteParticipant( $id )
	{
		$sql_query = "DELETE FROM ".$GLOBALS["g_egltb_cup_participants"]." WHERE id=$id";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}	
		
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------		
	function DeleteCupParticipants( $cup_id )
	{
		$sql_query = "DELETE FROM ".$GLOBALS["g_egltb_cup_participants"]." WHERE cup_id={$cup_id}";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}	
	

	/**
	 * delete only encounts
	 *
	 * @param unknown_type $cup_id
	 * @return unknown
	 */
	function DeleteEncounts( $cup_id )
	{
		$sql_query = "DELETE FROM ".$GLOBALS['g_egltb_cup_encounts']." WHERE cup_id=$cup_id";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}

	/**
	 * delete matches & encounts
	 *
	 * @param unknown_type $cup_id
	 * @return unknown
	 */
	function DeleteMatchEncounts( $cup_id )
	{
		$sql_query = " DELETE matches, encounts ".
					 " FROM ".$GLOBALS['g_egltb_matches']." AS matches ".
					 " LEFT JOIN ".$GLOBALS['g_egltb_cup_encounts']." AS encounts ".
					 " ON matches.id=encounts.match_id ".
					 " WHERE encounts.cup_id=$cup_id ";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
	
	/**
	 * only delete matches
	 *
	 * @param unknown_type $cup_id
	 * @return unknown
	 */
	function DeleteMatches( $cup_id )
	{
		$sql_query = " DELETE matches ".
					 " FROM ".$GLOBALS['g_egltb_matches']." AS matches ".
					 " LEFT JOIN ".$GLOBALS['g_egltb_cup_encounts']." AS encounts ".
					 " ON matches.id=encounts.match_id ".
					 " WHERE encounts.cup_id=$cup_id ";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $ladder_id
	 */
	function DeleteMatchesByModuleData( $cup_id )
	{
		$sql_query = "DELETE FROM ".$GLOBALS["g_egltb_matches"]." WHERE module_entry_id={$cup_id} && module_id='".MODULEID_INETOPIA_CUP."'";
		return $this->pDBInterfaceCon->Query( $sql_query );	
	}
	
	
		
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------		
	function DeleteParticipantByCup( $cup_id, $participant_id )
	{
		$sql_query = "DELETE FROM ".$GLOBALS["g_egltb_cup_participants"]." WHERE participant_id={$participant_id} && cup_id={$cup_id} ";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------	
	function GetCupEntries( $part_id, $part_type )
	{
		$sql_query = 	" SELECT cups.name, cups.id  ".
						" FROM ".$GLOBALS["g_egltb_cups"]." AS cups, ".$GLOBALS["g_egltb_cup_participants"]." AS cup_parts ".
						" WHERE (cups.id=cup_parts.cup_id) && (cup_parts.participant_id = $part_id) ".
						" AND ( cups.participant_type = $part_type ) ".
						" ORDER BY cups.created ASC ";
		return $this->pDBInterfaceCon->FetchArrayObject($this->pDBInterfaceCon->Query( $sql_query ));
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: Pr�ft ob ein member, des join_teams bereits in einem anderen Team in diesem Cup mitspielt
	// Output : Liste der bereits in einem Team angemeldeten Spieler (inkl. teamnamen)
	//			
	//-------------------------------------------------------------------------------	
	function CheckTeamMemberJoins( $cup_id, $team_id )
	{
		/*
			1. 	besorge �ber team_id(participant_id) team joins
			2. 
		
		*/
		
		$tb_left 	=    	" SELECT team_joins.team_id, team_joins.member_id AS team_join_member_id ".
							" FROM ".$GLOBALS['g_egltb_cups']." AS cups, ".$GLOBALS['g_egltb_cup_participants']." AS cupparts ".
							" LEFT JOIN  ".$GLOBALS['g_egltb_team_joins']." AS team_joins ".
							" ON team_joins.team_id=cupparts.participant_id && cups.participant_type=".PARTTYPE_TEAM." ".
							" WHERE cupparts.cup_id=cups.id && cups.id=$cup_id ";
		
		$tb_right 	=    	" SELECT team_joins.member_id AS team_join_member_id ".
							" FROM ".$GLOBALS['g_egltb_team_joins']." AS team_joins ".
							" WHERE team_joins.team_id=$team_id ";
		# whole request
		$sql_query	= 		" SELECT cupparts_request.*, teams.name AS team_name,members.id AS member_id, members.nick_name AS member_nickname ".
							" FROM ($tb_left) AS cupparts_request, ($tb_right) AS team_request ".
							" LEFT JOIN ".$GLOBALS['g_egltb_members']." AS members ". 
							" ON cupparts_request.team_join_member_id=members.id ".
							" LEFT JOIN ".$GLOBALS['g_egltb_teams']." AS teams ".
							" ON cupparts_request.team_id=teams.id ".
							" WHERE cupparts_request.team_join_member_id = team_request.team_join_member_id ";
							
							
		return $this->pDBInterfaceCon->FetchArrayObject($this->pDBInterfaceCon->Query($sql_query));
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: Pr�ft ob jeder Spieler(auch in einem Team) gaming ids eingetragen haben
	// Output : 
	//-------------------------------------------------------------------------------	
	function CheckGamingId( $game_id, $participant_type, $participant_id )
	{
		
				
		# check team_members
		if( $participant_type == PARTTYPE_TEAM )
		{
			/*
				select team members
			*/
			$select_team_joins 	=		" SELECT team_joins.member_id ".
										" FROM `".$GLOBALS['g_egltb_teams']."` AS teams, `{$GLOBALS['g_egltb_team_joins']}` AS team_joins ".
										" WHERE team_joins.team_id=teams.id && teams.id=".(int)$participant_id." ";
	
			/*
				select gameaccs/types from selected members
			*/
			/*
			$filter_no_acc_members = 	" SELECT members.id, game_accs.value, game_accs.gameacctype_id ".
										" FROM {$GLOBALS['g_egltb_team_joins']} AS team_joins, ".
										{$GLOBALS['g_egltb_gameaccount_types']." AS gameacc_types, ".
												$GLOBALS['g_egltb_gameaccounts']." AS game_accs ".
										" LEFT JOIN ".$GLOBALS['g_egltb_members']." AS members ".
										" ON members.id=team_joins.member_id ".
										" WHERE team_joins.team_id=$participant_id && gameacc_types.game_id={$game_id} && gameacc_types.id=game_accs.gameacctype_id && team_joins.member_id=game_accs.member_id  ";
			*/
			

			$filter_no_acc_members = 	" SELECT members.id, game_accs.value, game_accs.gameacctype_id ".
										" FROM 	`{$GLOBALS['g_egltb_team_joins']}` AS team_joins, ".
										"		`".$GLOBALS['g_egltb_gameaccounts']."` AS game_accs, ".
										"		`".$GLOBALS['g_egltb_gameaccount_types']."` AS gameacc_types, ".
										"		`".$GLOBALS['g_egltb_game_pool']."` AS games ".
										" LEFT JOIN `".$GLOBALS['g_egltb_members']."` AS members ".
										" ON members.id=team_joins.member_id ".
										" WHERE team_joins.team_id=".(int)$participant_id."  && game_accs.member_id=team_joins.member_id && gameacc_types.id=game_accs.gameacctype_id && gameacc_types.id=games.gameacctype_id && games.id=".(int)$game_id."";
			return $this->pDBInterfaceCon->FetchArrayObject($this->pDBInterfaceCon->Query( $filter_no_acc_members));
			
		}//if

		
		# ceck members
		else if( $participant_type == PARTTYPE_MEMBER )
		{
			$filter_no_acc_members = 	" SELECT members.nick_name, members.id, game_accs.value ".
										" FROM 	`".$GLOBALS['g_egltb_members']."` AS members, ".
										"		`".$GLOBALS['g_egltb_gameaccounts']."` AS game_accs, ".
										"		`".$GLOBALS['g_egltb_gameaccount_types']."` AS gameacc_types, ".
										"		`".$GLOBALS['g_egltb_game_pool']."` AS games ".
										" WHERE game_accs.gameacctype_id=gameacc_types.id && gameacc_types.game_id=games.id && games.id=".(int)$game_id." && members.id=game_accs.member_id && member_id=".(int)$participant_id." ";
			return $this->pDBInterfaceCon->FetchArrayObject($this->pDBInterfaceCon->Query( $filter_no_acc_members));
		}//if
	
	}//CheckGamingId
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------	
	function GetCupMatches( $cup_id, $part_id, $parttype, $status=NULL )
	{
		$status = "";
		$LIMIT_STR="";
		if( $limit > 0 ) $LIMIT_STR = " LIMIT 0,".(int)$limit;
		$match_status = "";
		
		if( $status == 'all' )				$match_status = "";
		else if( $status == 'closed' ) 		$match_status = " && matches.status=".MATCH_CLOSED." ";
		else if( $status == 'locked' ) 		$match_status = " && (matches.status=".MATCH_LOCKED." || matches.status=".MATCH_REPORTED." )  ";
		else if( $status == 'reported' ) 	$match_status = " && matches.status=".MATCH_REPORTED." ";
		else if( $status == 'running' )		$match_status = " && matches.status=".MATCH_RUNNING." ";
		
		
		if( $parttype == PARTTYPE_MEMBER ){
			$sql_query = 	" SELECT encounts.match_id,  cups.name AS entry_name, cups.id AS entry_id, matches.*, ".
								" challenger.nick_name AS challenger_name, challenger.id AS challenger_id, ".
								" opponent.nick_name AS opponent_name, opponent.id AS opponent_id  ".
							" FROM `".$GLOBALS['g_egltb_cups']."` AS cups ".
							" LEFT JOIN `".$GLOBALS['g_egltb_cup_encounts']."` AS encounts ".
							" ON encounts.cup_id = cups.id ".
							" LEFT JOIN `".$GLOBALS['g_egltb_matches']."` AS matches ".
							" ON matches.id=encounts.match_id && cups.id = matches.module_entry_id ".
							" LEFT JOIN `".$GLOBALS['g_egltb_members']."` AS challenger ".
							" ON matches.challenger_id=challenger.id ".
							" LEFT JOIN `".$GLOBALS['g_egltb_members']."` AS opponent ".
							" ON matches.opponent_id=opponent.id ".
							" WHERE (cups.id=$cup_id) && matches.participant_type=$parttype && (matches.opponent_id=$part_id || matches.challenger_id=$part_id) $status  ".
							" ORDER BY matches.challenge_time DESC, matches.created ASC ";
		}
		elseif( $parttype == PARTTYPE_TEAM ){
			$sql_query = 	" SELECT encounts.match_id,  cups.name AS entry_name, cups.id AS entry_id, matches.*, ".
							" 		 challenger.name AS challenger_name, challenger.id AS challenger_id, ".
							"		 c_clan.name AS challenger_clan_name, c_clan.tag AS challenger_clan_tag, c_clan.id AS challenger_clan_id, ".
							" 		 opponent.name AS opponent_name, opponent.id AS opponent_id, ".
							"		 o_clan.name AS opponent_clan_name, o_clan.tag AS opponent_clan_tag, o_clan.id AS opponent_clan_id ".
							" FROM `".$GLOBALS['g_egltb_cups']."` AS cups ".
								" LEFT JOIN `".$GLOBALS['g_egltb_cup_encounts']."` AS encounts ".
								" ON encounts.cup_id = cups.id ".
								
								" LEFT JOIN `".$GLOBALS['g_egltb_matches']."` AS matches ".
								" ON matches.id=encounts.match_id && cups.id = matches.module_entry_id ".
							
								" LEFT JOIN `{$GLOBALS['g_egltb_teams']}` AS challenger ".
									" ON challenger.id=matches.challenger_id ".
								" LEFT JOIN `{$GLOBALS['g_egltb_clan_accounts']}` AS c_clan".
									" ON c_clan.id=challenger.clan_id ".
									
								" LEFT JOIN `{$GLOBALS['g_egltb_teams']}` AS opponent ".
									" ON opponent.id=matches.opponent_id ".
								" LEFT JOIN `{$GLOBALS['g_egltb_clan_accounts']}` AS o_clan ".
									" ON o_clan.id=opponent.clan_id ".
							" WHERE (cups.id=$cup_id) && matches.participant_type=$parttype && (matches.opponent_id=$part_id || matches.challenger_id=$part_id) $status  ".
							" ORDER BY matches.challenge_time DESC, matches.created ASC ";
		}

	/*
		$sql_query = 	" SELECT cups.name AS entry_name, cups.id AS entry_id, matches.* ".
						" FROM ".$GLOBALS['g_egltb_cups']." AS cups, ".$GLOBALS['g_egltb_matches']." AS matches ".
						" WHERE (cups.id=$cup_id) && (cups.id = matches.module_entry_id ) && (matches.participant_type=$parttype && (matches.opponent_id=$part_id||matches.challenger_id=$part_id) ) $status  ".
						" ORDER BY matches.challenge_time DESC, matches.created ASC ";
	*/
						
		return $this->pDBInterfaceCon->FetchArrayObject($this->pDBInterfaceCon->Query( $sql_query ));						
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------		
	function GetData()
	{
		$sql_query= " SELECT games.logo_small_file AS game_logo, games.name AS game_name, cups.*, COUNT(cup_parts.cup_id) AS num_participants FROM ".$GLOBALS["g_egltb_cups"]." AS cups ".
					" LEFT JOIN `".$GLOBALS["g_egltb_cup_participants"]."` AS cup_parts ".
					" ON (cup_parts.cup_id=cups.id) " .
					" LEFT JOIN `".$GLOBALS['g_egltb_game_pool']."` AS games ".
					" ON (cups.game_id=games.id) ".
					" WHERE (cups.id = ".((int)$this->iCupId).") GROUP BY cup_parts.cup_id ";
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------		
	function GetCups()
	{
		$sql_query= " SELECT cups.*, COUNT(cup_parts.cup_id) AS num_participants, games.logo_small_file AS game_logo_file".
					" FROM ".$GLOBALS["g_egltb_cups"] ." AS cups ".
					" LEFT JOIN ".$GLOBALS["g_egltb_cup_participants"]." AS cup_parts ".
					" ON cup_parts.cup_id = cups.id ".
					" LEFT JOIN {$GLOBALS['g_egltb_game_pool']} AS games".
					" ON (cups.game_id=games.id) ".
					" GROUP BY cups.id  ".
					" ORDER BY start_time ";
					
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );		
	}
		
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------		
	function GetGameCups( $game_id )
	{
		$sql_query= " SELECT cups.*, games.logo_small_file AS game_logo_file, games.logo_big_file AS game_big_file".
					" FROM ".$GLOBALS["g_egltb_cups"] ." AS cups ".
					//" LEFT JOIN ".$GLOBALS["g_egltb_cup_participants"]." AS cup_parts ".
					//" ON cup_parts.cup_id = cups.id ".
					" LEFT JOIN {$GLOBALS['g_egltb_game_pool']} AS games".
					" ON (cups.game_id=games.id) ".
					" WHERE cups.game_id={$game_id} ".
					" GROUP BY cups.id  ".
					" ORDER BY start_time ";
					
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );		
	}
	
		
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------		
	function GetDetailedGameCups( $game_id )
	{
		$sql_query= " SELECT cups.*, country.image_file AS country_image_file, country.name AS country_name, country.token AS country_token, COUNT(cup_parts.cup_id) AS num_participants, games.logo_small_file AS game_logo_file, games.logo_big_file AS game_big_file ".
					" FROM `".$GLOBALS["g_egltb_cups"] ."` AS cups ".
					" LEFT JOIN `".$GLOBALS["g_egltb_cup_participants"]."` AS cup_parts ".
					" ON cup_parts.cup_id = cups.id ".
					//" LEFT JOIN {$GLOBALS['g_egltb_matches']} AS matches".
					//" ON matches.module_id='61A47C28-FE74-488d-B8E4-A11FEDBB935A' && matches.module_entry_id=cups.id ".
					" LEFT JOIN `{$GLOBALS['g_egltb_game_pool']}` AS games".
					" ON (cups.game_id=games.id) ".
					" LEFT JOIN `".$GLOBALS['g_egltb_countries']."` AS country ".
					" ON country.id=cups.country_id ".
					" WHERE cups.game_id={$game_id}".
					" GROUP BY cups.id ".
					" ORDER BY start_time ";
					
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );		
	}
	
	


	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------
	function GetPaticipantCups( $participant_id, $participant_type,  $limit=NULL )
	{
		$sLimit = '';
		if( $limit ) $sLimit = " LIMIT 0,$limit ";	# define LIMIT
		
		$sql_query 	= 	" SElECT cups.*, SUM(cup_enc.winner_id) AS roundwinner_sum  ".
						" FROM ".$GLOBALS['g_egltb_cups']." AS cups ".
						" LEFT JOIN ".$GLOBALS['g_egltb_cup_encounts']." AS cup_enc".
						" ON cups.id=cup_enc.cup_id ".	# ON right cup_id , winnerID != no_id
						" WHERE  (cup_enc.challenger_id=$participant_id || cup_enc.opponent_id=$participant_id ) AND ( cups.participant_type=$participant_type)".
						" GROUP BY cups.id ".
						" ORDER BY cups.start_time ASC ".
						" $sLimit ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );		
	}

	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------
	function GetEnteredCups( $participant_id, $participant_type,  $limit=NULL )
	{
		$sLimit = '';
		if( $limit ) $sLimit = " LIMIT 0,$limit ";	# define LIMIT
	
		$sql_query 	= 	" SELECT cups.* ".
						" FROM ".$GLOBALS['g_egltb_cups']." AS cups ".
						" LEFT JOIN ".$GLOBALS['g_egltb_cup_participants']." AS cup_parts".
						" ON cups.id=cup_parts.cup_id ".
						" WHERE (cups.participant_type=$participant_type) AND !cups.encounts_created AND cup_parts.participant_id=$participant_id".
						" ORDER BY cups.start_time ASC ".
						" $sLimit ";
		 return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );		
	}

	
	/*
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------
	function GetAdmins( $cup_id )
	{
		$sql_query 	= " SELECT ";
	}*/
	

	/**
	 * delete whole cup data
	 *
	 * @return unknown
	 */
	/*function DeleteCup()
	{
		$sql_query = "DELETE FROM ".$GLOBALS['g_egltb_cup_encounts']." WHERE cup_id=".$this->iCupId;
		$this->pDBInterfaceCon->Query( $sql_query );
		$sql_query = "DELETE FROM ".$GLOBALS['g_egltb_cup_participants']." WHERE cup_id=".$this->iCupId;
		$this->pDBInterfaceCon->Query( $sql_query );
		$sql_query = "DELETE FROM ".$GLOBALS['g_egltb_cups']." WHERE id=".$this->iCupId;
		$this->pDBInterfaceCon->Query( $sql_query );
		
		$sql_query = "DELETE FROM ".$GLOBALS['g_egltb_matches']." WHERE  module_entry_id=".$this->iCupId;
		$this->pDBInterfaceCon->Query( $sql_query );
		
		return 1;
	}*/
	
	
	/**
	 * delete cup data (only 1db-entry)
	 *
	 * @return unknown
	 */
	function DeleteCup( $cup_id )
	{
		$this->pDBInterfaceCon->Query( $sql_query );
		$sql_query = "DELETE FROM ".$GLOBALS['g_egltb_cups']." WHERE id=".$this->iCupId;
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
	
	
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------
	function GetRoundEncounts( $cup_id, $round_start, $round_end )
	{
		$sql_query = " SELECT * ".
					 " FROM `".$GLOBALS['g_egltb_cup_encounts']."` AS encounts ".
					 " WHERE cup_id=$cup_id && round >= $round_start && round <= $round_end  ".
					 " ORDER BY round ASC ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );		
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------
	function GetCupWinner( $oCup, $top_n=3 )
	{
		$top_n--;

		$numRounds = (log($oCup->max_participants)/log(2))+1;
		$aEncounts = $this->GetRoundEncounts( $oCup->id, ($numRounds-1)-$top_n, ($numRounds-1) );

		$aSorted = array();	# sorty by round, place
		$numEnc = sizeof($aEncounts);
		
		//echo "<textarea style='width:100%;' rows=100>";

		#==========================================
		# CHANGED: Sonntag, 28. Mai 2006 
		#==========================================
		for( $t=0; $t < $top_n+1; $t++ )
		{
			$pSort = &$aSorted[sizeof($aSorted)];
			for( $i=0; $i < $numEnc; $i++ )
			{
			
				// richtige runde??	
				if( $aEncounts[$i]->round == ($numRounds-1)-($t) )
				{
					$pEnc = &$pSort[sizeof($pSort)];
					$pEnc = new cup_rnd_enc_details_t;

					# save cup_id
					$pEnc->cup_id 		= $oCup->id;
					$pEnc->subindex 	= $aEncounts[$i]->subindex;
					$pEnc->round 		= $aEncounts[$i]->round;
					$pEnc->is_freeticket= $aEncounts[$i]->is_freeticket;
					
					// wenn noch nicht letzte runde, suche loser
					if( $aEncounts[$i]->round != $numRounds-1 )
					{
						#===============================
						# set loser 
						#===============================
						if( $aEncounts[$i]->winner_id == $aEncounts[$i]->challenger_id 
							/*$aEncounts[$i]->opponent_id != EGL_NO_ID*/ )
						{
							$pEnc->loser_id = $aEncounts[$i]->opponent_id;
						}
						
						
						else if( $aEncounts[$i]->winner_id == $aEncounts[$i]->opponent_id
							/*$aEncounts[$i]->challenger_id != EGL_NO_ID*/ )
						{
							$pEnc->loser_id = $aEncounts[$i]->challenger_id;
						}
					}
					
					// wenn letzte runde, suche gewinner
					else
					{
						#===============================
						# set winner
						#===============================
						if( $aEncounts[$i]->winner_id == $aEncounts[$i]->challenger_id )
						{
							$pEnc->winner_id = $aEncounts[$i]->challenger_id;
							
						}
						else if( $aEncounts[$i]->winner_id == $aEncounts[$i]->opponent_id )
						{
							$pEnc->winner_id = $aEncounts[$i]->opponent_id;
						}	
					
					}
					
					
					if( !$pEnc->is_freeticket )
					{
						# fetch participant_data
						if( $oCup->participant_type == PARTTYPE_TEAM )
						{
							$cTeam = new Team( $this->pDBInterfaceCon );
									
							if( $pEnc->loser_id != EGL_NO_ID )
								$pEnc->participant = $cTeam->GetTeamInfoAsParttype($pEnc->loser_id);
							else if( $pEnc->winner_id != EGL_NO_ID )
								$pEnc->participant = $cTeam->GetTeamInfoAsParttype($pEnc->winner_id);
						} //if
						else if( $oCup->participant_type == PARTTYPE_MEMBER )
						{
							$cMember = new Member( $this->pDBInterfaceCon );
							if( $pEnc->loser_id != EGL_NO_ID )
								$pEnc->participant = $cMember->GetMemberInfoAsParttype($pEnc->loser_id);
							else if( $pEnc->winner_id != EGL_NO_ID )
								$pEnc->participant = $cMember->GetMemberInfoAsParttype($pEnc->winner_id);
						} //elseif
					} // if

					//echo print_r( $pEnc, 1);
					
				}//if
				
			}//for
			
		}//for
		

		/*echo print_r( $aSorted, 1);
		echo "</textarea>";
		exit;*/
		
		
		return $aSorted;
	} // GetCupWinner
	
	

	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------	
	function GetCupAdministrator( $cup_id )
	{
		$sql_query =" SELECT permissions.id, permissions.permissions, permissions.cat_id, permissions.admin_id, permissions.data, permissions.created,
					  		 members.id AS member_id, members.nick_name, members.email ".
					" FROM `{$GLOBALS['g_egltb_admin_permissions']}` AS permissions ".
					" LEFT JOIN `{$GLOBALS['g_egltb_admins']}` AS admins ".
					" ON admins.id=permissions.admin_id ".
					" LEFT JOIN `{$GLOBALS['g_egltb_members']}` AS members ".
					" ON admins.member_id=members.id".
					" WHERE permissions.data='{$cup_id}' && permissions.module_id='".MODULEID_INETOPIA_CUP."' ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );		
		
	}
};

?>