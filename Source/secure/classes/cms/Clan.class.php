<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================





# -[ objectlist ] -

class clan_buffer_t
{
	var $aClanMembers	= NULL; 	# containing clan+member informations
	var $aTeamJoins		= NULL; 	# containing team+joins informations
};




# -[ class ] -
class Clan
{
	# -[ variables ]-
	var $pDBCon	= NULL;
	var $iMemberId	= -1;
	var $aAccounts	= NULL;

	
	# -[ functions ]-
	
	

	//-------------------------------------------------------------------------------
	// Purpose: constructor
	//-------------------------------------------------------------------------------
	function Clan ( &$pDBCon )
	{
		$this->pDBCon = &$pDBCon;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: set id
	//-------------------------------------------------------------------------------
	function SetId( $id )
	{
		return ($this->iMemberId = (int)$id);
	}
	
	

	//-------------------------------------------------------------------------------
	// Purpose: read all accounts
	//-------------------------------------------------------------------------------
	function FillBuffers()
	{
		if( !$this->iMemberId ) return 0;
		
		# gg
		$sql_query = 	" SELECT clan_acc.*, clan_memb.clan_id AS clan_id, clan_memb.permissions, clan_memb.member_id ".
						" FROM `".$GLOBALS['g_egltb_clan_members']."` AS clan_memb, `".$GLOBALS['g_egltb_clan_accounts']."` AS clan_acc ".
						" WHERE clan_memb.member_id=".(int)$this->iMemberId. " AND clan_acc.id=clan_memb.clan_id ";
			
		#$this->aAccounts 	= array();
		
		#$this->aTeams 		= array(); NOT USED
		# fetch clan - accounts
		$this->aAccounts = $this->pDBCon->FetchArrayObject( $this->pDBCon->Query($sql_query) );						
		return 1; //sizeof($this->aAccounts);
	}
	
	

	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------

	function GetAccounts()
	{
		return $this->aAccounts;
	}
	
	
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	function GetAccount( $id )
	{
		$num_accounts = sizeof($this->aAccounts);
		for( $i=0; $i < $num_accounts; $i++ )
			if( $this->aAccounts[$i]->id == $id )
				return $this->aAccounts[$i];
		return NULL;
	}
	

	# =========================================================================
	# PUBLIC
	# =========================================================================

	
	//-------------------------------------------------------------------------------
	// Purpose: Signin Clan
	//-------------------------------------------------------------------------------
	function Signin( $object )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBCon->CreateInsertQuery( $GLOBALS['g_egltb_clan_accounts'], $object );
		$qre = $this->pDBCon->Query( $sql_query );
		if( $qre ) return $this->pDBCon->InsertId();
		return -1;
	}

	//-------------------------------------------------------------------------------
	// Purpose: Signin Clan-Member => to clan id
	//-------------------------------------------------------------------------------
	function SigninMember( $object )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBCon->CreateInsertQuery( $GLOBALS['g_egltb_clan_members'], $object );
		return ($this->pDBCon->Query( $sql_query ) );
	}
	
	
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	function SignoutMember( $member_id, $clan_id )
	{
		//$sql_delete_team_joins = "DELETE FROM ". $GLOBALS['g_egltb_team_joins']." AS team_joins  WHERE member_id=$member_id AND clan_id=$clan_id ";
		$sql_delete_clan_member = "DELETE FROM `". $GLOBALS['g_egltb_clan_members']."` WHERE member_id=$member_id AND clan_id=$clan_id ";
		
		//($this->pDBCon->Query( $sql_delete_team_joins ) );
		($this->pDBCon->Query( $sql_delete_clan_member ) );
		
		# get all teams of clanm - which you $member_id joined
		
		
		return 1;
	}
		
	//-------------------------------------------------------------------------------
	// Purpose: Signin a member to clan
	//-------------------------------------------------------------------------------
	function SignJoin( $object )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBCon->CreateInsertQuery( $GLOBALS['g_egltb_clan_members'], $object );
		$qre = $this->pDBCon->Query( $sql_query );
		if( $qre ) return $this->pDBCon->InsertId();
		return -1;
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: get min clan informations => 	
	//-------------------------------------------------------------------------------
	function GetClanByName( $name )
	{
		$sql_query = 	" SELECT * ".
						" FROM `".$GLOBALS['g_egltb_clan_accounts']."` ".
						" WHERE name='".$this->pDBCon->EscapeString($name)."' ".
						" LIMIT 0,1";
		return $this->pDBCon->FetchObject( $this->pDBCon->Query( $sql_query ) );
	}
	

	//-------------------------------------------------------------------------------
	// Purpose: get min clan informations => 	
	//-------------------------------------------------------------------------------
	function GetClansByName( $name )
	{
		$sql_query = "SELECT * FROM `".$GLOBALS['g_egltb_clan_accounts']."` WHERE name='".$this->pDBCon->EscapeString($name)."'";
		return $this->pDBCon->FetchArrayObject( $this->pDBCon->Query( $sql_query ) );
	}
	
	
	/*
	//-------------------------------------------------------------------------------
	// Purpose:checks, other clan
	//-------------------------------------------------------------------------------
	function GetClansByName_ownClanID( $name, $own_clan_id )
	{
		$sql_query = "SELECT * FROM `".$GLOBALS['g_egltb_clan_accounts']."` WHERE name='".$this->pDBCon->EscapeString($name)."' && id!=".(int)$own_clan_id;
		return $this->pDBCon->FetchArrayObject( $this->pDBCon->Query( $sql_query ) );
	}*/
	
	//-------------------------------------------------------------------------------
	// Purpose: gets claninformations by overgiven ID
	//-------------------------------------------------------------------------------
	function GetClanById( $id )
	{
		$sql_query = 	" SELECT * ".
						" FROM ".$GLOBALS['g_egltb_clan_accounts']." AS clan_acc ".
						" WHERE clan_acc.id =".(int)$id ;
		return $this->pDBCon->FetchObject( $this->pDBCon->Query($sql_query) );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: get clan with teams
	//-------------------------------------------------------------------------------
	function GetClanTeams( $clan_id )
	{
		$sql_query 		= 	" SELECT teams.*, COUNT(team_joins.team_id) AS num_teammembers ".
							" FROM ".$GLOBALS['g_egltb_teams']." AS teams ".
							" LEFT JOIN ".$GLOBALS['g_egltb_team_joins']." AS team_joins ".
							" ON team_joins.team_id=teams.id ". 
							" WHERE teams.clan_id=$clan_id ".
							" GROUP BY team_joins.team_id ".
							" ORDER BY teams.name ASC ";
		return $this->pDBCon->FetchArrayObject( $this->pDBCon->Query($sql_query));
	}
	
	
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	function SetClanData( $obj, $id )
	{
		# execute query
		return $this->pDBCon->Query( $this->pDBCon->CreateUpdateQuery(  $GLOBALS['g_egltb_clan_accounts'], $obj ) . " WHERE id=".$id );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//  Output:
	//  Reason: listing the team members for each team
	//-------------------------------------------------------------------------------
	function GetClanMembers( $id )
	{
		$clan_query = 	" SELECT clan_acc.*, clan_memb.permissions, members.nick_name, members.photo_file, members.birthday, members.country_id, members.sex, members.id AS member_id ".
						" FROM  `".$GLOBALS['g_egltb_clan_accounts']."` AS clan_acc, `".$GLOBALS['g_egltb_clan_members']."` AS clan_memb, `".$GLOBALS['g_egltb_members']."` AS members ".
						" WHERE clan_acc.id=clan_memb.clan_id AND members.id=clan_memb.member_id AND clan_acc.id=".(int)$id ." ".
						" ORDER BY clan_memb.created ASC";
		return ($this->pDBCon->FetchArrayObject( $this->pDBCon->Query( $clan_query ) ));
	}

	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetClanPermissions( $member_id, $clan_id )
	{
		$sql_query = 	" SELECT * FROM `".$GLOBALS['g_egltb_clan_members']."` AS clan_members ".
						" WHERE clan_id=".(int)$clan_id." AND member_id=".(int)$member_id."";
		return ($this->pDBCon->FetchObject( $this->pDBCon->Query( $sql_query ) ));
	}

	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetClanMemberByID( $clan_id, $member_id )
	{
		$sql_query = 	" SELECT * FROM `".$GLOBALS['g_egltb_clan_members']."` AS clan_members, `".$GLOBALS['g_egltb_members']."` AS members ".
						" WHERE members.id=clan_members.member_id && clan_id=".(int)$clan_id." AND member_id=".(int)$member_id."";
		return ($this->pDBCon->FetchObject( $this->pDBCon->Query( $sql_query ) ));
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetClanMemberByPermissions( $clan_id, $permissions )
	{
		$sql_query = 	" SELECT * FROM `".$GLOBALS['g_egltb_clan_members']."` AS clan_members ".
						" WHERE clan_id=".(int)$clan_id." AND permissions='".$this->pDBCon->EscapeString($permissions)."'";
		return ($this->pDBCon->FetchArrayObject( $this->pDBCon->Query( $sql_query ) ));
	}

		
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//  Output:
	//-------------------------------------------------------------------------------
	function RemoveClanMemberByMemberId( $clan_id, $member_id )
	{
		$sql_query 	= 	" DELETE FROM `".$GLOBALS['g_egltb_clan_members']."` ".
						" WHERE clan_id=".(int)$clan_id." && member_id=".(int)$member_id." ";
		return $this->pDBCon->Query( $sql_query );
		
	}
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//  Output:
	//-------------------------------------------------------------------------------
	function RemoveClanMemberByID( $member_join_id )
	{
		$sql_query 	= 	" DELETE FROM `".$GLOBALS['g_egltb_clan_members']."` ".
						" WHERE id=".(int)$member_join_id;
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
		
		
	/*
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetClanData( $id )
	{
		# set to int
		$id = (int)$id;
		
		# fetch clan account + clan members
		$clan_query = " SELECT clan_acc.*, clan_memb.*, members.country_id AS member_country_id, members.nick_name, members.birthday AS member_birthday, members.logo_file AS member_logo_file, members.photo_file AS member_photo_file ".
					  " FROM  ".$GLOBALS['g_egltb_clan_accounts']." AS clan_acc, ".$GLOBALS['g_egltb_clan_members']." AS clan_memb, ".$GLOBALS['g_egltb_members']." AS members ".
					  " WHERE clan_acc.id=clan_memb.clan_id AND members.id=clan_memb.member_id AND clan_acc.id=$id ".
					  " ORDER BY clan_memb.created ASC";	

		# fetch teams(+data) + team joins(+data)
		$team_query = 	" SELECT teams.id AS team_id, teams.name AS team_name, teams.clan_id AS clan_id, teams.created AS team_created, teams.games AS team_games, team_joins.member_id AS member_id, team_joins.permissions AS permissions, team_joins.created AS created, team_joins.id AS id ".
						" FROM ".$GLOBALS['g_egltb_teams']." AS teams ".
						" LEFT JOIN ".$GLOBALS['g_egltb_team_joins']." AS team_joins ".
						" ON teams.id=team_joins.team_id ".
						" HAVING teams.clan_id=$id ".
						" ORDER BY teams.name ASC, team_joins.created ASC";
	
		$clan_buffer = & new clan_buffer_t;		
		$clan_buffer->aClanMembers 	= $this->pDBCon->FetchArrayObject( $this->pDBCon->Query( $clan_query ) );
		$clan_buffer->aTeamJoins 	= $this->pDBCon->FetchArrayObject( $this->pDBCon->Query( $team_query ) );
		
		# echo nl2br( print_r( $clan_buffer->aTeamJoins, 1 ) );

		return $clan_buffer;
		
		#$sql_query = "SELECT clan_acc.*,  FROM ".$GLOBALS['g_egltb_clan_accounts']." AS clan_acc, ".$GLOBALS['g_egltb_clan_members']." AS clan_memb WHERE clan_acc.id=clan_memb.clan_id AND clan.acc=".(int)$id."";
		#return $this->pDBCon->FetchObject( $this->pDBCon->Query( $sql_query ) );
		
	}
	*/
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//  Output:
	//-------------------------------------------------------------------------------
	function ClanJoinedByMemberId( $clan_id, $member_id )
	{
		$sql_query	= 	" SElECT COUNT(*) AS is_joined ".
						" FROM ".$GLOBALS['g_egltb_clan_members']." AS clan_members ".
						" WHERE clan_members.member_id=".(int)$member_id." AND clan_members.clan_id=".(int)$clan_id;
						
		$data = $this->pDBCon->FetchObject($this->pDBCon->Query( $sql_query ) );
		return $data->is_joined;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//  Output:
	//  Reason:
	//-------------------------------------------------------------------------------
	function SetClanMemberData( $obj, $clan_id, $member_id )
	{
		$sql_query = 	$this->pDBCon->CreateUpdateQuery(  $GLOBALS['g_egltb_clan_members'], $obj ) . 
						" WHERE clan_id=".(int)$clan_id." && member_id=".(int)$member_id;
						
		# execute query
		return $this->pDBCon->Query( $sql_query );
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//  Output:
	//  Reason:
	//-------------------------------------------------------------------------------
	function SetClanMemberDataByJoinId( $obj, $join_id )
	{
		$sql_query = 	$this->pDBCon->CreateUpdateQuery(  $GLOBALS['g_egltb_clan_members'], $obj ) . 
						" WHERE id=".(int)$join_id;
						
		# execute query
		return $this->pDBCon->Query( $sql_query );
	}

	
	
	/*
	//-------------------------------------------------------------------------------
	// Purpose: 
	//  Output:
	//  Reason: listing the team members for each team
	//-------------------------------------------------------------------------------
	function GetTeamMembers( $team_id )
	{
		# fetch teams + team joins
		$team_query = 	" SELECT team_joins.*, members.country_id AS country_id, members.birthday AS birthday, members.nick_name AS nick_name, members.photo_file AS member_photo_file ".
						" FROM ".$GLOBALS['g_egltb_team_joins']." AS team_joins, ".$GLOBALS['g_egltb_members']." AS members ".
						" WHERE (team_joins.member_id=members.id) AND (team_joins.team_id=$team_id)";
		return ($this->pDBCon->FetchArrayObject( $this->pDBCon->Query( $team_query ) ));
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//  Output:
	//  Reason:
	//-------------------------------------------------------------------------------
	function GetTeam( $team_id )
	{
		$team_query = "SELECT team.* FROM ".$GLOBALS['g_egltb_teams']." AS team WHERE id=$team_id";
		return ($this->pDBCon->FetchObject( $this->pDBCon->Query( $team_query ) ));
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//  Output:
	//  Reason:
	//-------------------------------------------------------------------------------
	function GetTeamClan( $team_id )
	{
		$team_query = 	" SELECT team.*, clans.id AS clan_id, clans.name AS clan_name, clans.tag AS clan_tag, clans.logo_file AS clan_logo_file  ".
						" FROM ".$GLOBALS['g_egltb_teams']." AS team ".
						" LEFT JOIN ".$GLOBALS['g_egltb_clan_accounts']." AS clans ".
						" ON clans.id=team.clan_id ".
						" HAVING team.id=$team_id";
		return ($this->pDBCon->FetchObject( $this->pDBCon->Query( $team_query ) ));
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//  Output:
	//  Reason:
	//-------------------------------------------------------------------------------
	function GetTeamDetails( $team_id )
	{
		# fetch teams(+data) + team joins(+data)
		$team_query = 	" SELECT teams.id AS team_id, teams.name AS team_name, teams.clan_id AS clan_id, teams.created AS team_created, ".
							" teams.games AS team_games, team_joins.member_id AS member_id, team_joins.permissions AS permissions, team_joins.created AS created, team_joins.id AS id ".
						" FROM ".$GLOBALS['g_egltb_teams']." AS teams LEFT JOIN ".$GLOBALS['g_egltb_team_joins']." AS team_joins ".
						" ON teams.id=team_joins.team_id ".
						" HAVING teams.id=$team_id ".
						" ORDER BY teams.name ASC, team_joins.created ASC";
		return ($this->pDBCon->FetchArrayObject( $this->pDBCon->Query( $team_query ) ));
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: get the list of a member to all clan-team permissions
	//-------------------------------------------------------------------------------
	function GetTeamPermissions( $member_id, $team_id )
	{
		$sql_query = "SELECT * FROM ".$GLOBALS['g_egltb_team_joins']." AS team_joins WHERE team_id=$team_id AND member_id=$member_id";
		return ($this->pDBCon->FetchObject( $this->pDBCon->Query( $sql_query ) ));
	}
	*/
	
	
	/*
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetNumTeamJoins( $member_id, $team_id )
	{
		$sql_query = 	" SELECT COUNT(*) AS num_team_joins ".
						" FROM ".$GLOBALS['g_egltb_team_joins']." ".
						" WHERE team_id=$team_id AND member_id=$member_id ".
						" GROUP BY team_id";
			#BUG: evt. Bug problem, wegen "GROUP BY team_id"
		$data = ($this->pDBCon->FetchObject( $this->pDBCon->Query( $sql_query ) ));
		return (int) $data->num_team_joins;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------	
	function SetTeamData( $obj, $team_id )
	{
		$sql_query = 	$this->pDBCon->CreateUpdateQuery(  $GLOBALS['g_egltb_teams'], $obj ) . 
						" WHERE id=".$team_id;
						
		# execute query
		return $this->pDBCon->Query( $sql_query );
	}

	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------	
	function SetTeamJoinData( $obj, $team_id )
	{
		$sql_query = 	$this->pDBCon->CreateUpdateQuery(  $GLOBALS['g_egltb_team_joins'], $obj ) . 
						" WHERE id=".$join_id;
						
		# execute query
		return $this->pDBCon->Query( $sql_query );
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: => delete team
	//			=> delete team joins
	//-------------------------------------------------------------------------------	
	function DeleteTeam( $team_id )
	{
	}
	*/	

	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------	
	function GetOpenMatches( $team_id )
	{
		
		return 1;
	}
	


	//-------------------------------------------------------------------------------
	// Purpose: ATTENTION: gets clans / teams - $id_list = team_id liost
	//-------------------------------------------------------------------------------	
	function __GetClanlistData( $id_list )
	{
		$sql_query = 	" SELECT clan_acc.name AS participant_clan_name, clan_acc.id AS participant_clan_id, clan_acc.logo_file AS participant_logo_file, clan_acc.tag AS participant_clan_tag," .
						" teams.name AS participant_name, teams.id AS participant_id, country.id AS country_id, country.name AS country_name, country.image_file AS country_image_file ".
						" FROM `".$GLOBALS['g_egltb_teams']."` AS teams ".
						" LEFT JOIN `".$GLOBALS['g_egltb_clan_accounts']."` AS clan_acc ".
						" ON (teams.clan_id=clan_acc.id) ".
						" LEFT JOIN `".$GLOBALS['g_egltb_countries']."` AS country ".
						" ON (country.id=clan_acc.country_id) ".
						" WHERE FIND_IN_SET(teams.id,'$id_list') ";
		return ($this->pDBCon->FetchArrayObject( $this->pDBCon->Query( $sql_query ) ));
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------	
	function DeleteClan( $clan_id )
	{
		$sql_query 	= " DELETE FROM ".$GLOBALS['g_egltb_clan_accounts']." WHERE id=".(int)$clan_id;
		return $this->pDBCon->Query( $sql_query );
	}//function 
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetNumClans()
	{
		$sql_query = 	" SELECT COUNT(*) AS num_clans ".
						" FROM `".$GLOBALS['g_egltb_clan_accounts']."` AS clan_accs".
						" ";
		$object = $this->pDBCon->FetchObject($this->pDBCon->Query( $sql_query ));
		return $object->num_clans;
	}		
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetNumTeams()
	{
		$sql_query = 	" SELECT COUNT(*) AS num_teams ".
						" FROM `".$GLOBALS['g_egltb_teams']."` AS teams ".
						" ";
		$object = $this->pDBCon->FetchObject($this->pDBCon->Query( $sql_query ));
		return $object->num_teams;
	}		
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//------------------------------------------------------------------------------
	function GetClans()
	{
		$sql_query = " SELECT * FROM `".$GLOBALS['g_egltb_clan_accounts']."` ";
		return ($this->pDBCon->FetchArrayObject( $this->pDBCon->Query( $sql_query ) ));
	}

	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//------------------------------------------------------------------------------
	function GetDetailedClanlist($WHERE='', $ORDER='', $ORDER_TYPE='' )
	{
		if( strlen($ORDER) > 0 ) $ORDER = " ORDER BY {$ORDER}";
		$sql_query = " SELECT clans.*, COUNT(clan_members.clan_id) AS num_clanmembers ".
					 " FROM `{$GLOBALS['g_egltb_clan_accounts']}` AS clans ".
					 " LEFT JOIN `{$GLOBALS['g_egltb_clan_members']}` AS clan_members ".
					 " ON clan_members.clan_id=clans.id ".
					 " {$WHERE} ".
					 " GROUP BY clan_members.clan_id ".
					 " {$ORDER} {$ORDER_TYPE}";
		return ($this->pDBCon->FetchArrayObject( $this->pDBCon->Query( $sql_query ) ));
	}
	
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetNumClanInvites( $member_id )
	{
		$sql_query 	=	" SELECT COUNT(*) AS num_invites FROM `".$GLOBALS['g_egltb_clan_invites']."` AS clan_invites ".
						" WHERE member_id=".(int)$member_id." ".
						" GROUP BY id";
		$obj = $this->pDBCon->FetchObject( $this->pDBCon->Query($sql_query));
		return $obj->num_invites;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetClanInvites( $clan_id )
	{
		$sql_query 	=	" SELECT clan_invites.id AS invite_id, clan_invites.created AS invite_created, clan_invites.accepted,clan_invites.processed, members.* ".
						" FROM `".$GLOBALS['g_egltb_clan_invites']."` AS clan_invites ".
						" LEFT JOIN `".$GLOBALS['g_egltb_members']."` AS members  ".
						" ON clan_invites.member_id=members.id ".
						" WHERE clan_invites.clan_id=".(int)$clan_id." ".
						" ORDER BY clan_invites.created DESC";
		return $this->pDBCon->FetchArrayObject( $this->pDBCon->Query($sql_query));
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetMemberInvites( $member_id )
	{
		$sql_query 	=	" SELECT clan_invites.processed, clan_invites.accepted, clan_invites.text AS invite_text, clan_invites.id AS invite_id, clan_accs.* FROM ".$GLOBALS['g_egltb_clan_invites']." AS clan_invites ".
						" LEFT JOIN ".$GLOBALS['g_egltb_clan_accounts']." AS clan_accs ".
						" ON clan_invites.clan_id=clan_accs.id ".
						" WHERE member_id=".(int)$member_id." ".
						" ORDER By clan_invites.created DESC";
		return $this->pDBCon->FetchArrayObject( $this->pDBCon->Query($sql_query));
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetNumMemberInvites( $member_id )
	{
		$sql_query 	=	" SELECT COUNT(clan_invites.id) AS num_invites FROM `".$GLOBALS['g_egltb_clan_invites']."` AS clan_invites ".
						" LEFT JOIN `".$GLOBALS['g_egltb_clan_accounts']."` AS clan_accs ".
						" ON clan_invites.clan_id=clan_accs.id ".
						" WHERE member_id=".(int)$member_id." ".
						" GROUP BY clan_invites.member_id ";
		$data = $this->pDBCon->FetchObject( $this->pDBCon->Query($sql_query));
		return (int)$data->num_invites;
	}
	
	

	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetNumRawMemberInvites( $member_id )
	{
		$sql_query 	=	" SELECT COUNT(clan_invites.id) AS num_invites FROM `".$GLOBALS['g_egltb_clan_invites']."` AS clan_invites ".
						" LEFT JOIN `".$GLOBALS['g_egltb_clan_accounts']."` AS clan_accs ".
						" ON clan_invites.clan_id=clan_accs.id ".
						" WHERE member_id=".(int)$member_id." && processed=0  ".
						" GROUP BY clan_invites.member_id ";
		$data = $this->pDBCon->FetchObject( $this->pDBCon->Query($sql_query));
		return (int)$data->num_invites;
	}

		
		
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function CreateInvitation( $object )
	{
		$sql_query = $this->pDBCon->CreateInsertQuery( $GLOBALS['g_egltb_clan_invites'], $object );
		$qre = $this->pDBCon->Query( $sql_query );
		if( $qre ) return $this->pDBCon->InsertId();
		return -1;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function SetInvitationData( $id, $obj )
	{
		return $this->pDBCon->Query( $this->pDBCon->CreateUpdateQuery(  $GLOBALS['g_egltb_clan_invites'], $obj ) . " WHERE id=".(int)$id );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function ActiveInvitationAvailable( $clan_id, $member_id )
	{
		$sql_query =	" SELECT COUNT(*) AS num_active_invitations FROM `".$GLOBALS['g_egltb_clan_invites']."` AS clan_invites ".
						" WHERE clan_id=".(int)$clan_id." && member_id=".(int)$member_id." && !processed ";
		$data = $this->pDBCon->FetchObject( $this->pDBCon->Query($sql_query)); 
		return $data->num_active_invitations;
	}
	
	
	function DeleteInvite( $id )
	{
		return $this->pDBCon->Query( "DELETE FROM ".$GLOBALS['g_egltb_clan_invites']." WHERE id=".(int)$id );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetLimitedClanlist( $limit_start, $limit_cnt, $ORDER='', $ORDER_TYPE='' )
	{
		if( strlen($ORDER) > 0 ) $ORDER = " ORDER BY {$ORDER}";
		$sql_query = 	" SELECT clan_acc.*, " .
						" country.id AS country_id, country.name AS country_name, country.image_file AS country_image_file, ".
						" COUNT(clan_members.clan_id) AS num_clanmembers ".
						" FROM ".$GLOBALS['g_egltb_clan_accounts']." AS clan_acc ".
						" LEFT JOIN ".$GLOBALS['g_egltb_countries']." AS country ".
						" ON (country.id=clan_acc.country_id) ".
						" LEFT JOIN ".$GLOBALS['g_egltb_clan_members']." AS clan_members ".
						" ON (clan_acc.id=clan_members.clan_id) ".
						" GROUP BY clan_members.clan_id".
						" {$ORDER} {$ORDER_TYPE}".
						" LIMIT {$limit_start},{$limit_cnt} ";
		return ($this->pDBCon->FetchArrayObject( $this->pDBCon->Query( $sql_query ) ));
	}
	

		
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function GetJoinedClans( $member_id )
	{
		$sql_query = 	' SELECT clans.* FROM `'.DBTB::GetTB('GLOBAL', 'EGL_CLANS').'` AS clans, '.
						' 				`'.DBTB::GetTB('GLOBAL', 'EGL_CLAN_MEMBERS').'` AS clan_members'.
						' WHERE clans.id=clan_members.clan_id && clan_members.member_id='.(int)$member_id.' ';
		return $this->pDBCon->FetchArrayObject($this->pDBCon->Query( $sql_query ));			
	}	
	
};

?>