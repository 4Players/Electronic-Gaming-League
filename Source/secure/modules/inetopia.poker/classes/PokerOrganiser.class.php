<?php
# ================================ Copyright � 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================

DBTB::RegisterTB( 'GLOBAL', 'POKER_ORGANISER',	'poker_organiser' );
DBTB::RegisterTB( 'GLOBAL', 'POKER_ORGANISER_MEMBERS',	'poker_organiser_members' );

class PokerOrganiser
{
	# -[ variables ]-
	var $pDBInterface	= NULL;

	# -[ functions ]-
	/**
	 * constructor
	 * 
	 */
	function PokerOrganiser ( &$pDBCon )
	{
		$this->pDBInterface = &$pDBCon;
	}

	/**	
	 * register organiser
	 * 
	 * param array $object	field-list
	 */
	function RegisterOrganiser( $object )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBInterface->CreateInsertQuery( DBTB:: GetTB( 'GLOBAL', 'POKER_ORGANISER' ), $object );
		$qre = $this->pDBInterface->Query( $sql_query );
		if( $qre ) return $this->pDBInterface->InsertId();
		return -1;
	}
	
	/** 
	 * register organiser
	 * 
	 * param array $object	field-list
	 */
	function RegisterOrganiserMember( $object )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBInterface->CreateInsertQuery( DBTB:: GetTB( 'GLOBAL', 'POKER_ORGANISER_MEMBERS' ), $object );
		$qre = $this->pDBInterface->Query( $sql_query );
		if( $qre ) return $this->pDBInterface->InsertId();
		return -1;
	}
	
			
	/**
	 * delete organiser
	 * 
	 * param integer organiser-id
	 */
	function DeleteOrganiser( $organiser_id ){
	}
		
	//-------------------------------------------------------------------------------
	// Purpose: read all accounts
	//-------------------------------------------------------------------------------
	function GetOrganiser( $member_id )
	{
		$sql_query = 	" SELECT  organiser.*, organiser_memb.organiser_id AS organiser_id, organiser_memb.permissions, organiser_memb.member_id ".
						" FROM `".DBTB:: GetTB( 'GLOBAL', 'POKER_ORGANISER_MEMBERS' )."` AS organiser_memb, `".DBTB:: GetTB( 'GLOBAL', 'POKER_ORGANISER' )."` AS organiser ".
						" WHERE organiser_memb.member_id=".(int)$member_id. " AND organiser.id=organiser_memb.organiser_id ";
			
		return $this->pDBInterface->FetchArrayObject( $this->pDBInterface->Query($sql_query) );						
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: read all accounts
	//-------------------------------------------------------------------------------
	function GetOrganiserById( $organiser_id )
	{
		$sql_query = 	" SELECT * ".
						" FROM `".DBTB:: GetTB( 'GLOBAL', 'POKER_ORGANISER' )."` AS organiser ".
						" WHERE organiser.id=".(int)$organiser_id." ";
		return $this->pDBInterface->FetchObject( $this->pDBInterface->Query($sql_query) );						
	}	
	
	/**
	 * GetOrganiserSessions()
	 * 
	 * param $organiser_id integer
	 * return array
	 */
	function GetOrganiserSessions( $organiser_id, $limit=10 )
	{
		$sql_query = 	" SELECT sessions.* ".
						" FROM `".DBTB::GetTB('GLOBAL', 'POKER_ORGANISER_MEMBERS')."` AS organiser ".
						" LEFT JOIN `".DBTB::GetTB('GLOBAL','POKER_SESSIONS')."` AS sessions ".
						" ON organiser.id=sessions.organiser_id ".
						" WHERE organiser.id=".(int)$organiser_id." ".
						" ORDER BY sessions.date DESC ".
						" LIMIT 0,".(int)$limit;
		return $this->pDBInterface->FetchArrayObject( $this->pDBInterface->Query($sql_query) );
	}	
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//  Output:
	//-------------------------------------------------------------------------------
	function GetOrganiserMembers( $organiser_id )
	{
		# fetch teams + team joins
		$query		 = 	" SELECT organiser_members.*, members.country_id AS country_id, members.birthday AS birthday, members.nick_name AS nick_name, members.photo_file AS member_photo_file ".
						" FROM `".DBTB::GetTB('GLOBAL','POKER_ORGANISER_MEMBERS')."` AS organiser_members, `".DBTB:: GetTB( 'GLOBAL', 'EGL_MEMBERS' )."` AS members ".
						" WHERE (organiser_members.member_id=members.id) AND (organiser_members.organiser_id=".(int)$organiser_id.")";
		return ($this->pDBInterface->FetchArrayObject( $this->pDBInterface->Query( $query ) ));
	}
	
		
};
?>