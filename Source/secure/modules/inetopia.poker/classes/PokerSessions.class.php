<?php
DBTB::RegisterTB( 'GLOBAL', 'POKER_SESSIONS',					'poker_sessions' );
DBTB::RegisterTB( 'GLOBAL', 'POKER_SESSION_PARTICIPANTS',		'poker_session_participants' );

class PokerSessions
{
	# -[ variables ]-
	var $pDBInterface	= NULL;

	# -[ functions ]-
	// Purpose: constructor
	//-------------------------------------------------------------------------------
	function PokerSessions ( &$pDBCon )
	{
		$this->pDBInterface = &$pDBCon;
	}
	
	/**
	 * get sessions
	 * 
	 */
	function GetSessions(){
		$sql_query = 	" SELECT *,sessions.name, sessions.id AS session_id, sessions.city, sessions.plz, sessions.street, ".
						"  organiser.name AS organiser_name, organiser.id AS organiser_id, ".
						"  members.nick_name AS member_nickname, members.id AS member_id ".
						" FROM `".DBTB::GetTB('GLOBAL','POKER_SESSIONS')."` AS sessions ".
						" LEFT JOIN `".DBTB::GetTB('GLOBAL','EGL_MEMBERS')."` AS members".
						" ON members.id=sessions.member_id ".
						" LEFT JOIN `".DBTB::GetTB('GLOBAL','POKER_ORGANISER')."` AS organiser ".
						" ON organiser.id=sessions.organiser_id ";
		return $this->pDBInterface->FetchArrayObject( $this->pDBInterface->Query( $sql_query ) );
	}
	
	
	/**
	 * get sessions
	 * 
	 */
	function GetSession( $session_id ){
		$sql_query = 	" SELECT *,sessions.name, sessions.id AS session_id, sessions.city, sessions.plz, sessions.street, ".
						"  organiser.name AS organiser_name, organiser.id AS organiser_id, ".
						"  members.nick_name AS member_nickname, members.id AS member_id ".
						" FROM `".DBTB::GetTB('GLOBAL','POKER_SESSIONS')."` AS sessions ".
						" LEFT JOIN `".DBTB::GetTB('GLOBAL','EGL_MEMBERS')."` AS members".
						" ON members.id=sessions.member_id ".
						" LEFT JOIN `".DBTB::GetTB('GLOBAL','POKER_ORGANISER')."` AS organiser ".
						" ON organiser.id=sessions.organiser_id ".
						" WHERE sessions.id=".$session_id;
		return $this->pDBInterface->FetchObject( $this->pDBInterface->Query( $sql_query ) );
	}
	
		
	/**	
	 * register organiser
	 * 
	 * param array $object	field-list
	 */
	function RegisterSession( $object )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBInterface->CreateInsertQuery( DBTB:: GetTB( 'GLOBAL', 'POKER_SESSIONS' ), $object );
		$qre = $this->pDBInterface->Query( $sql_query );
		if( $qre ) return $this->pDBInterface->InsertId();
		return -1;
	}
	
	/**
	 * get session players
	 * 
	 */
	function GetSessionParticipants( $session_id ){
		$sql_query 	= 	" SELECT members.* ".
						" FROM `".DBTB::GetTB('GLOBAL','POKER_SESSION_PARTICIPANTS')."` AS sess_parts ".
						" LEFT JOIN `".DBTB::GetTB('GLOBAL','EGL_MEMBERS')."` AS members " .
						" ON members.id=sess_parts.member_id ".
						" WHERE sess_parts.session_id=".(int)$session_id."";
		return $this->pDBInterface->FetchArrayObject( $this->pDBInterface->Query( $sql_query ) );
	}
	
	
	/**	 * CreatePokerSessionParticipant
	 * 
	 */
	function CreatePokerSessionParticipant( $object ){
		$sql_query = $this->pDBInterface->CreateInsertQuery( DBTB:: GetTB( 'GLOBAL', 'POKER_SESSION_PARTICIPANTS' ), $object );
		$qre = $this->pDBInterface->Query( $sql_query );
		if( $qre ) return $this->pDBInterface->InsertId();
	}
	
	
	/**
	 * GetSessionParticipant
	 * 
	 */
	function GetSessionParticipant( $session_id, $member_id ){
		$sql_query 	= 	" SELECT * ".
						" FROM `".DBTB::GetTB('GLOBAL','POKER_SESSION_PARTICIPANTS')."` AS sess_parts ".
						" WHERE sess_parts.session_id=".(int)$session_id." && member_id=".(int)$member_id."";
		return $this->pDBInterface->FetchArrayObject( $this->pDBInterface->Query( $sql_query ) );
	}
	
};
?>