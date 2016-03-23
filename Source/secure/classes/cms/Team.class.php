<?php
# ============================== Copyright (c) 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


# -[ defines ]-




# -[ class ] -
class Team
{
	var $pDBInterfaceCon 		= NULL;
	var $aAccounts				= array();
	var $iMemberId				= EGL_NO_ID;
	
	# -[ variables ]-
	
	# -[ functions ]-
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output :
	//-------------------------------------------------------------------------------
	function Team (&$pMysql)
	{
		$this->pDBInterfaceCon = &$pMysql;
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: set id
	//-------------------------------------------------------------------------------
	function SetId( $id )
	{
		return ($this->iMemberId = (int)$id);
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: set id
	//-------------------------------------------------------------------------------
	function FillBuffers()
	{
		if( !$this->iMemberId ) return 0;

		
		# define query
		$sql_query 		= 	" SELECT teams.*, team_joins.permissions, team_joins.member_id ".
							" FROM ".$GLOBALS['g_egltb_teams']." AS teams, ".$GLOBALS['g_egltb_team_joins']." AS team_joins ".
							" WHERE team_joins.member_id=".$this->iMemberId." AND teams.id=team_joins.team_id ";
							
		/*
		CHANGED: 25.10.06 : Um für einige Prozesse alle Teams zugänglich zu machen müssen alle Teams in die Liste geladen werden. (minimaler Zeitverlust)
							
		
		$sql_query 		= 	" SELECT teams.*, team_joins.permissions, team_joins.member_id ".
							" FROM ".$GLOBALS['g_egltb_teams']." AS teams, ".$GLOBALS['g_egltb_team_joins']." AS team_joins ".
							" WHERE team_joins.member_id=".$this->iMemberId." AND teams.id=team_joins.team_id AND teams.clan_id=".EGL_NO_ID."";
		*/		
							
		$this->aAccounts 	= array();
		#$this->aTeams 		= array(); NOT USED
		# fetch clan - accounts
		$this->aAccounts = $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query($sql_query) );						
		return sizeof($this->aAccounts);
	}
	
	function GetAccounts(){ return $this->aAccounts; }	
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//  Output:
	//-------------------------------------------------------------------------------	
	function GetAccount( $id )
	{
		for( $i=0; $i < sizeof($this->aAccounts); $i++ )
			if( $this->aAccounts[$i]->id == $id )
				return $this->aAccounts[$i];
		return NULL;
	}

	
	//-------------------------------------------------------------------------------
	// Purpose:
	//  Output:
	//-------------------------------------------------------------------------------
	function GetTeam_clandata( $team_id )
	{
		$sql_query 	= 	" SELECT teams.*, clan_acc.id AS clan_id, clan_acc.name AS clan_name, clan_acc.tag AS clan_tag, clan_acc.hp AS clan_hp ".
						" FROM `".$GLOBALS['g_egltb_teams']."` AS teams".
						" LEFT JOIN `".$GLOBALS['g_egltb_clan_accounts']."` AS clan_acc".
						" ON teams.clan_id=clan_acc.id ".
						" WHERE teams.id=".(int)$team_id. "" ;
		return $this->pDBInterfaceCon->FetchObject($this->pDBInterfaceCon->Query( $sql_query ));
	}
	

	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//  Output:
	//-------------------------------------------------------------------------------
	function GetTeam( $team_id )
	{
		$sql_query 	= 	" SELECT teams.* ".
						" FROM ".$GLOBALS['g_egltb_teams']." AS teams".
						" WHERE teams.id=".(int)$team_id." " ;
		return $this->pDBInterfaceCon->FetchObject($this->pDBInterfaceCon->Query( $sql_query ));
	}
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//  Output:
	//-------------------------------------------------------------------------------
	function GetTeamById( $team_id )
	{
		return $this->GetTeam( $team_id );
	}

	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//  Output:
	//-------------------------------------------------------------------------------
	function GetTeamByMember( $team_id, $member_id )
	{
		$sql_query 	= 	" SELECT teams.* ".
						" FROM `".$GLOBALS['g_egltb_teams']."` AS teams, `".$GLOBALS['g_egltb_team_joins']."` AS team_join".
						" WHERE teams.id=team_join.team_id AND teams.id=$team_id AND team_join.member_id=".(int)$member_id. "" ;
		return $this->pDBInterfaceCon->FetchObject($this->pDBInterfaceCon->Query( $sql_query ));
	}
	

	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetTeamMemberByID( $team_id, $member_id )
	{
		$sql_query = 	" SELECT * FROM `".$GLOBALS['g_egltb_team_joins']."` AS team_members, `".$GLOBALS['g_egltb_members']."` AS members ".
						" WHERE members.id=team_members.member_id && team_id=".(int)$team_id." AND member_id=".(int)$member_id."";
		return ($this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) ));
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetTeamMemberByPermissions( $team_id, $permissions )
	{
		$sql_query = 	" SELECT * FROM `".$GLOBALS['g_egltb_team_joins']."` AS team_joins ".
						" WHERE team_id=".(int)$team_id." AND permissions='".$this->pDBInterfaceCon->EscapeString($permissions)."'";
		return ($this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) ));
	}

			
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//  Output:
	//-------------------------------------------------------------------------------
	function RemoveTeamMemberByMemberId( $team_id, $member_id )
	{
		$sql_query 	= 	" DELETE FROM `".$GLOBALS['g_egltb_team_joins']."` ".
						" WHERE team_id=".(int)$team_id." && member_id=".(int)$member_id." ";
		return $this->pDBInterfaceCon->Query( $sql_query );
		
	}
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//  Output:
	//-------------------------------------------------------------------------------
	function RemoveTeamMemberByID( $member_join_id )
	{
		$sql_query 	= 	" DELETE FROM `".$GLOBALS['g_egltb_team_joins']."` ".
						" WHERE id=".(int)$member_join_id;
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
		
	
			
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//  Output:
	//-------------------------------------------------------------------------------
	function GetTeamByName( $name )
	{
		$sql_query =	" SELECT * ".
						" FROM `".$GLOBALS['g_egltb_teams']."` AS teams ".
						" WHERE teams.name='".$this->pDBInterfaceCon->EscapeString($name)."'".
						" LIMIT 0,1";
		return $this->pDBInterfaceCon->FetchObject($this->pDBInterfaceCon->Query( $sql_query ));
	}
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//  Output:
	//-------------------------------------------------------------------------------
	function GetTeamsByName( $name )
	{
		$sql_query =	" SELECT * ".
						" FROM `".$GLOBALS['g_egltb_teams']."` AS teams ".
						" WHERE teams.name='".$this->pDBInterfaceCon->EscapeString($name)."'";
		return $this->pDBInterfaceCon->FetchArrayObject($this->pDBInterfaceCon->Query( $sql_query ));
	}
		
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//  Output:
	//-------------------------------------------------------------------------------
	function GetTeamMembers( $team_id )
	{
		# fetch teams + team joins
		$team_query = 	" SELECT team_joins.*, members.country_id AS country_id, members.birthday AS birthday, members.nick_name AS nick_name, members.photo_file AS member_photo_file ".
						" FROM `".$GLOBALS['g_egltb_team_joins']."` AS team_joins, `".$GLOBALS['g_egltb_members']."` AS members ".
						" WHERE (team_joins.member_id=members.id) AND (team_joins.team_id=".(int)$team_id.")";
		return ($this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $team_query ) ));
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//  Output:
	//-------------------------------------------------------------------------------
	function GetTeamMembersSortedByGameAccounts( $team_id, $game_acc_id  )
	{
		# fetch teams + team joins
		$team_query = 	" SELECT team_joins.*, members.country_id AS country_id, members.birthday AS birthday, members.nick_name AS nick_name, members.photo_file AS member_photo_file, " .
						" game_acc.value AS gameacc_value, game_acc.created AS gameacc_created, game_acc.changed AS gameacc_changed ".
						" FROM `".$GLOBALS['g_egltb_team_joins']."` AS team_joins, `".$GLOBALS['g_egltb_members']."` AS members ".
 						" LEFT JOIN `".$GLOBALS['g_egltb_gameaccounts']."` AS game_acc ".
							" ON game_acc.member_id=members.id && game_acc.gameacctype_id=".(int)$game_acc_id." ".
						" WHERE (team_joins.member_id=members.id) AND (team_joins.team_id=".(int)$team_id.") ";
						//" ORDER BY ";
		return ($this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $team_query ) ));
	}
	
	
		
	//-------------------------------------------------------------------------------
	// Purpose: get clan with teams
	//-------------------------------------------------------------------------------
	function GetClanTeams( $clan_id )
	{
		$sql_query 		= 	" SELECT teams.* ".
							" FROM `".$GLOBALS['g_egltb_teams']."` AS teams ".
							" WHERE teams.clan_id=".(int)$clan_id." ".
							" ORDER BY teams.name ASC ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query($sql_query));
	}

	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------	
	function SetTeamData( $obj, $team_id )
	{
		$sql_query = 	$this->pDBInterfaceCon->CreateUpdateQuery(  $GLOBALS['g_egltb_teams'], $obj ) . 
						" WHERE id=".(int)$team_id;
						
		# execute query
		return $this->pDBInterfaceCon->Query( $sql_query );
	}

	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function SetTeamMemberData( $obj, $team_id, $member_id )
	{
		$sql_query = 	$this->pDBInterfaceCon->CreateUpdateQuery(  $GLOBALS['g_egltb_team_joins'], $obj ) . 
						" WHERE team_id=".(int)$team_id." && member_id=".(int)$member_id;
						
		# execute query
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function SetTeamMemberDataByJoinId( $obj, $join_id )
	{
		$sql_query = 	$this->pDBInterfaceCon->CreateUpdateQuery(  $GLOBALS['g_egltb_team_joins'], $obj ) . 
						" WHERE id=".(int)$join_id;
						
		# execute query
		return $this->pDBInterfaceCon->Query( $sql_query );
	}

	
	
	//-------------------------------------------------------------------------------
	// Purpose: create a team => to clan
	//-------------------------------------------------------------------------------
	function CreateTeam( $object )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBInterfaceCon->CreateInsertQuery( $GLOBALS['g_egltb_teams'], $object );
		if( $this->pDBInterfaceCon->Query( $sql_query ) )
			return $this->pDBInterfaceCon->InsertId();
		return -1;
	}
	
	
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	function JoinTeam( $object )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBInterfaceCon->CreateInsertQuery( $GLOBALS['g_egltb_team_joins'], $object );
		return ($this->pDBInterfaceCon->Query( $sql_query ) );
	}
		
	
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	function SignoutMember( $member_id, $team_id )
	{
		$sql_query = "DELETE FROM `".$GLOBALS['g_egltb_team_joins']."`  WHERE team_id=".(int)$team_id." && member_id=".(int)$member_id."";
		return ($this->pDBInterfaceCon->Query( $sql_query ) );
		# get all teams of clanm - which you $member_id joined
	}
		
	
	
	//-------------------------------------------------------------------------------
	// Purpose: get the list of a member to all clan-team permissions
	//-------------------------------------------------------------------------------
	function GetTeamPermissions( $member_id, $team_id )
	{
		$sql_query = "SELECT * FROM `".$GLOBALS['g_egltb_team_joins']."` AS team_joins WHERE team_id=".(int)$team_id." && member_id=".(int)$member_id."";
		return ($this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) ));
	}	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetNumTeamJoins( $member_id, $team_id )
	{
		$sql_query = 	" SELECT COUNT(*) AS num_team_joins ".
						" FROM `".$GLOBALS['g_egltb_team_joins']."` ".
						" WHERE team_id=".(int)$team_id." AND member_id=".(int)$member_id. "".
						" GROUP BY team_id";
			#BUG: evt. Bug problem, wegen "GROUP BY team_id"
		$data = ($this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) ));
		return (int) $data->num_team_joins;
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetTeamInfoAsParttype( $team_id )
	{
		$sql_query = 	" SELECT clan_acc.name AS participant_clan_name, teams.logo_file AS participant_logo_file, clan_acc.tag AS participant_clan_tag," .
						" teams.clan_id AS participant_clan_id, teams.name AS participant_name, teams.id AS participant_id, country.id AS country_id, country.name AS country_name, country.image_file AS country_image_file ".
						" FROM `{$GLOBALS['g_egltb_teams']}` AS teams ".
						" LEFT JOIN ".$GLOBALS['g_egltb_clan_accounts']." AS clan_acc ".
						" ON (teams.clan_id=clan_acc.id) ".
						" LEFT JOIN `{$GLOBALS['g_egltb_countries']}` AS country ".
						" ON (country.id=teams.country_id) ".
						" WHERE  teams.id=".(int)$team_id." ";
		return ($this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) ));
	}

	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetLimitedTeamlist( $limit_start, $limit_cnt , $ORDER='', $ORDER_TYPE='' )
	{
		if( strlen($ORDER) > 0 ) $ORDER = " ORDER BY {$ORDER}";
		$sql_query = 	" SELECT clan_acc.name AS clan_name, clan_acc.id AS clan_id, teams.logo_file AS logo_file, clan_acc.tag AS clan_tag," .
						" teams.created, teams.name, teams.tag, teams.id , country.id AS country_id, country.name AS country_name, country.image_file AS country_image_file, ".
						" COUNT(team_joins.team_id) AS num_teammembers ".
						" FROM ".$GLOBALS['g_egltb_teams']." AS teams ".
						" LEFT JOIN ".$GLOBALS['g_egltb_clan_accounts']." AS clan_acc ".
						" ON (teams.clan_id=clan_acc.id) ".
						" LEFT JOIN ".$GLOBALS['g_egltb_countries']." AS country ".
						" ON (country.id=teams.country_id) ".
						" LEFT JOIN ".$GLOBALS['g_egltb_team_joins']." AS team_joins ".
						" ON teams.id=team_joins.team_id ".
						" GROUP BY teams.id ".
						" {$ORDER} {$ORDER_TYPE} ".
						" LIMIT $limit_start,$limit_cnt ";
		return ($this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) ));
	}	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetDetailedTeamlist( $WHERE='' , $ORDER='', $ORDER_TYPE='' )
	{
		if( strlen($ORDER) > 0 ) $ORDER = " ORDER BY {$ORDER}";
		$sql_query = 	" SELECT clan_acc.name AS clan_name, clan_acc.id AS clan_id, teams.logo_file AS logo_file, clan_acc.tag AS clan_tag," .
						" teams.created, teams.name, teams.tag, teams.id , country.id AS country_id, country.name AS country_name, country.image_file AS country_image_file, ".
						" COUNT(team_joins.team_id) AS num_teammembers ".
						" FROM ".$GLOBALS['g_egltb_teams']." AS teams ".
						" LEFT JOIN ".$GLOBALS['g_egltb_clan_accounts']." AS clan_acc ".
						" ON (teams.clan_id=clan_acc.id) ".
						" LEFT JOIN ".$GLOBALS['g_egltb_countries']." AS country ".
						" ON (country.id=teams.country_id) ".
						" LEFT JOIN ".$GLOBALS['g_egltb_team_joins']." AS team_joins ".
						" ON teams.id=team_joins.team_id ".
						" {$WHERE } ".
						" GROUP BY teams.id ".
						" {$ORDER} {$ORDER_TYPE} ";
		return ($this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) ));
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: return the counter of registered members
	//-------------------------------------------------------------------------------
	function GetNumTeams()
	{
		$sql_query = 	" SELECT COUNT(*) AS num_teams ".
						" FROM `".$GLOBALS['g_egltb_teams']."` AS teams".
						" ";
		$object = $this->pDBInterfaceCon->FetchObject($this->pDBInterfaceCon->Query( $sql_query ));
		return $object->num_teams;
	}	
		
	
	/**
	 * Check : Member in Team?
	 *
	 * @param string $member_id
	 * @param string $team_id
	 * @return team-join object
	 */
	
	function TeamSelfTest( $member_id, $team_id )
	{
		/*
		$sql_query = 	' SELECT * FROM '.DBTB::GetTB('GLOBAL', 'EGL_TEAMS').' AS teams, '.
						' 				'.DBTB::GetTB('GLOBAL', 'EGL_TEAM_JOINS').' AS team_joins'.
						' WHERE teams.id=team_joins.team_id && team_joins.member_id='.(int)$member_id.' && teams.id='.(int)$team_id.' ';
		*/
		$sql_query = 	' SELECT * FROM `'.DBTB::GetTB('GLOBAL', 'EGL_TEAM_JOINS').'` AS team_joins'.
						' WHERE team_joins.team_id='.(int)$team_id.' && team_joins.member_id='.(int)$member_id.' ';
		return $this->pDBInterfaceCon->FetchArrayObject($this->pDBInterfaceCon->Query( $sql_query ));			
	}
	
	
	/**
	 * getting all teams, which member has beend joined
	 *
	 * @param integer $member_id
	 */
	function GetJoinedTeamlist( $member_id )
	{
		$sql_query = 	' SELECT teams.* FROM `'.DBTB::GetTB('GLOBAL', 'EGL_TEAMS').'` AS teams, '.
						' 				`'.DBTB::GetTB('GLOBAL', 'EGL_TEAM_JOINS').'` AS team_joins'.
						' WHERE teams.id=team_joins.team_id && team_joins.member_id='.(int)$member_id.' ';
		return $this->pDBInterfaceCon->FetchArrayObject($this->pDBInterfaceCon->Query( $sql_query ));			
	}
};




?>