<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-

define( "MATCH_LOCKED",		1 );
define( "MATCH_CLOSED",		2 );
define( "MATCH_REPORTED",	3 );
define( "MATCH_RUNNING",	4 );




# -[ obj ]-
class match_report_t
{
	var $bFirstReport 		= false;
	var $bSecondReport 		= false;
	var $bAdmin				= false;
	var $aParticipants		= array();
	var $oChallenger		= NULL;
	var $oOpponent			= NULL;
	var $oMyPart			= NULL;
	var $iParttype			= NULL;
	var $oMatch				= NULL;
	var $oMatchUpdate		= NULL;
	var $oMatchResults		= NULL;
	var $report_state		= 'unknown'; 		# 'accept' / 'deny'
	var $report_id			= EGL_NO_ID; 		# 'accept' / 'deny'
};
						
						
						

# -[ obj ]-
class round_t
{
	var $round_name			= 'unknown';
	var $challenger_score	= '';
	var $opponent_score		= '';
	var $bchallenger_win	= false;
	var $bopponent_win		= false;
};



# -[ obj ]-
class map_result_t
{
	var $map_name			= 'unknown';
	var $aRounds			= array();
};




# -[ obj ]-

class match_results_t
{
	var $aMapResults 			= array();
	var $bDetailedRounds		= false;
	var $total_challenger_score	= 0;
	var $total_opponent_score	= 0;
	
	var $bchallenger_win		= false;
	var $bopponent_win			= false;
};



# -[ obj ]-
class match_struct_t
{
	var $num_rounds		= 0;
	var $num_maps		= 0;
	var $aRoundNames	= array();
	var $aMaps			= array();
};



# -[ obj ]-
class matchlist_data_t
{
	var $part_type		= 0;
	var $part_id		= EGL_NO_ID;
	var $entry_id		= EGL_NO_ID;
	var $status			= 'unknown';
};




# -[ class ] -
class Match
{
	# -[ variables ]-
	var $iMatchId		= -1;
	var $pDBInterfaceCon		= NULL;
	
	
	# -[ functions ]-
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output :
	//-------------------------------------------------------------------------------
	function Match ( &$pDBCon, $match_id=NULL )
	{
		$this->iMatchId = $match_id;
		$this->pDBInterfaceCon = &$pDBCon;
	}
	
	
	/**
	* Match::GetData()
	*
	*
	*/	
	function GetData($type=0)
	{
		$sql_query = 	" SELECT * FROM `".$GLOBALS['g_egltb_matches']."` AS matches ".
						" WHERE matches.id=".$this->iMatchId;
		
		/*
		$sql_query =	" SELECT games.*, matches.*,  match_structures.game_id, match_structures.num_maps, match_structures.num_rounds, match_structures.round_names, " .
						" games.logo_small_file AS game_logo_small_file, games.logo_big_file AS game_logo_big_file, games.name AS game_name, games.token AS game_token ".
						" FROM ".$GLOBALS['g_egltb_matches']." AS matches, ".$GLOBALS['g_egltb_game_pool']." AS games ".
						" LEFT JOIN ".$GLOBALS['g_egltb_match_structures']." AS match_structures ".
						" ON (matches.type_id = match_structures.id) " .
						" WHERE (games.id=match_structures.game_id) && (matches.id=".(int)$this->iMatchId.") ";
		*/

		/*
		$sql_query =	" SELECT matches.*, reports.participant_id AS report_participant_id, reports.text AS report_text, reports.member_id AS report_member_id  " .
						" FROM ".$GLOBALS['g_egltb_matches']." AS matches ".
						" LEFT JOIN ".$GLOBALS['g_egltb_match_reports']." AS reports ".
						" ON (matches.id = reports.match_id) ".
						" WHERE matches.id=".$this->iMatchId;
		*/
		
		/*
		if( $type == PARTTYPE_MEMBER )
		{
			$sql_query = 	" SELECT matches.*, memb.id AS participant_id, memb.nick_name AS participant_name, memb.country_id AS country_id FROM ".$GLOBALS['g_egltb_matches']." AS matches ".
							" LEFT JOIN ".$GLOBALS['g_egltb_members']." AS memb ".
							" ON (matches.challenger_id=memb.id || matches.opponent_id=memb.id) ".
							" WHERE matches.id=".$this->iMatchId;
		}				

		if( $type == PARTTYPE_TEAM )
		{
			$sql_query = 	" SELECT matches.*, clan_acc.name AS participant_clan_name, clan_acc.id AS participant_clan_id, clan_acc.logo_file AS participant_logo_file, clan_acc.tag AS participant_clan_tag, ".
							" teams.name AS participant_name, teams.id AS participant_id ".
							" FROM ".$GLOBALS['g_egltb_matches']." AS matches ".
							" LEFT JOIN ".$GLOBALS['g_egltb_teams']." AS teams, ".$GLOBALS['g_egltb_clan_accounts']." AS clan_acc ".
							" ON  (matches.challenger_id=teams.id || matches.opponent_id=teams.id) ".
							" WHERE (matches.id=".$this->iMatchId.") && clan_acc.id=teams.clan_id ";
		}*/	
						
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}
	
	
	function GetMatch($match_id)
	{
		$sql_query = 	" SELECT * FROM `".$GLOBALS['g_egltb_matches']."` AS matches ".
						" WHERE matches.id=".(int)$match_id;		
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}	
	
	/**
	* Match::AddMatch()
	*
	*
	*/	
	function AddMatch( $obj )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBInterfaceCon->CreateInsertQuery( $GLOBALS['g_egltb_matches'], $obj );
		return ($this->pDBInterfaceCon->Query( $sql_query ) );
	}
	

	
	
	/**
	* Match::ConvertToMatchDBResult()
	*
	*
	*/
	function ConvertToMatchDBResult( $oResults )
	{
		$aMapArray 	= array();
		$aResults	= array();

		for( $iMap=0; $iMap < sizeof($oResults->aMapResults); $iMap ++ )
		{
			$pMapRes = &$oResults->aMapResults[$iMap];
			#$pMapRes = new map_result_t;
			

			$aMapArray[sizeof($aMapArray)] = $pMapRes->map_name;
			for( $iRnd=0; $iRnd < sizeof($pMapRes->aRounds); $iRnd++ )
			{
				$pRnd = &$pMapRes->aRounds[$iRnd];
				
				
				# add challenger & opponent scores
				$aResults[sizeof($aResults)] = $pRnd->challenger_score;
				$aResults[sizeof($aResults)] = $pRnd->opponent_score;
				
			}//for
		}//for

		
		# convert data to database format 
		$db_results_str = db_create_array_string(  $aResults, '#');
		$db_maps_str = db_create_array_string(  $aMapArray, ',');
		
		

		# define update query
		$obj = NULL;
		#$obj->report_id = $report_id;
		$obj->results 	= $db_results_str;
		$obj->maps 		= $db_maps_str;
		
		return $obj;
		# Set matchdata
		#return $this->SetMatchData( $obj );
	}
	
	
	/**
	* Match::SetMatchData()
	*
	*
	*/
	function SetMatchData( $obj, $match_id=NULL )
	{
		# execue query
		if( $match_id == NULL && !$this->iMatchId ) return false;
		if( $match_id == NULL ) $match_id = $this->iMatchId;
		
		$sql_query = 	$this->pDBInterfaceCon->CreateUpdateQuery( $GLOBALS['g_egltb_matches'], $obj ).
						" WHERE id=".(int)$match_id;
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
		

	/**
	 * Match::FetchMatchResults()
	 *
	 * @param unknown_type $match
	 * @param unknown_type $based_on_results	map-count based on the given results, stored
	 * @return unknown
	 */
	function FetchMatchResults( $match, $based_on_results=true )
	{
		$oMatchResults = new match_results_t;
			
		# get result array
		$aResults 			= explode( '#', $match->results );
		$aMaps	 			= explode( ',', $match->maps);
		$aRoundNames		= explode( ',', $match->round_names );
		
		$bDetailedRounds 	= false;
		$aMapResults 		= array();
		$map_cnt			= 0;
		
		# ????
		$xxy = 0;
		if( $based_on_results && $match->num_rounds > 0 )
		{
			$xxy = sizeof($aResults)/((int)($match->num_rounds*2));
			if( (int)$xxy != $xxy ) $xxy = (int)$xxy+1;
		}else  $xxy = $match->num_maps;
			
		// for earch map
		for( $i=0, $array_cnt=0; $i < $xxy;  $i++)
		{
			$pRes = &$aMapResults[sizeof($aMapResults)];
			$pRes = new map_result_t;
			
			// for each round
			for( $r=0; $r < ((int)($match->num_rounds)); $r++, $array_cnt+=2  )
			{
				$pRnd = &$pRes->aRounds[sizeof($pRes->aRounds)];
				$pRnd = new round_t;
				$pRnd->challenger_score	= $aResults[$array_cnt];
				$pRnd->opponent_score	= $aResults[$array_cnt+1];
				$pRnd->round_name 		= $aRoundNames[$r];
				
				$oMatchResults->total_challenger_score += (int)$pRnd->challenger_score;
				$oMatchResults->total_opponent_score += (int)$pRnd->opponent_score;
				
					# challenger won ?
				if( $pRnd->challenger_score > $pRnd->opponent_score )
					$pRnd->bchallenger_win = true;
				# opponent won ?
				if( $pRnd->opponent_score > $pRnd->challenger_score )
					$pRnd->bopponent_win = true;
			
				
				if( strlen($pRnd->round_name) > 0 ) $bDetailedRounds = true;
			}
							
			$pRes->map_name = $aMaps[$map_cnt];
			$map_cnt++;
		}
			
			
		# global >> challenger win ?
		if( $oMatchResults->total_challenger_score > $oMatchResults->total_opponent_score )
			$oMatchResults->bchallenger_win = true;
			
		# global >> opponent win ?
		if( $oMatchResults->total_opponent_score > $oMatchResults->total_challenger_score )
			$oMatchResults->bopponent_win = true;
				
		$oMatchResults->total_challenger_score	= (string)$oMatchResults->total_challenger_score;
		$oMatchResults->total_opponent_score		= (string)$oMatchResults->total_opponent_score;
			
		$oMatchResults->aMapResults 	= $aMapResults;
		$oMatchResults->bDetailedRounds = $bDetailedRounds;
		return $oMatchResults;
	}
	
	
	/**
	* Match::NoMatchResults()
	*
	*
	*/
	function NoMatchResults( $num_maps,$num_rnd )
	{
		$str_results="";
		for( $i=0; $i < $num_maps; $i++ )
			for( $r=0; $r < $num_maps; $r++ )
				$str_results .= "0#0#";
		return substr( $str_results, 0, strlen($str_results)-1);		
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//
	// ATTENTION:	it's not necessary to use functions converting the sub maps/rounds
	//-------------------------------------------------------------------------------
	function FetchMatchStructure( $match )
	{
		$oMatchStruct = new match_struct_t;
		
		$oMatchStruct->aMaps = explode( ',', $match->maps );
		$oMatchStruct->aRoundNames = explode( ',', $match->round_names );
		$oMatchStruct->num_maps = $match->num_maps;
		$oMatchStruct->num_rounds = $match->num_rounds;
		
		
		return $oMatchStruct;
	}
	
	/**
	* Match::FetchMatchStructure_as_Results()
	*
	*
	*/
	function FetchMatchStructure_as_Results( $match )
	{
	}
	
	/**
	* Match::GetMatches()
	*
	*
	*/
	function GetMatches( $type, $module_id, $match_status )
	{
	}
	
	/**
	* Match::GetNumMatches()
	*
	*
	*/
	function GetNumMatches()
	{
		$sql_query = 	" SELECT COUNT(*) AS num_matches ".
						" FROM `".$GLOBALS['g_egltb_matches']."` AS matches".
						"";
		$object = $this->pDBInterfaceCon->FetchObject($this->pDBInterfaceCon->Query( $sql_query ));
		return $object->num_matches;
	}
	
	
	/**
	* Match::TranslateRating()
	*
	*
	*/
	function TranslateRating( $rate )
	{
		if( $rate[0] == 'n' )
			return (int)(-(substr( $rate, 0, strlen($rate)-1)));
		else return (int)$rate;
	}

	
	/**
	* Match::DeleteMatch()
	*
	* @param 	integer 	match-id
	* @return 	bool		true/false
	*/
	function DeleteMatch( $match_id )
	{
		$sql_query = "DELETE FROM `".$GLOBALS["g_egltb_matches"]."` WHERE id=$match_id";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}

};


?>