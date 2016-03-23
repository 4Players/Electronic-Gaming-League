<?php
# ================================ Copyright ï¿½ 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================

# -[ defines ]-
define("CHALLENGETYPE_SINGLE_MAP",	2 );
define("CHALLENGETYPE_DOUBLE_MAP",	4 );
define("CHALLENGETYPE_RANDOM_MAP",	8 );


define( "CHALLENGESTATE_CHALLENGING",	2 );
define( "CHALLENGESTATE_ACCEPTED",		4 );
define( "CHALLENGESTATE_DENIED",		8 );
	

$GLOBALS['g_egltb_ladder_participants'] 			= "egl_ladder_participants";
$GLOBALS['g_egltb_ladder_encounts'] 				= "egl_ladder_encounts";
$GLOBALS['g_egltb_ladders'] 						= "egl_ladders";
$GLOBALS['g_egltb_ladder_challenges'] 				= "egl_ladder_challenges";
$GLOBALS['g_egltb_ladder_challenge_comments'] 		= "egl_ladder_challenge_comments";


 DBTB::RegisterTB( 'LADDER', 'LADDER_PARTICIPANTS',			'egl_ladder_participants' );
 DBTB::RegisterTB( 'LADDER', 'LADDER_ENCOUNTS',				'egl_ladder_encounts' );
 DBTB::RegisterTB( 'LADDER', 'LADDERS',						'egl_ladders' );
 DBTB::RegisterTB( 'LADDER', 'LADDER_CHALLENGES',			'egl_ladder_challenges' );
 DBTB::RegisterTB( 'LADDER', 'LADDER_CHALLENGE_COMMENTS',	'egl_ladder_challenge_comments' );

 
/**
 * 
 *
 * @copyright 	Inetopia
 * @author		Inetopia <support@inetopia.de>
 * @package 	EGL.Module.InetopiaLadder
 **/
class InetopiaLadder
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
	function InetopiaLadder (&$pDBCon)
	{
		$this->pDBInterfaceCon = NULL;
		
		# save reference
		$this->pDBInterfaceCon = &$pDBCon;
	}//function
	
	
	

	/**
	 * Read current ladder-participant list, ordered by points
	 *
	 * @param	int		ParticipantType (PARTTYPE_MEMBER/PARTTYPE_TEAM)
	 * @return	array	Array of the fechted participantlist according to the overgiven ladderid
	 **/
	function GetLadderParticipants( $participant_type, $ladder_id, $limit_start=0, $l_num=0 )
	{
		$limit='';
		if( $limit_start&&$l_num ) $limit = " LIMIT $limit_start,$l_num ";
		if( !$limit_start&&$l_num ) $limit = " LIMIT 0,$l_num ";

			
		/**********************************************
		** PARTICIPANT-TYPE -> Member
		***********************************************/
		if( $participant_type == PARTTYPE_MEMBER )
		{
			/*
				# ---------------
				# select ??
				# ---------------
				SELECT *, members.nick_name AS participant_name, members.id AS participant_id, members.photo_file, ladder_parts.id AS id
				FROM egl_ladder_participants AS ladder_parts
				LEFT JOIN egl_members AS members
					ON members.id=ladder_parts.participant_id
				LEFT JOIN 	( 	SELECT COUNT(*) AS num_matches, matches.*
								FROM egl_matches AS matches
								WHERE matches.module_id='A9CCDCBF-C696-422c-A0D8-91223A9C22E6' && matches.winner_id=members.id
								GROUP BY matches.module_entry_id
								
							) AS match_wins
					ON match_wins.challenger_id=members.id
										 
				WHERE ladder_parts.ladder_id=1
				ORDER BY ladder_parts.points DESC
				LIMIT 0, 10 ;

				
				# ---------------
				# select matches
				# ---------------
				SELECT parts.id, parts.participant_id, COUNT(*) AS num_matches
				FROM egl_ladder_participants AS parts
				LEFT JOIN egl_matches As matches
				ON (parts.participant_id = matches.challenger_id || parts.participant_id=matches.opponent_id)
				WHERE matches.module_id='A9CCDCBF-C696-422c-A0D8-91223A9C22E6' && matches.module_entry_id=1
				GROUP BY parts.participant_id 				
				
			*/


			$sql_matches_won =		" SELECT parts.id, matches.id AS match_id, parts.participant_id, COUNT(parts.participant_id) AS num_matches ".
									" FROM 	egl_ladder_participants AS parts ".
									" LEFT JOIN egl_matches As matches ".
									" ON  ( parts.participant_id = matches.opponent_id || parts.participant_id=matches.challenger_id ) && parts.ladder_id={$ladder_id} " .
									" WHERE  matches.winner_id=parts.participant_id  && matches.status=".MATCH_CLOSED." && ".
									" 		 matches.module_id='".MODULEID_INETOPIA_LADDER."' && matches.module_entry_id={$ladder_id} ".
									" GROUP BY participant_id" ;
			
			$sql_matches_lost =		" SELECT parts.id, matches.id AS match_id, parts.participant_id, COUNT(parts.participant_id) AS num_matches ".
									" FROM 	egl_ladder_participants AS parts ".
									" LEFT JOIN egl_matches As matches ".
									" ON  ( parts.participant_id = matches.opponent_id || parts.participant_id=matches.challenger_id ) && parts.ladder_id={$ladder_id} " .
									" WHERE   matches.winner_id!=parts.participant_id && matches.winner_id!=".EGL_NO_ID." && matches.status=".MATCH_CLOSED." && ".
									" 		 matches.module_id='".MODULEID_INETOPIA_LADDER."' && matches.module_entry_id={$ladder_id} ".
									" GROUP BY participant_id" ;

			$sql_matches_draw =		" SELECT parts.id, matches.id AS match_id, parts.participant_id, COUNT(parts.participant_id) AS num_matches ".
									" FROM 	egl_ladder_participants AS parts ".
									" LEFT JOIN egl_matches As matches ".
									" ON  ( parts.participant_id = matches.opponent_id || parts.participant_id=matches.challenger_id ) && parts.ladder_id={$ladder_id} " .
									" WHERE  matches.winner_id=".EGL_NO_ID." && matches.status=".MATCH_CLOSED." && ".
									" 		 matches.module_id='".MODULEID_INETOPIA_LADDER."' && matches.module_entry_id={$ladder_id} ".
									" GROUP BY participant_id" ;
					
			$sql_matches_all =		" SELECT parts.id, matches.id AS match_id, parts.participant_id, COUNT(parts.participant_id) AS num_matches ".
									" FROM 	egl_ladder_participants AS parts ".
									" LEFT JOIN egl_matches As matches ".
									" ON  ( parts.participant_id = matches.opponent_id || parts.participant_id=matches.challenger_id ) && parts.ladder_id={$ladder_id} " .
									" WHERE  ".
									" 		 matches.module_id='".MODULEID_INETOPIA_LADDER."' && matches.module_entry_id={$ladder_id} ".
									" GROUP BY participant_id" ;
					
			# general query
			$sql_query = 			" SELECT ladder_parts.*, members.nick_name AS participant_name, members.id AS participant_id, members.photo_file, ladder_parts.id AS id, ".
									" 		 matches_won.num_matches AS matches_won, ".
									" 		 matches_lost.num_matches AS matches_lost, ".
									" 		 matches_draw.num_matches AS matches_draw, ".
									" 		 matches_all.num_matches AS matches_all, ".
									"		 country.image_file AS country_image_file, country.name AS country_name, country.token AS country_token ".	
									
									" FROM {$GLOBALS['g_egltb_ladder_participants']} AS ladder_parts ".
										" LEFT JOIN {$GLOBALS['g_egltb_members']} AS members ".
											" ON members.id=ladder_parts.participant_id ".
										" LEFT JOIN `".$GLOBALS['g_egltb_countries']."` AS country ".
											" ON country.id=members.country_id ".
											
										" LEFT JOIN ($sql_matches_won) AS matches_won " .
											" ON matches_won.participant_id=ladder_parts.participant_id ".
									 	" LEFT JOIN ($sql_matches_lost) AS matches_lost " .
									 		" ON matches_lost.participant_id=ladder_parts.participant_id ".
									 	" LEFT JOIN ($sql_matches_draw) AS matches_draw " .
									 		" ON matches_draw.participant_id=ladder_parts.participant_id ".
									 	" LEFT JOIN ($sql_matches_all) AS matches_all " .
									 		" ON matches_all.participant_id=ladder_parts.participant_id ".
									" WHERE ladder_parts.ladder_id={$ladder_id} ". 
									" ORDER BY ladder_parts.points DESC,ladder_parts.created ASC ".
									" $limit ";
						 
			return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
						
		}
		/**********************************************
		** PARTICIPANT-TYPE -> Team
		***********************************************/
		else if( $participant_type == PARTTYPE_TEAM )
		{
			$sql_matches_won =		" SELECT parts.id, matches.id AS match_id, parts.participant_id, COUNT(parts.participant_id) AS num_matches ".
									" FROM 	egl_ladder_participants AS parts ".
									" LEFT JOIN egl_matches As matches ".
									" ON  ( parts.participant_id = matches.opponent_id || parts.participant_id=matches.challenger_id ) && parts.ladder_id={$ladder_id} " .
									" WHERE  matches.winner_id=parts.participant_id  && matches.status=".MATCH_CLOSED." && ".
									" 		 matches.module_id='".MODULEID_INETOPIA_LADDER."' && matches.module_entry_id={$ladder_id} ".
									" GROUP BY participant_id" ;
			
			$sql_matches_lost =		" SELECT parts.id, matches.id AS match_id, parts.participant_id, COUNT(parts.participant_id) AS num_matches ".
									" FROM 	egl_ladder_participants AS parts ".
									" LEFT JOIN egl_matches As matches ".
									" ON  ( parts.participant_id = matches.opponent_id || parts.participant_id=matches.challenger_id ) && parts.ladder_id={$ladder_id} " .
									" WHERE   matches.winner_id!=parts.participant_id && matches.winner_id!=".EGL_NO_ID." && matches.status=".MATCH_CLOSED." && ".
									" 		 matches.module_id='".MODULEID_INETOPIA_LADDER."' && matches.module_entry_id={$ladder_id} ".
									" GROUP BY participant_id" ;

			$sql_matches_draw =		" SELECT parts.id, matches.id AS match_id, parts.participant_id, COUNT(parts.participant_id) AS num_matches ".
									" FROM 	egl_ladder_participants AS parts ".
									" LEFT JOIN egl_matches As matches ".
									" ON  ( parts.participant_id = matches.opponent_id || parts.participant_id=matches.challenger_id ) && parts.ladder_id={$ladder_id} " .
									" WHERE  matches.winner_id=".EGL_NO_ID." && matches.status=".MATCH_CLOSED." && ".
									" 		 matches.module_id='".MODULEID_INETOPIA_LADDER."' && matches.module_entry_id={$ladder_id} ".
									" GROUP BY participant_id" ;

			
			$sql_matches_all =		" SELECT parts.id, matches.id AS match_id, parts.participant_id, COUNT(parts.participant_id) AS num_matches ".
									" FROM 	egl_ladder_participants AS parts ".
									" LEFT JOIN egl_matches As matches ".
									" ON  ( parts.participant_id = matches.opponent_id || parts.participant_id=matches.challenger_id ) && parts.ladder_id={$ladder_id} " .
									" WHERE  ".
									" 		 matches.module_id='".MODULEID_INETOPIA_LADDER."' && matches.module_entry_id={$ladder_id} ".
									" GROUP BY participant_id" ;
									
			
			$sql_query = 			" SELECT ladder_parts.*, teams.name AS participant_name, teams.logo_file AS team_logo_file, teams.id AS participant_id, ladder_parts.id AS id, ".
									" 		 clans.name AS participant_clan_name, clans.tag AS participant_clan_tag, clans.id AS participant_clan_id, ".
									" 		 matches_won.num_matches AS matches_won, ".
									" 		 matches_lost.num_matches AS matches_lost, ".
									" 		 matches_draw.num_matches AS matches_draw, ".
									" 		 matches_all.num_matches AS matches_all, ".
									"		 country.image_file AS country_image_file, country.name AS country_name, country.token AS country_token ".	
									" FROM {$GLOBALS['g_egltb_ladder_participants']} AS ladder_parts ".
										" LEFT JOIN {$GLOBALS['g_egltb_teams']} AS teams ".
											" ON teams.id=ladder_parts.participant_id ".
										" LEFT JOIN {$GLOBALS['g_egltb_clan_accounts']} AS clans ".
											" ON teams.clan_id=clans.id ".
										" LEFT JOIN `".$GLOBALS['g_egltb_countries']."` AS country ".
											" ON country.id=teams.country_id ".
									
										" LEFT JOIN ($sql_matches_won) AS matches_won " .
											" ON matches_won.participant_id=ladder_parts.participant_id ".
									 	" LEFT JOIN ($sql_matches_lost) AS matches_lost " .
									 		" ON matches_lost.participant_id=ladder_parts.participant_id ".
									 	" LEFT JOIN ($sql_matches_draw) AS matches_draw " .
									 		" ON matches_draw.participant_id=ladder_parts.participant_id ".
									 	" LEFT JOIN ($sql_matches_all) AS matches_all " .
									 		" ON matches_all.participant_id=ladder_parts.participant_id ".
									 													
									" WHERE ladder_parts.ladder_id={$ladder_id} ". 
									" ORDER BY ladder_parts.points DESC,ladder_parts.created ASC  ".
									" $limit";

			return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
		}
	}//function

	
	
	/**
	 * Read ladder data from DB
	 *
	 * @param	int		Ladder-ID
	 * @return	object	Ladderdata object
	 **/
	function GetLadderbyID( $ladder_id )
	{
		$sql_query = " SELECT ladders.name, ladders.id, ladders.*, games.name AS game_name, games.token AS game_token, games.id AS game_id ".
					 " FROM `".$GLOBALS['g_egltb_ladders']."` AS ladders ".
					 " LEFT JOIN `".$GLOBALS['g_egltb_game_pool']."` AS games ".
					 " ON games.id=ladders.game_id ".
					 " WHERE ladders.id=".(int)$ladder_id." ";
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}
	
	/**
	 * read ladder-data
	 *
	 * @param	int		Ladder-ID
	 * @return	object	Ladderdata object
	 **/
	function GetLadderDataByID( $ladder_id ){
		$sql_query = " SELECT * ".
					 " FROM `".$GLOBALS['g_egltb_ladders']."` AS ladders ".
					 " WHERE ladders.id=".(int)$ladder_id." ";
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}
	
	
	/**
	 * Read ladder data from DB
	 *
	 * @param	int		part-id => not team/member-id
	 * @return	object	Ladderdata object
	 **/
	function GetLadderbyPartID( $part_id )
	{
		$sql_query = " SELECT ladder_parts.participant_id, ladders.name, ladders.*, games.name AS game_name, games.id AS game_id ".
					 " FROM `{$GLOBALS['g_egltb_ladder_participants']}` AS ladder_parts ".
					 	" LEFT JOIN `{$GLOBALS['g_egltb_ladders']}` AS ladders ".
					 		" ON ladder_parts.ladder_id=ladders.id ".
					 	" LEFT JOIN `{$GLOBALS['g_egltb_game_pool']}` AS games ".
					 		" ON games.id=ladders.game_id ".
					 " WHERE ladder_parts.id={$part_id} ";
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}	
	
	
	
	/**
	 * Game Ladders, by game_id
	 *
	 * @param	int		Game-Id
	 * @return	array	ladder object array
	 **/
	function  GetDetailedLadderByGameId( $game_id )
	{
		$sql_matches = 	" SELECT COUNT(*) AS num_matches, matches.module_entry_id ".
					 	" FROM `{$GLOBALS['g_egltb_matches']}` AS matches ".
					 	" WHERE matches.module_id='".MODULEID_INETOPIA_LADDER."'".
					 	" GROUP BY matches.module_entry_id ";
					 	
		$sql_query = " SELECT ladders.*, COUNT(ladder_parts.ladder_id) AS num_participants, matches.num_matches, ".
					 " country.image_file AS country_image_file, country.name AS country_name, country.token AS country_token ".
					 " FROM `{$GLOBALS['g_egltb_ladders']}` AS ladders ".
						 " LEFT JOIN `{$GLOBALS['g_egltb_ladder_participants']}` AS ladder_parts ".
							 " ON ladder_parts.ladder_id=ladders.id ".
						 " LEFT JOIN ( {$sql_matches} ) AS matches ".
							 " ON matches.module_entry_id=ladders.id ".
						 " LEFT JOIN `".$GLOBALS['g_egltb_countries']."` AS country ".
						 	 " ON country.id=ladders.country_id ".
					 " WHERE ladders.game_id={$game_id} ".
					 " GROUP by ladders.id ".
					 " ORDER BY ladders.name ASC ";
					 
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}
	
	
	
	/**
	 * GameLadder last ecounts(matches), by game_id
	 *
	 * @param	int		Ladder-ID
	 * @param 	int		Participant-Type	PARTTYPE_MEMBER | PARRTYPE_TEAM
	 * @return	int		Top-N, listed
	 **/
	function GetMatchesByLadder( $participant_type, $ladder_id, $limit_start=0, $limit_cnt=0 )
	{
		$limit='';
		if( $limit_start&&$limit_cnt ) $limit = " LIMIT $limit_start,$limit_cnt ";
		if( !$limit_start&&$limit_cnt ) $limit = " LIMIT 0,$limit_cnt ";
		
		if( $participant_type == PARTTYPE_MEMBER )
		{
			$sql_query = " SELECT matches.*, ladder_encounts.match_id, ladder_encounts.id AS encount_id, ".
						 " challenger.nick_name AS challenger_participant_name, challenger.id AS challenger_participant_id, ".
						 " opponent.nick_name AS opponent_participant_name, opponent.id AS opponent_participant_id  ".
						 
						 " FROM `{$GLOBALS['g_egltb_ladder_encounts']}` AS ladder_encounts ".
							 " LEFT JOIN `{$GLOBALS['g_egltb_matches']}` AS matches ".
								 " ON matches.id=ladder_encounts.match_id ".
							 " LEFT JOIN `{$GLOBALS['g_egltb_members']}` AS challenger ".
								 " ON challenger.id=matches.challenger_id ".
							 " LEFT JOIN `{$GLOBALS['g_egltb_members']}` AS opponent ".
								 " ON opponent.id=matches.opponent_id ".
						 " WHERE ladder_encounts.ladder_id={$ladder_id} ".
						 " ORDER BY matches.evaluate_time DESC ".
						 " $limit";
						 
			return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
		}
		elseif( $participant_type == PARTTYPE_TEAM )
		{
			/**??*/
			$sql_query = " SELECT matches.*, ladder_encounts.match_id, ladder_encounts.id AS encount_id,  ".
							" 		 challenger.name AS challenger_participant_name, challenger.id AS challenger_participant_id, ".
							"		 challenger_cl.name AS challenger_participant_clan_name, challenger_cl.id AS challenger_participant_clan_id, challenger_cl.tag AS challenger_participant_clan_tag, ".
							
							" 		 opponent.name AS opponent_participant_name, opponent.id AS opponent_participant_id, ".
							"		 opponent_cl.name AS opponent_participant_clan_name, opponent_cl.id AS opponent_participant_clan_id, opponent_cl.tag AS opponent_participant_clan_tag ".
			
						 " FROM `{$GLOBALS['g_egltb_ladder_encounts']}` AS ladder_encounts ".
							 " LEFT JOIN `{$GLOBALS['g_egltb_matches']}` AS matches ".
								 " ON matches.id=ladder_encounts.match_id ".
								
								" LEFT JOIN `{$GLOBALS['g_egltb_teams']}` AS challenger ".
									" ON challenger.id=matches.challenger_id ".
								" LEFT JOIN `{$GLOBALS['g_egltb_clan_accounts']}` AS challenger_cl ".
									" ON challenger_cl.id=challenger.clan_id ".
								
								" LEFT JOIN `{$GLOBALS['g_egltb_teams']}` AS opponent ".
									" ON opponent.id=matches.opponent_id ".
								" LEFT JOIN `{$GLOBALS['g_egltb_clan_accounts']}` AS opponent_cl ".
									" ON opponent_cl.id=opponent.clan_id ".
								
						 " WHERE ladder_encounts.ladder_id={$ladder_id} ".
						 " ORDER BY matches.evaluate_time ASC ".
						 " $limit";
			return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
		}//if
	}	

	
	/**
	 * GameLadder last ecounts(matches), by game_id
	 *
	 * @param	int		Ladder-ID
	 * @param 	int		Participant-Type	PARTTYPE_MEMBER | PARRTYPE_TEAM
	 * @return	int		Top-N, listed
	 **/
	function GetLastLadderEncounts( $participant_type, $ladder_id, $top_n=10 )
	{
		$limit='';
		if( $top_n ) $limit = " LIMIT 0,$top_n ";
		
		if( $participant_type == PARTTYPE_MEMBER )
		{
			$sql_query = " SELECT matches.*, ladder_encounts.match_id, ".
							 " challenger.nick_name AS challenger_participant_name, challenger.id AS challenger_participant_id, ".
							 " opponent.nick_name AS opponent_participant_name, opponent.id AS opponent_participant_id  ".
						 " FROM `{$GLOBALS['g_egltb_ladder_encounts']}` AS ladder_encounts ".
							 " LEFT JOIN `{$GLOBALS['g_egltb_matches']}` AS matches ".
								 " ON matches.id=ladder_encounts.match_id ".
							 " LEFT JOIN `{$GLOBALS['g_egltb_members']}` AS challenger ".
								 " ON challenger.id=matches.challenger_id ".
							 " LEFT JOIN `{$GLOBALS['g_egltb_members']}` AS opponent ".
								 " ON opponent.id=matches.opponent_id ".
						 " WHERE ladder_encounts.ladder_id={$ladder_id} && matches.status=".MATCH_CLOSED." && matches.evaluated".
						 " ORDER BY matches.evaluate_time DESC ".
						 " $limit";
						 
			return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
		}
		elseif( $participant_type == PARTTYPE_TEAM )
		{
			$sql_query = " SELECT matches.*, ladder_encounts.match_id, ".
						 " 		 challenger.name AS challenger_participant_name, challenger.id AS challenger_participant_id, ".
						 "		 challenger_cl.name AS challenger_participant_clan_name, challenger_cl.id AS challenger_participant_clan_id, challenger_cl.tag AS challenger_participant_clan_tag, ".
						 
						 " 		 opponent.name AS opponent_participant_name, opponent.id AS opponent_participant_id, ".
						 "		 opponent_cl.name AS opponent_participant_clan_name, opponent_cl.id AS opponent_participant_clan_id, opponent_cl.tag AS opponent_participant_clan_tag ".
						 " FROM `{$GLOBALS['g_egltb_ladder_encounts']}` AS ladder_encounts ".
							 	" LEFT JOIN `{$GLOBALS['g_egltb_matches']}` AS matches ".
									" ON matches.id=ladder_encounts.match_id ".
								" LEFT JOIN `{$GLOBALS['g_egltb_teams']}` AS challenger ".
									" ON challenger.id=matches.challenger_id ".
								" LEFT JOIN `{$GLOBALS['g_egltb_clan_accounts']}` AS challenger_cl ".
									" ON challenger_cl.id=challenger.clan_id ".
								" LEFT JOIN `{$GLOBALS['g_egltb_teams']}` AS opponent ".
									" ON opponent.id=matches.opponent_id ".
								" LEFT JOIN `{$GLOBALS['g_egltb_clan_accounts']}` AS opponent_cl ".
									" ON opponent_cl.id=opponent.clan_id ".
								 
						 " WHERE ladder_encounts.ladder_id={$ladder_id} && matches.status=".MATCH_CLOSED." && matches.evaluated".
						 " ORDER BY matches.evaluate_time DESC ".
						 " $limit";
						 
			return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
		}
	}	
	
	
	/**
	 * GameLadder next ecounts(matches), by game_id
	 *
	 * @param	int		Ladder-ID
	 * @return	int		Top-N, listed
	 **/
	function GetNextLadderEncounts( $participant_type, $ladder_id, $time_start=EGL_TIME, $time_end=0, $top_n=10 )
	{
		$limit='';
		if( $top_n ) $limit = " LIMIT 0,$top_n ";
		
		if( $participant_type == PARTTYPE_MEMBER )
		{		
			$STR_TIME_END = "";
			if( $time_end > 0 ) $STR_TIME_END = " && matches.challenge_time < {$time_end} ";
			$sql_query = " SELECT matches.*, ".
						 " challenger.nick_name AS challenger_participant_name, challenger.id AS challenger_participant_id, ".
						 " opponent.nick_name AS opponent_participant_name, opponent.id AS opponent_participant_id  ".
						 " FROM {$GLOBALS['g_egltb_ladder_encounts']} AS ladder_encounts ".
							 " LEFT JOIN {$GLOBALS['g_egltb_matches']} AS matches ".
								 " ON matches.id=ladder_encounts.match_id ".
							 " LEFT JOIN {$GLOBALS['g_egltb_members']} AS challenger ".
								 " ON challenger.id=matches.challenger_id ".
							 " LEFT JOIN {$GLOBALS['g_egltb_members']} AS opponent ".
								 " ON opponent.id=matches.opponent_id ".
						 
						 " WHERE ladder_encounts.ladder_id={$ladder_id} && matches.status=".MATCH_RUNNING." && (matches.challenge_time > {$time_start}) {$STR_TIME_END} ".
						 " ORDER BY matches.challenge_time ASC ".
						 " $limit ";
						 
			return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
		}
		elseif( $participant_type == PARTTYPE_TEAM )
		{
			$STR_TIME_END = "";
			if( $time_end ) $STR_TIME_END = " && matches.challenge_time < {$time_end} ";
			$sql_query = " SELECT matches.*, ".
							" 		 challenger.name AS challenger_participant_name, challenger.id AS challenger_participant_id, ".
							"		 challenger_cl.name AS challenger_participant_clan_name, challenger_cl.id AS challenger_participant_clan_id, challenger_cl.tag AS challenger_participant_clan_tag, ".
							
							" 		 opponent.name AS opponent_participant_name, opponent.id AS opponent_participant_id, ".
							"		 opponent_cl.name AS opponent_participant_clan_name, opponent_cl.id AS opponent_participant_clan_id, opponent_cl.tag AS opponent_participant_clan_tag ".
						 
						 	" FROM {$GLOBALS['g_egltb_ladder_encounts']} AS ladder_encounts ".
								 " LEFT JOIN {$GLOBALS['g_egltb_matches']} AS matches ".
									 " ON matches.id=ladder_encounts.match_id ".
								 
								 
								" LEFT JOIN `{$GLOBALS['g_egltb_teams']}` AS challenger ".
									" ON challenger.id=matches.challenger_id ".
								" LEFT JOIN `{$GLOBALS['g_egltb_clan_accounts']}` AS challenger_cl ".
									" ON challenger_cl.id=challenger.clan_id ".
							
								" LEFT JOIN `{$GLOBALS['g_egltb_teams']}` AS opponent ".
									" ON opponent.id=matches.opponent_id ".
								" LEFT JOIN `{$GLOBALS['g_egltb_clan_accounts']}` AS opponent_cl ".
									" ON opponent_cl.id=opponent.clan_id ".
						 
						 " WHERE ladder_encounts.ladder_id={$ladder_id} && matches.status=".MATCH_RUNNING." && matches.challenge_time > {$time_start} {$STR_TIME_END} ".
						 " ORDER BY matches.challenge_time ASC ".
						 " $limit ";
						 
			return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
		}		
	}
	
	
	
	/**
	 * GameLadder last matches by participant_id, by game_id
	 *
	 * @param 	int		Participant-ID
	 * @param	int		Ladder-ID
	 * @return	int		Top-N, listed
	 **/
	function GetLadderMatchesByParticipantId( $participant_type, $participant_id, $ladder_id, $limit_start=0, $limit_cnt=0 )
	{
		$limit='';
		if( $limit_start&&$limit_cnt ) $limit = " LIMIT $limit_start,$limit_cnt ";
		if( !$limit_start&&$limit_cnt ) $limit = " LIMIT 0,$limit_cnt ";

		if( $participant_type == PARTTYPE_MEMBER )
		{			
			$sql_query = " SELECT matches.*, ".
						 " challenger.nick_name AS challenger_participant_name, challenger.id AS challenger_participant_id, ".
						 " opponent.nick_name AS opponent_participant_name, opponent.id AS opponent_participant_id  ".
						 
						 " FROM {$GLOBALS['g_egltb_ladder_encounts']} AS ladder_encounts ".
							 " LEFT JOIN {$GLOBALS['g_egltb_matches']} AS matches ".
								 " ON matches.id=ladder_encounts.match_id ".
							 " LEFT JOIN {$GLOBALS['g_egltb_members']} AS challenger ".
								 " ON challenger.id=matches.challenger_id ".
							 " LEFT JOIN {$GLOBALS['g_egltb_members']} AS opponent ".
								 " ON opponent.id=matches.opponent_id ".
						 " WHERE ladder_encounts.ladder_id={$ladder_id} && (matches.challenger_id=$participant_id||matches.opponent_id=$participant_id) ".
						 " ORDER BY matches.evaluate_time DESC ".
						 " $limit ";
						 
			return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
		}
		elseif( $participant_type == PARTTYPE_TEAM )
		{
			$sql_query = " SELECT matches.*, ".
							" 		 challenger.name AS challenger_participant_name, challenger.id AS challenger_participant_id, ".
							"		 challenger_cl.name AS challenger_participant_clan_name, challenger_cl.id AS challenger_participant_clan_id, challenger_cl.tag AS challenger_participant_clan_tag, ".
							
							" 		 opponent.name AS opponent_participant_name, opponent.id AS opponent_participant_id, ".
							"		 opponent_cl.name AS opponent_participant_clan_name, opponent_cl.id AS opponent_participant_clan_id, opponent_cl.tag AS opponent_participant_clan_tag ".
						 
						 " FROM {$GLOBALS['g_egltb_ladder_encounts']} AS ladder_encounts ".
							" LEFT JOIN {$GLOBALS['g_egltb_matches']} AS matches ".
								" ON matches.id=ladder_encounts.match_id ".
								 
							" LEFT JOIN `{$GLOBALS['g_egltb_teams']}` AS challenger ".
								" ON challenger.id=matches.challenger_id ".
							" LEFT JOIN `{$GLOBALS['g_egltb_clan_accounts']}` AS challenger_cl ".
								" ON challenger_cl.id=challenger.clan_id ".
							
							" LEFT JOIN `{$GLOBALS['g_egltb_teams']}` AS opponent ".
								" ON opponent.id=matches.opponent_id ".
							" LEFT JOIN `{$GLOBALS['g_egltb_clan_accounts']}` AS opponent_cl ".
								" ON opponent_cl.id=opponent.clan_id ".
																	 
						 " WHERE ladder_encounts.ladder_id={$ladder_id} && (matches.challenger_id=$participant_id||matches.opponent_id=$participant_id) ".
						 " ORDER BY matches.evaluate_time DESC ".
						 " $limit ";
			return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
		}
	}	

	
	
	/**
	 * Game ladderparticipants next ecounts(matches), by game_id
	 *
	 * @param	int		participant-type
	 * @return	int		participant
	 **/
	function GetLadderParticipantbyId( $participant_type, $partid )
	{
		/**********************************************
		** PARTICIPANT-TYPE -> Member
		***********************************************/
		if( $participant_type == PARTTYPE_MEMBER )
		{
	
			$sql_query = " SELECT ladder_parts.*, members.nick_name AS participant_name, members.id AS participant_id, members.photo_file ".
						 " FROM {$GLOBALS['g_egltb_ladder_participants']} AS ladder_parts ".
						 " LEFT JOIN {$GLOBALS['g_egltb_members']} AS members ".
						 " ON members.id=ladder_parts.participant_id ".
						 " WHERE ladder_parts.id={$partid} ";
			return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
						
		}
		/**********************************************
		** PARTICIPANT-TYPE -> Team
		***********************************************/
		else if( $participant_type == PARTTYPE_TEAM )
		{

			$sql_query = " SELECT ladder_parts.*, teams.name AS participant_name, teams.id AS participant_id ".
						 " FROM `{$GLOBALS['g_egltb_ladder_participants']}` AS ladder_parts ".
						 " LEFT JOIN `{$GLOBALS['g_egltb_teams']}` AS teams ".
						 " ON teams.id=ladder_parts.participant_id ".
						 " LEFT JOIN `{$GLOBALS['g_egltb_clan_accounts']}` AS clans ".
						 " ON teams.clan_id=clans.id ".
						 " WHERE ladder_parts.id={$partid} ";
			return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
		}
	}//function

	
	
	
	/**
	 * Game ladderparticipants next ecounts(matches), by game_id
	 *
	 * @param	int		participant-type
	 * @return	int		participant
	 **/
	function GetLadderParticipant( $ladder_id, $participant_id )
	{
		$sql_query = " SELECT ladder_parts.* ".
					 " FROM `".$GLOBALS['g_egltb_ladder_participants']."` AS ladder_parts ".
					 " WHERE ladder_parts.participant_id=".(int)$participant_id." && ladder_parts.ladder_id=".(int)$ladder_id."";
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}

		
	/**
	 * create new challenge
	 *
	 * @param	object/array	row(fields) data
	 * @return	int				true(1)/false(0)
	 **/
	function CreateChallenge( $obj )
	{
		if( $this->pDBInterfaceCon->Query ( $this->pDBInterfaceCon->CreateInsertQuery( $GLOBALS['g_egltb_ladder_challenges'], $obj ) ) )
			return $this->pDBInterfaceCon->InsertId();
		return NULL;
	}	
	
	
	/**
	 * create new encount
	 *
	 * @param	object/array	row(fields) data
	 * @return	int				true(1)/false(0)
	 **/
	function CreateEncount( $obj )
	{
		if( $this->pDBInterfaceCon->Query ( $this->pDBInterfaceCon->CreateInsertQuery( $GLOBALS['g_egltb_ladder_encounts'], $obj ) ) )
			return $this->pDBInterfaceCon->InsertId();
		return NULL;
	}
	
	
	
	/**
	* fetch list of incoming challenges
	*
	* @param 	integer		participant type
	* @param	integer		participant id
	* @param	integer		ladder-id
	* @return 	array		challenge objects
	**/
	function GetIncomingChallenges( $participant_type, $participant_id, $ladder_id=-1 )
	{
		if( $participant_type == PARTTYPE_MEMBER )
		{
			$sql_query = 	" SELECT ladder_c.*, ladders.*, ".
							" 		 ladder_c.id AS id, ".
							" 		 ladders.name AS ladder_name, ".
							" 		 challenger.nick_name AS challenger_name, challenger.id AS challenger_id, ".
							" 		 opponent.nick_name AS opponent_name, opponent.id AS opponent_id, ".
							" 		 games.name AS game_name, games.logo_small_file AS game_logo_small_file, games.id AS game_id ".

							//"		 COUNT(l_c_comments.id) AS num_comments ".
							
							" FROM `{$GLOBALS['g_egltb_ladder_challenges']}` AS ladder_c ".
							
							 //" LEFT JOIN `{$GLOBALS['g_egltb_ladder_challenge_comments']}` AS l_c_comments ".
							 //" ON l_c_comments.challenge_id=ladder_c.id ".
							
							" LEFT JOIN `{$GLOBALS['g_egltb_ladders']}` AS ladders ".
							" ON ladder_c.ladder_id=ladders.id ".
							" LEFT JOIN `{$GLOBALS['g_egltb_members']}` AS challenger ".
							" ON challenger.id=ladder_c.challenger_id ".
							" LEFT JOIN `{$GLOBALS['g_egltb_members']}` AS opponent ".
							" ON opponent.id=ladder_c.opponent_id ".
							" LEFT JOIN `{$GLOBALS['g_egltb_game_pool']}` AS games ".
							" ON games.id=ladders.game_id ".
							" WHERE ladder_c.opponent_id=$participant_id  && ladders.participant_type=$participant_type ".
							
							//" GROUP BY l_c_comments.challenge_id ". 
							" ORDER BY ladder_c.created DESC ";
							
			return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
		}
		
		elseif( $participant_type == PARTTYPE_TEAM )
		{
			$sql_query = 	" SELECT ladder_c.*, ladders.*, ".
							" 		 ladder_c.id AS id, ".
							" 		 ladders.name AS ladder_name, ".
							
							" 		 challenger.name AS challenger_name, challenger.id AS challenger_id, ".
							"		 challenger_cl.name AS challenger_clan_name, challenger_cl.id AS challenger_clan_id, challenger_cl.tag AS challenger_clan_tag, ".
							
							
							" 		 opponent.name AS opponent_name, opponent.id AS opponent_id, ".
							"		 opponent_cl.name AS opponent_clan_name, opponent_cl.id AS opponent_clan_id, opponent_cl.tag AS opponent_clan_tag, ".
							
							" 		 games.name AS game_name, games.logo_small_file AS game_logo_small_file, games.id AS game_id ".

							//"		 COUNT(l_c_comments.id) AS num_comments ".
							
							" FROM `{$GLOBALS['g_egltb_ladder_challenges']}` AS ladder_c ".
							
							//" LEFT JOIN `{$GLOBALS['g_egltb_ladder_challenge_comments']}` AS l_c_comments ".
							//" ON l_c_comments.challenge_id=ladder_c.id ".
							
							" LEFT JOIN `{$GLOBALS['g_egltb_ladders']}` AS ladders ".
							" ON ladder_c.ladder_id=ladders.id ".
							
							" LEFT JOIN `{$GLOBALS['g_egltb_teams']}` AS challenger ".
							" ON challenger.id=ladder_c.challenger_id ".
							" LEFT JOIN `{$GLOBALS['g_egltb_clan_accounts']}` AS challenger_cl ".
							" ON challenger_cl.id=challenger.clan_id ".
							
							" LEFT JOIN `{$GLOBALS['g_egltb_teams']}` AS opponent ".
							" ON opponent.id=ladder_c.opponent_id ".
							" LEFT JOIN `{$GLOBALS['g_egltb_clan_accounts']}` AS opponent_cl ".
							" ON opponent_cl.id=opponent.clan_id ".
							
							
							" LEFT JOIN `{$GLOBALS['g_egltb_game_pool']}` AS games ".
							" ON games.id=ladders.game_id ".
							
							" WHERE ladder_c.opponent_id=$participant_id && ladders.participant_type=$participant_type ".
							
							//" GROUP BY l_c_comments.challenge_id ". 
							" ORDER BY ladder_c.created DESC ";
							
			return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
			
		}//if
		
	}
	
	
	
	/**
	* fetch list of outcoming challenges
	*
	* @param 	integer		participant type
	* @param	integer		participant id
	* @param	integer		ladder-id
	* @return 	array		challenge objects
	**/
	function GetOutcomingChallenges( $participant_type, $participant_id, $ladder_id=-1 )
	{
		if( $participant_type == PARTTYPE_MEMBER )
		{
			$sql_challenge_comments 	= "";
			
			
			$sql_query = 	" SELECT ladder_c.*, ladders.*, ".
							" 		 ladder_c.id AS id, ".
							" 		 ladders.name AS ladder_name, ".
							" 		 challenger.nick_name AS challenger_name, challenger.id AS challenger_id, ".
							" 		 opponent.nick_name AS opponent_name, opponent.id AS opponent_id, ".
							" 		 games.name AS game_name, games.logo_small_file AS game_logo_small_file, games.id AS game_id ".

							//"		 COUNT(l_c_comments.id) AS num_comments ".
							
							" FROM `{$GLOBALS['g_egltb_ladder_challenges']}` AS ladder_c ".
							
							//" LEFT JOIN `{$GLOBALS['g_egltb_ladder_challenge_comments']}` AS l_c_comments ".
							//" ON l_c_comments.challenge_id=ladder_c.id ".
							
							" LEFT JOIN `{$GLOBALS['g_egltb_ladders']}` AS ladders ".
							" ON ladder_c.ladder_id=ladders.id ".
							" LEFT JOIN `{$GLOBALS['g_egltb_members']}` AS challenger ".
							" ON challenger.id=ladder_c.challenger_id ".
							" LEFT JOIN `{$GLOBALS['g_egltb_members']}` AS opponent ".
							" ON opponent.id=ladder_c.opponent_id ".
							" LEFT JOIN `{$GLOBALS['g_egltb_game_pool']}` AS games ".
							" ON games.id=ladders.game_id ".
							" WHERE ladder_c.challenger_id=$participant_id && ladders.participant_type=$participant_type ".
							
							//" GROUP BY l_c_comments.challenge_id ". 
							" ORDER BY ladder_c.created DESC ";
							
			# echo $this->pDBInterfaceCon->CreateHTMLOutput( $this->pDBInterfaceCon->Query( $sql_query ) );
			return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
		}
		
		elseif( $participant_type == PARTTYPE_TEAM )
		{
			$sql_query = 	" SELECT ladder_c.*, ladders.*, ".
							" 		 ladder_c.id AS id, ".
							" 		 ladders.name AS ladder_name, ".
							
							" 		 challenger.name AS challenger_name, challenger.id AS challenger_id, ".
							"		 challenger_cl.name AS challenger_clan_name, challenger_cl.id AS challenger_clan_id, challenger_cl.tag AS challenger_clan_tag, ".
							
							
							" 		 opponent.name AS opponent_name, opponent.id AS opponent_id, ".
							"		 opponent_cl.name AS opponent_clan_name, opponent_cl.id AS opponent_clan_id, opponent_cl.tag AS opponent_clan_tag, ".
							
							" 		 games.name AS game_name, games.logo_small_file AS game_logo_small_file, games.id AS game_id ".

							//"		 COUNT(l_c_comments.id) AS num_comments ".
							
							" FROM `{$GLOBALS['g_egltb_ladder_challenges']}` AS ladder_c ".
							
							//" LEFT JOIN `{$GLOBALS['g_egltb_ladder_challenge_comments']}` AS l_c_comments ".
							//" ON l_c_comments.challenge_id=ladder_c.id ".
							
							" LEFT JOIN `{$GLOBALS['g_egltb_ladders']}` AS ladders ".
							" ON ladder_c.ladder_id=ladders.id ".
							
							" LEFT JOIN `{$GLOBALS['g_egltb_teams']}` AS challenger ".
							" ON challenger.id=ladder_c.challenger_id ".
							" LEFT JOIN `{$GLOBALS['g_egltb_clan_accounts']}` AS challenger_cl ".
							" ON challenger_cl.id=challenger.clan_id ".
							
							" LEFT JOIN `{$GLOBALS['g_egltb_teams']}` AS opponent ".
							" ON opponent.id=ladder_c.opponent_id ".
							" LEFT JOIN `{$GLOBALS['g_egltb_clan_accounts']}` AS opponent_cl ".
							" ON opponent_cl.id=opponent.clan_id ".
							
							
							" LEFT JOIN `{$GLOBALS['g_egltb_game_pool']}` AS games ".
							" ON games.id=ladders.game_id ".
							
							
							" WHERE ladder_c.challenger_id=$participant_id  && ladders.participant_type=$participant_type ".
							
							//" GROUP BY l_c_comments.challenge_id ". 
							" ORDER BY ladder_c.created DESC ";
							
			return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
		}//if
		
	}	
	
	
	/**
	* get challenge details
	*
	* @param 	integer		participant type
	* @param	integer		participant id
	* @param	integer		ladder-id
	* @return 	array		challenge objects
	**/
	function GetChallengeDetails( $participant_type, $challenge_id )
	{
		if( $participant_type == PARTTYPE_MEMBER )
		{
			$sql_query = 	" SELECT ladder_c.*, ladders.*, ".
							" 		 ladder_c.id AS id, ".
							" 		 ladders.name AS ladder_name, ladders.id AS ladder_id, ".
							" 		 challenger.nick_name AS challenger_name, challenger.id AS challenger_id, ".
							" 		 opponent.nick_name AS opponent_name, opponent.id AS opponent_id, ".
							" 		 games.name AS game_name, games.logo_small_file AS game_logo_small_file, games.id AS game_id ".
							" FROM `{$GLOBALS['g_egltb_ladder_challenges']}` AS ladder_c ".
							" LEFT JOIN `{$GLOBALS['g_egltb_ladders']}` AS ladders ".
							" ON ladder_c.ladder_id=ladders.id ".
							" LEFT JOIN `{$GLOBALS['g_egltb_members']}` AS challenger ".
							" ON challenger.id=ladder_c.challenger_id ".
							" LEFT JOIN `{$GLOBALS['g_egltb_members']}` AS opponent ".
							" ON opponent.id=ladder_c.opponent_id ".
							" LEFT JOIN `{$GLOBALS['g_egltb_game_pool']}` AS games ".
							" ON games.id=ladders.game_id ".
							" WHERE ladder_c.id=$challenge_id ";
			# echo $this->pDBInterfaceCon->CreateHTMLOutput( $this->pDBInterfaceCon->Query( $sql_query ) );
			return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
		}
		
		elseif( $participant_type == PARTTYPE_TEAM )
		{
			$sql_query = 	" SELECT ladder_c.*, ladders.*, ".
							" 		 ladder_c.id AS id, ".
							" 		 ladders.name AS ladder_name, ladders.id AS ladder_id, ".
							
							//" 		 challenger.nick_name AS challenger_name, challenger.id AS challenger_id, ".
							//" 		 opponent.nick_name AS opponent_name, opponent.id AS opponent_id, ".
							
							" 		 challenger.name AS challenger_name, challenger.id AS challenger_id, ".
							"		 challenger_cl.name AS challenger_clan_name, challenger_cl.id AS challenger_clan_id, challenger_cl.tag AS challenger_clan_tag, ".
							
							
							" 		 opponent.name AS opponent_name, opponent.id AS opponent_id, ".
							"		 opponent_cl.name AS opponent_clan_name, opponent_cl.id AS opponent_clan_id, opponent_cl.tag AS opponent_clan_tag, ".

							
							" 		 games.name AS game_name, games.logo_small_file AS game_logo_small_file, games.id AS game_id ".
							" FROM `{$GLOBALS['g_egltb_ladder_challenges']}` AS ladder_c ".
							" LEFT JOIN `{$GLOBALS['g_egltb_ladders']}` AS ladders ".
							" ON ladder_c.ladder_id=ladders.id ".
							
							//" LEFT JOIN `{$GLOBALS['g_egltb_members']}` AS challenger ".
							//" ON challenger.id=ladder_c.challenger_id ".
							//" LEFT JOIN `{$GLOBALS['g_egltb_members']}` AS opponent ".
							//" ON opponent.id=ladder_c.opponent_id ".
							
							" LEFT JOIN `{$GLOBALS['g_egltb_teams']}` AS challenger ".
							" ON challenger.id=ladder_c.challenger_id ".
							
							" LEFT JOIN `{$GLOBALS['g_egltb_clan_accounts']}` AS challenger_cl ".
							" ON challenger_cl.id=challenger.clan_id ".
							
							" LEFT JOIN `{$GLOBALS['g_egltb_teams']}` AS opponent ".
							" ON opponent.id=ladder_c.opponent_id ".
							" LEFT JOIN `{$GLOBALS['g_egltb_clan_accounts']}` AS opponent_cl ".
							" ON opponent_cl.id=opponent.clan_id ".
														
							
							" LEFT JOIN `{$GLOBALS['g_egltb_game_pool']}` AS games ".
							" ON games.id=ladders.game_id ".
							" WHERE ladder_c.id=$challenge_id ";
			# echo $this->pDBInterfaceCon->CreateHTMLOutput( $this->pDBInterfaceCon->Query( $sql_query ) );
			return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
			
		}//if
		
	}

	/**
	* update challenge <DB> object
	*
	* @param 	integer		challenge-id
	* @param	array		new field configuration
	* @return 	boolean		true/false
	**/
	function UpdateChallenge( $challenge_id, $object )
	{
		return $this->pDBInterfaceCon->Query( $this->pDBInterfaceCon->CreateUpdateQuery( $GLOBALS['g_egltb_ladder_challenges'], $object ) . " WHERE id=".(int)$challenge_id .""  );
	}
	
	function SetChallengeData( $challenge_id, $object ){
		return $this->UpdateChallenge($challenge_id, $object );
	}
	

	/**
	* update challenge <DB> object
	*
	* @param 	integer		challenge-id
	* @param	array		new field configuration
	* @return 	boolean		true/false
	**/
	function UpdateLadder( $ladder_id, $object )
	{
		return $this->pDBInterfaceCon->Query( $this->pDBInterfaceCon->CreateUpdateQuery( $GLOBALS['g_egltb_ladders'], $object ) . " WHERE id=".(int)$ladder_id." "  );
	}
	
		
	/**
	* get ladder entries, entered ladders
	*
	* @param 	integer		participant-id
	* @param	integer		participant-type	(PARTTYPE_MEMBER | PARTTYPE_TEAM)
	* @return 	boolean		true/false
	**/
	function GetLadderEntries( $part_id, $part_type )
	{
		$sql_query = 	" SELECT ladders.name, ladders.id  ".
						" FROM ".$GLOBALS["g_egltb_ladders"]." AS ladders, ".$GLOBALS["g_egltb_ladder_participants"]." AS ladder_parts ".
						" WHERE (ladders.id=ladder_parts.ladder_id) && (ladder_parts.participant_id = $part_id) ".
						" AND ( ladders.participant_type = $part_type ) ".
						" ORDER BY ladders.created ASC ";
		return $this->pDBInterfaceCon->FetchArrayObject($this->pDBInterfaceCon->Query( $sql_query ));
	}

	
	
	/**
	* get matchlist according to ladder-id
	*
	* @param 	integer		participant-id
	* @param	integer		participant-type	(PARTTYPE_MEMBER | PARTTYPE_TEAM)
	* @param	integer		ladder-id
	* @param	ínteger		limit(=10)
	* @return 	array		matchlist
	**/
	function GetLadderMatchesByParticipant( $participant_id, $participant_type, $ladder_id, $limit=0, $status='all' )
	{
		$LIMIT_STR="";
		if( $limit > 0 ) $LIMIT_STR = " LIMIT 0,".(int)$limit;
		$match_status = "";
		
		if( $status == 'all' )				$match_status = "";
		else if( $status == 'closed' ) 		$match_status = " && matches.status=".MATCH_CLOSED." ";
		else if( $status == 'locked' ) 		$match_status = " && (matches.status=".MATCH_LOCKED." || matches.status=".MATCH_REPORTED." )  ";
		else if( $status == 'reported' ) 	$match_status = " && matches.status=".MATCH_REPORTED." ";
		else if( $status == 'running' )		$match_status = " && matches.status=".MATCH_RUNNING." ";
		
		if( $participant_type  == PARTTYPE_MEMBER )
		{
			$sql_query = 	" SELECT matches.*, ".
							" 		 challenger.nick_name AS challenger_name, challenger.id AS challenger_id, ".
							" 		 opponent.nick_name AS opponent_name, opponent.id AS opponent_id ".
							" FROM `{$GLOBALS['g_egltb_matches']}` AS matches ".
							" LEFT JOIN `{$GLOBALS['g_egltb_members']}` AS challenger ".
							" ON challenger.id=matches.challenger_id ".
							" LEFT JOIN `{$GLOBALS['g_egltb_members']}` AS opponent ".
							" ON opponent.id=matches.opponent_id ".
							" WHERE matches.module_id='".MODULEID_INETOPIA_LADDER."' && matches.module_entry_id={$ladder_id} && ".
							" 		(matches.challenger_id=$participant_id || matches.opponent_id=$participant_id) && ".
							"		matches.participant_type=$participant_type ".
									$match_status.
							" ORDER BY matches.challenge_time DESC ".
							$LIMIT_STR;
			return $this->pDBInterfaceCon->FetchArrayObject($this->pDBInterfaceCon->Query( $sql_query ));
		}
		else if( $participant_type  == PARTTYPE_TEAM )
		{

			/*
			challenger_logo_file
			challenger_country_id
			challenger_country_name
			challenger_country_image_file*/
								
			$sql_query = 	" SELECT matches.*, ".
							" 		 challenger.name AS challenger_name, challenger.id AS challenger_id, ".
							"		 c_clan.name AS challenger_clan_name, c_clan.tag AS challenger_clan_tag, c_clan.id AS challenger_clan_id, ".
							" 		 opponent.name AS opponent_name, opponent.id AS opponent_id, ".
							"		 o_clan.name AS opponent_clan_name, o_clan.tag AS opponent_clan_tag, o_clan.id AS opponent_clan_id ".
							" FROM `{$GLOBALS['g_egltb_matches']}` AS matches ".
								" LEFT JOIN `{$GLOBALS['g_egltb_teams']}` AS challenger ".
									" ON challenger.id=matches.challenger_id ".
								" LEFT JOIN `{$GLOBALS['g_egltb_clan_accounts']}` AS c_clan".
									" ON c_clan.id=challenger.clan_id ".
								" LEFT JOIN `{$GLOBALS['g_egltb_teams']}` AS opponent ".
									" ON opponent.id=matches.opponent_id ".
								" LEFT JOIN `{$GLOBALS['g_egltb_clan_accounts']}` AS o_clan ".
									" ON o_clan.id=opponent.clan_id ".
							" WHERE matches.module_id='".MODULEID_INETOPIA_LADDER."' && matches.module_entry_id={$ladder_id} && ".
							" 		(matches.challenger_id=$participant_id || matches.opponent_id=$participant_id) && ".
							"		matches.participant_type=$participant_type ".
									$match_status.
							" ORDER BY matches.challenge_time DESC ".
							$LIMIT_STR;
			return $this->pDBInterfaceCon->FetchArrayObject($this->pDBInterfaceCon->Query( $sql_query ));			
		}//if
	}
	

	
	/**
	 * fetch ladder encount from DB
	 *
	 * @param 	integer $match_id
	 * @return	object	encount
	 */
	function GetEncountByMatchId( $match_id )
	{
		$sql_query = 	" SELECT *".
						" FROM `".$GLOBALS['g_egltb_ladder_encounts']."` AS l_encounts ".
						" LEFT JOIN `".$GLOBALS['g_egltb_matches']."` AS l_matches".
						" ON l_encounts.match_id=l_matches.id ".
						" WHERE match_id=".(int)$match_id."";
						
		return $this->pDBInterfaceCon->FetchObject($this->pDBInterfaceCon->Query( $sql_query ));			
	}
		
	
	/**
	 * fetch ladder encount from DB
	 *
	 * @param 	integer $match_id
	 * @return	object	encount
	 */
	function GetEncountById( $match_id )
	{
		$sql_query = 	" SELECT * ".
						" FROM `".$GLOBALS['g_egltb_ladder_encounts']."` AS l_encounts ".
						" WHERE id=".(int)$match_id." ";
						
		return $this->pDBInterfaceCon->FetchObject($this->pDBInterfaceCon->Query( $sql_query ));			
	}
	
	

	/**
	* get ladder administrator
	*
	* @param	integer	ladder-id
	* @return 	array	admin-list
	*/
	function GetLadderAdministrator( $ladder_id )
	{
		$sql_query =" SELECT permissions.id, permissions.permissions, permissions.cat_id, permissions.admin_id, permissions.data, permissions.created,
					  		 members.id AS member_id, members.nick_name, members.email ".
					" FROM `".$GLOBALS['g_egltb_admin_permissions']."` AS permissions ".
					" LEFT JOIN `".$GLOBALS['g_egltb_admins']."` AS admins ".
					" ON admins.id=permissions.admin_id ".
					" LEFT JOIN `".$GLOBALS['g_egltb_members']."` AS members ".
					" ON admins.member_id=members.id".
					" WHERE permissions.data='".(int)$ladder_id."' && permissions.module_id='".MODULEID_INETOPIA_LADDER."' ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );		
	}
	
	/**
	* InetopiaLadder::CreateCupParticipant() - get ladder administrator
	*
	* @param	array	field-list
	* @return 	integer	DB::InsertId()
	*/
	function CreateLadderParticipant( $object )
	{
		$sql_query = $this->pDBInterfaceCon->CreateInsertQuery( $GLOBALS["g_egltb_ladder_participants"], $object );
		$qre = $this->pDBInterfaceCon->Query( $sql_query );
		if( $qre ) return $this->pDBInterfaceCon->InsertId();
		return -1;		
	}
		
	
	
	/**
	* InetopiaLadder::IsEnteredLadder() - get ladder administrator
	*
	* @param	integer	ladder-id
	* @param	integer	participant-id
	* @return 	integer	num joins (always 1, if more than 1 joined items!)
	*/
	function IsEnteredLadder( $ladder_id, $participant_id )
	{
		$sql_query = 	" SELECT COUNT(*) AS num_parts ".
						" FROM `".$GLOBALS["g_egltb_ladder_participants"]."` AS parts ".
						" WHERE participant_id=".(int)$participant_id." && ladder_id=".(int)$ladder_id." ".
						" GROUP BY participant_id ";
						
		$data = $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
		return $data->num_parts;
	}
	
	
	/**
	* InetopiaLadder::IsLadderLocked()
	*
	* @param	integer	ladder-id
	* @return 	integer 0/1
	*/
	function IsLadderChallengeLocked( $ladderpart_id )
	{
		$sql_query = 	" SELECT ladders.challenge_locked ".
						" FROM `".$GLOBALS["g_egltb_ladders"]."` AS ladders,`".$GLOBALS["g_egltb_ladder_participants"]."` AS parts ".
						" WHERE ladders.id=parts.ladder_id && parts.id=".(int)$ladderpart_id."  ";
						
		$data = $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
		return $data->challenge_locked;
	}
	
	
	
	/**
	* InetopiaLadder::GetNumLadderParticipants()
	*
	* @param integer ladder-id
	* @return integer num ladder participants, joined
	*/
	function GetNumLadderParticipants( $ladder_id )
	{
		$sql_query = 	" SELECT COUNT(*) AS num_parts ".
						" FROM `".$GLOBALS["g_egltb_ladder_participants"]."` AS cupparts ".
						" WHERE ladder_id=".(int)$ladder_id." ".
						" GROUP BY ladder_id ";
						
		$data = $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
		return $data->num_parts;
	}	
	
	
	/**
	* InetopiaLadder::GetNumLadderMatches()
	*
	* @param integer ladder-id
	* @return integer num ladder encounts, created
	*/
	function GetNumLadderEncounts( $ladder_id )
	{
		$sql_query = 	" SELECT COUNT(*) AS num_encounts ".
						" FROM `".$GLOBALS["g_egltb_ladder_encounts"]."` AS enc ".
						" WHERE ladder_id=".(int)$ladder_id." ".
						" GROUP BY ladder_id ";
						
		$data = $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
		return $data->num_encounts;
	}
	
	
	/**
	* InetopiaLadder::DeleteParticipant()
	*
	* @param 	integer 	part-id given by ladder => NOT MEMBER-ID OR TEAM-ID
	* @return 	bool		true/false
	*/
	function DeleteParticipant( $id )
	{
		$sql_query = "DELETE FROM `".$GLOBALS["g_egltb_ladder_participants"]."` WHERE id=".(int)$id."";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
	
	
	/**
	* InetopiaLadder::DeleteParticipant()
	*
	* @param 	integer 	part-id given by ladder => NOT MEMBER-ID OR TEAM-ID
	* @return 	bool		true/false
	*/
	function DeleteParticipantByLadderId( $participant_id, $ladder_id )
	{
		$sql_query = "DELETE FROM `".$GLOBALS["g_egltb_ladder_participants"]."` WHERE ladder_id=".(int)$ladder_id." && participant_id=".(int)$participant_id."";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}	
		
	
	/**
	* InetopiaLadder::DeleteEncount()
	*
	* @param 	integer 	encount-id
	* @return 	bool		true/false
	*/
	function DeleteEncount( $encount_id )
	{
		$sql_query = "DELETE FROM `".$GLOBALS["g_egltb_ladder_encounts"]."` WHERE id=".(int)$encount_id."";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
	
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $ladder_id
	 */
	function DeleteLadder( $ladder_id)
	{
		$sql_query = "DELETE FROM `".$GLOBALS["g_egltb_ladders"]."` WHERE id=".(int)$ladder_id."";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $ladder_id
	 */
	function DeleteLadderParticipants( $ladder_id )
	{
		$sql_query = "DELETE FROM `".$GLOBALS["g_egltb_ladder_participants"]."` WHERE ladder_id=".(int)$ladder_id."";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
	
	/**
	 * only delete encounts
	 *
	 * @param unknown_type $ladder_id
	 */
	function DeleteLadderEncounts( $ladder_id)
	{
		$sql_query = "DELETE FROM `".$GLOBALS["g_egltb_ladder_encounts"]."` WHERE ladder_id=".$ladder_id."";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $ladder_id
	 */
	function DeleteLadderMatchesByModuleData( $ladder_id)
	{
		$sql_query = "DELETE FROM `".$GLOBALS["g_egltb_matches"]."` WHERE module_entry_id=".(int)$ladder_id." && module_id='".MODULEID_INETOPIA_LADDER."'";
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
					 " FROM `".$GLOBALS['g_egltb_matches']."` AS matches ".
					 " LEFT JOIN `".$GLOBALS['g_egltb_ladder_encounts']."` AS encounts ".
					 " ON matches.id=encounts.match_id ".
					 " WHERE encounts.cup_id=".(int)$cup_id." ";
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
					 " FROM `".$GLOBALS['g_egltb_matches']."` AS matches ".
					 " LEFT JOIN `".$GLOBALS['g_egltb_ladder_encounts']."` AS encounts ".
					 " ON matches.id=encounts.match_id ".
					 " WHERE encounts.cup_id=".(int)$cup_id." ";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
	
	
	
	/**
	 * try fetching joined GetJoinedTeamLadderByTeam
	 *
	 * @param unknown_type $team_id
	 */
	function GetJoinedTeamLadderByTeamId( $team_id )
	{
		$sql_query 	= 	" SELECT ladder_parts.*, ladder_parts.participant_id AS team_id, ladder_parts.id AS part_id, ladders.*, game_pool.name AS game_name, game_pool.id AS game_id, game_pool.token AS game_token ".
						" FROM `{$GLOBALS['g_egltb_ladder_participants']}` AS ladder_parts ".
						" LEFT JOIN `{$GLOBALS['g_egltb_ladders']}` AS ladders ".
						" ON ladder_parts.ladder_id=ladders.id ".
						//" LEFT JOIN `{$GLOBALS['g_egltb_teams']}` AS teams ".
						//" ON teams.id=ladder_parts.participant_id ".
						" LEFT JOIN `{$GLOBALS['g_egltb_game_pool']}` AS game_pool ".
						" ON game_pool.id=ladders.game_id ".
						" WHERE ladder_parts.participant_id=".(int)$team_id." && ladders.participant_type=".PARTTYPE_TEAM." ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}
	
	/**
	 * try fetching joined laderlist
	 *
	 * @param unknown_type $member_id
	 */
	function GetJoined1on1LadderByMemberId( $member_id )
	{
		/*
		$sql_matches_won =		" SELECT parts.id, matches.id AS match_id, parts.participant_id, COUNT(parts.participant_id) AS num_matches ".
								" FROM 	egl_ladder_participants AS parts ".
								" LEFT JOIN egl_matches As matches ".
								" ON  ( parts.participant_id = matches.opponent_id || parts.participant_id=matches.challenger_id ) " .
								" WHERE  matches.winner_id=parts.participant_id  && matches.status=".MATCH_CLOSED." && ".
								" 		 matches.module_id='".MODULEID_INETOPIA_LADDER."' ".
								" GROUP BY participant_id" ;
		
		$sql_matches_lost =		" SELECT parts.id, matches.id AS match_id, parts.participant_id, COUNT(parts.participant_id) AS num_matches ".
								" FROM 	egl_ladder_participants AS parts ".
								" LEFT JOIN egl_matches As matches ".
								" ON  ( parts.participant_id = matches.opponent_id || parts.participant_id=matches.challenger_id " .
								" WHERE   matches.winner_id!=parts.participant_id && matches.winner_id!=".EGL_NO_ID." && matches.status=".MATCH_CLOSED." && ".
								" 		 matches.module_id='".MODULEID_INETOPIA_LADDER."' ".
								" GROUP BY participant_id" ;
								
		$sql_matches_draw =		" SELECT parts.id, matches.id AS match_id, parts.participant_id, COUNT(parts.participant_id) AS num_matches ".
								" FROM 	egl_ladder_participants AS parts ".
								" LEFT JOIN egl_matches As matches ".
								" ON  ( parts.participant_id = matches.opponent_id || parts.participant_id=matches.challenger_id ) " .
								" WHERE  matches.winner_id=".EGL_NO_ID." && matches.status=".MATCH_CLOSED." && ".
								" 		 matches.module_id='".MODULEID_INETOPIA_LADDER."'".
								" GROUP BY participant_id" ;
		$sql_matches_all =		" SELECT parts.id, matches.id AS match_id, parts.participant_id, COUNT(parts.participant_id) AS num_matches ".
								" FROM 	egl_ladder_participants AS parts ".
								" LEFT JOIN egl_matches As matches ".
								" ON  ( parts.participant_id = matches.opponent_id || parts.participant_id=matches.challenger_id ) && parts.ladder_id={$ladder_id} " .
								" WHERE  ".
								" 		 matches.module_id='".MODULEID_INETOPIA_LADDER."'  && matches.module_entry_id={$ladder_id} ".
								" GROUP BY participant_id" ;
		*/									
									
		$sql_query 	= 	" SELECT ladder_parts.*, ladder_parts.id AS part_id, ladders.*, game_pool.name AS game_name, game_pool.id AS game_id, game_pool.token AS game_token ".
						" FROM `{$GLOBALS['g_egltb_ladder_participants']}` AS ladder_parts ".
						" LEFT JOIN `{$GLOBALS['g_egltb_ladders']}` AS ladders ".
							" ON ladder_parts.ladder_id=ladders.id ".
						" LEFT JOIN `{$GLOBALS['g_egltb_game_pool']}` AS game_pool ".
							" ON game_pool.id=ladders.game_id ".
						" WHERE ladder_parts.participant_id=$member_id && ladders.participant_type=".PARTTYPE_MEMBER." ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}

	
	/**
	 * InetopiaLadder::GetJoinTeamLadder()
	 *
	 * @param unknown_type $member_id
	 * @return unknown
	 */
	function GetJoinedTeamLadderByMemberId( $member_id )
	{
		$sql_query = 	" SELECT ladder_parts.*, ladder_parts.id AS part_id, ladders.*, game_pool.name AS game_name, game_pool.id AS game_id, game_pool.token AS game_token, teams.name AS team_name, teams.id AS team_id, teams.tag AS team_tag ".
						" FROM `{$GLOBALS['g_egltb_team_joins']}` AS team_joins, `{$GLOBALS['g_egltb_teams']}` AS teams ".
						" LEFT JOIN `{$GLOBALS['g_egltb_ladder_participants']}` AS ladder_parts ".
						" ON ladder_parts.participant_id=teams.id ".
						" LEFT JOIN `{$GLOBALS['g_egltb_ladders']}` AS ladders ".
						" ON ladder_parts.ladder_id=ladders.id ".
						" LEFT JOIN `{$GLOBALS['g_egltb_game_pool']}` AS game_pool ".
						" ON game_pool.id=ladders.game_id ".
						" WHERE teams.id=team_joins.team_id && team_joins.member_id={$member_id} && ladders.participant_type=".PARTTYPE_TEAM." ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}
	
	/**
	 * CheckChallengeAccess
	 */
	function CheckChallengeAccess( $participant_type, $participant_id, $challenge_id, $state=0 )
	{
		$challenge_str_check = "";
		if( $state > 0 ){
			$challenge_str_check = " && challenges.state=".(int)$state." ";
		}
		$sql_query  =	" SELECT * ".
						" FROM `".DBTB::GetTB('LADDER', 'LADDER_CHALLENGES')."` AS challenges ".
						" LEFT JOIN `".DBTB::GetTB('LADDER', 'LADDERS')."` AS ladders ".
						" ON ladders.id=challenges.ladder_id ".
						" WHERE challenges.id=".(int)$challenge_id." && ladders.participant_type=".(int)$participant_type." && (challenges.challenger_id=".(int)$participant_id." || challenges.opponent_id=".(int)$participant_id.") ".$challenge_str_check." ";
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}
	
	
	
	/**
	 * GetChallengesByParticipant
	 * 
	 */
	function GetChallengesByParticipant( $participant_type, $participant_id, $state, $ladder_id=EGL_NO_ID ){
		$str_ladder = "";
		if( $ladder_id != EGL_NO_ID ) $str_ladder = " && challenges.ladder_id=".$ladder_id." ";
		
		# search open challenges
		$sql_query = 	" SELECT ladder.* ".
						" FROM `{$GLOBALS['g_egltb_ladder_challenges']}` AS challenges ".
						" LEFT JOIN `{$GLOBALS['g_egltb_ladders']}` AS ladder ".
						" ON ladder.id=challenges.ladder_id ".
						" WHERE ladder.participant_type=".$participant_type." ".
						" 		&& (challenges.challenger_id=".$participant_id." || challenges.opponent_id=".$participant_id.") ".
						"		&& challenges.state=".$state." ".
						$str_ladder;
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}			
	
	/**
	 * GetMatchesByParticipant
	 * 
	 */
	function GetNotClosedMatchesByParticipant( $participant_type, $participant_id, $ladder_id=EGL_NO_ID ){
		
		$str_ladder = "";
		if( $ladder_id != EGL_NO_ID ) $str_ladder = " && ladder_encounts.ladder_id=".$ladder_id." ";
		
		# search open matches
		$sql_query = 	" SELECT ladder.*, ladder_encounts.match_id ".
						" FROM `{$GLOBALS['g_egltb_matches']}` AS matches, `{$GLOBALS['g_egltb_ladder_encounts']}` AS ladder_encounts ".
						" LEFT JOIN `{$GLOBALS['g_egltb_ladders']}` AS ladder ".
						" ON ladder.id=ladder_encounts.ladder_id ".
						" WHERE matches.participant_type=".$participant_type." && (matches.challenger_id=".$participant_id." || matches.opponent_id=".$participant_id.") ".
						" 		&& matches.id=ladder_encounts.match_id && matches.status!=".MATCH_CLOSED." ".
						$str_ladder;
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}
	
	
	/**
	 * ResetLadderParticipantPoints
	 * 
	 */
	function ResetLadderParticipantPoints( $ladder_id, $new_points )
	{
		$sql_query = 	" UPDATE ".
						" `".$GLOBALS['g_egltb_ladder_participants']."`" .
						" SET points='".(int)$new_points."', last_points='".(int)$new_points."' ".
						" WHERE ladder_id=".$ladder_id;
		return $this->pDBInterfaceCon->Query( $sql_query );
	}	
					
};

?>