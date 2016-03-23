<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -




# -[ class ] -
/**
 * GameManagement
 * @copyright 	Inetopia
 * @package 	EGL.CMS
 *
 */
class GamePool
{
	# -[ variables ]-
	var $pDBInterfaceCon	= NULL;
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	/**
	 * constructor
	 *
	 */
	function GamePool ( &$pDBCon )
	{
		$this->pDBInterfaceCon = &$pDBCon;
	}
	
	/**
	 * receive the saved games
	 *
	 * @return unknown
	 */
	function GetGames()
	{
		$sql_query = "SELECT * FROM {$GLOBALS['g_egltb_game_pool']} ORDER BY name ASC";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}
	
	
	/**
	 * receive the saved games...
	 *
	 * @param unknown_type $ids
	 * @return unknown
	 */
	function GetGameList($ids)
	{
		$sql_query = "SELECT * FROM {$GLOBALS['g_egltb_game_pool']} WHERE FIND_IN_SET(id,'{$ids}') ORDER BY name ASC";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}
		

	/**
	 * receive the saved games.
	 *
	 * @param unknown_type $game_id
	 * @return unknown
	 */
	function GetGameById( $game_id )
	{
		$sql_query = "SELECT * FROM {$GLOBALS['g_egltb_game_pool']} WHERE  id=".(int)$game_id;
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}
	

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $obj
	 * @return unknown
	 */
	function AddGame( $obj )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBInterfaceCon->CreateInsertQuery( $GLOBALS['g_egltb_game_pool'], $obj );
		return ($this->pDBInterfaceCon->Query( $sql_query ) );
	}
	
	

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $obj
	 * @param unknown_type $game_id
	 * @return unknown
	 */
	function SetGameData( $obj, $game_id )
	{
		$sql_query = 	$this->pDBInterfaceCon->CreateUpdateQuery( $GLOBALS['g_egltb_game_pool'], $obj ).
						" WHERE id=".(int)$game_id;
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
	
	
	/**
	 * DeleteGameById
	 *
	 * @param unknown_type $game_id
	 * @return unknown
	 */
	function DeleteGameById( $game_id )
	{
		$sql_query = "DELETE FROM {$GLOBALS['g_egltb_game_pool']} WHERE id=$game_id";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
	

	/**
	 *  Prï¿½ft ob jeder Spieler(auch in einem Team) gaming ids eingetragen haben
	 *
	 * @param integer $game_id
	 * @param integer $participant_type
	 * @param unknown_type $participant_id
	 * @return list of members/team-members, with valid gaming-ids
	 */
	function GetGamingIds( $game_id, $participant_type, $participant_id )
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
		if( $participant_type == PARTTYPE_MEMBER )
		{
			$filter_no_acc_members = 	" SELECT members.nick_name, members.id, game_accs.value ".
										" FROM 	`".$GLOBALS['g_egltb_members']."` AS members, ".
										"		`".$GLOBALS['g_egltb_gameaccounts']."` AS game_accs, ".
										"		`".$GLOBALS['g_egltb_gameaccount_types']."` AS gameacc_types, ".
										"		`".$GLOBALS['g_egltb_game_pool']."` AS games ".
										" WHERE game_accs.gameacctype_id=gameacc_types.id && gameacc_types.id=games.gameacctype_id && games.id=".(int)$game_id." && members.id=game_accs.member_id && member_id=".(int)$participant_id." ";

 			return $this->pDBInterfaceCon->FetchArrayObject($this->pDBInterfaceCon->Query( $filter_no_acc_members));
		}//if
	
	}//CheckGamingId
		
};
?>