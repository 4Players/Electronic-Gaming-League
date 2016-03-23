<?php
# ================================ Copyright © 2004-2007 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


# -[ defines ]-


# -[ class ] -
class Polls
{
	# -[ variables ]-
	var $pDBCon	= NULL;			# pointer to current mysql object 
	
	# -[ functions ]-
	
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output :
	//-------------------------------------------------------------------------------
	function Polls ($pDBCon)
	{
		$this->pDBInterfaceCon = &$pDBCon;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: get polls
	// Output : object array
	//-------------------------------------------------------------------------------
	function GetPolls()
	{
		$sql_query = 	" SELECT polls.*, SUM(answers.hits) AS num_hits ".
						" FROM `".DBTB::GetTB( 'EGL_POLLS', 'POLLS')."` AS polls ".
						" LEFT JOIN `".DBTB::GetTB( 'EGL_POLLS', 'POLLS_ANSWERS')."` AS answers ".
						" ON answers.poll_id=polls.id ".
						" GROUP BY answers.poll_id ".
						" ORDER BY start_time DESC ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query($sql_query));
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: fetch detailed polls
	// Output : object array
	//-------------------------------------------------------------------------------
	function getDetailledPolls()
	{
		$sql_query = 	" SELECT polls.*, COUNT(poll_answers.poll_id) AS num_pollanswers".
						" FROM `".TB_POLLS."` AS polls ".
						" LEFT JOIN `".DBTB::GetTB( 'EGL_POLLS', 'POLLS_ANSWERS')."` AS poll_answers ".
						" ON polls.id=poll_answers.poll_id ".
						" GROUP BY poll_answers.poll_id ".
						" ORDER BY start_time DESC ";
						
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query($sql_query));
	}
	
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: fetch current poll
	// Output : according to $limit (1 => object, > 1 array)
	//-------------------------------------------------------------------------------
	function getCurrentPoll( $cat_id=-1, $limit=1 )
	{
		$sql_query = 	" SELECT polls.*, SUM(answers.hits) AS num_hits, members.nick_name AS member_nick_name ".
						" FROM `".TB_POLLS."` AS polls ".
						" LEFT JOIN `".DBTB::GetTB( 'EGL_POLLS', 'POLLS_ANSWERS')."` AS answers ".
						" ON answers.poll_id=polls.id ".
						" LEFT JOIN `{$GLOBALS['g_egltb_members']}` AS members ".
						" ON polls.member_id=members.id ".
						" WHERE polls.cat_id={$cat_id} && polls.start_time < ".EGL_TIME." && polls.end_time > ".EGL_TIME." && stopped=0 ".
						" GROUP BY answers.poll_id ".
						" ORDER BY polls.start_time DESC ".
						" LIMIT 0,{$limit} ";
		if( $limit > 1 )
			return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query));
		elseif( $limit == 1 )
			return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query($sql_query));
		else return  NULL;
	}
		
	
	/*
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------
	function getCategoryPoll( $cat_id=-1, $limit=100 )
	{
		$sql_query = 	" SELECT polls.* ".
						" FROM ".TB_POLLS." AS polls ".
						" WHERE cat_id={$cat_id}".
						" ORDER BY start_time DESC ".
						" LIMIT 0,$limit ";
						
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query($sql_query));
	}*/
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: delete answer
	// Output : true/false
	//-------------------------------------------------------------------------------
	function DeleteAnswer( $id )
	{
		$sql_query =" DELETE FROM `".DBTB::GetTB( 'EGL_POLLS', 'POLLS_ANSWERS')."` WHERE id={$id}";
		return $this->pDBInterfaceCon->Query($sql_query);
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: delete poll
	// Output : true/false
	//-------------------------------------------------------------------------------
	function DeletePoll( $id )
	{
		$sql_query =" DELETE FROM `".TB_POLLS."` WHERE id={$id}";
		return $this->pDBInterfaceCon->Query($sql_query);
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: delete poll answers (by poll-ID)
	// Output : true/false
	//-------------------------------------------------------------------------------
	function DeletePollAnswers( $poll_id )
	{
		$sql_query =" DELETE FROM `".DBTB::GetTB( 'EGL_POLLS', 'POLLS_ANSWERS')."` WHERE poll_id={$poll_id}";
		return $this->pDBInterfaceCon->Query($sql_query);
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: return active polls, not aviable!
	// Output : unknown
	//-------------------------------------------------------------------------------
	function GetActivePolls()
	{
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: get poll by id
	// Output : object
	//-------------------------------------------------------------------------------
	function GetPoll( $poll_id )
	{
		$sql_query = 	" SELECT * ".
						" FROM `".TB_POLLS."` AS polls ".
						" WHERE id=$poll_id";
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query($sql_query));	
			
	}	
	
	//-------------------------------------------------------------------------------
	// Purpose: get poll-answer (by Answer-ID)
	// Output : object
	//-------------------------------------------------------------------------------
	function GetPollAnswer( $answerid )
	{
		$sql_query = 	" SELECT * ".
						" FROM `".DBTB::GetTB( 'EGL_POLLS', 'POLLS_ANSWERS')."` ".
						" WHERE id=$answerid ";
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query($sql_query));	
			
	}
	

	//-------------------------------------------------------------------------------
	// Purpose: get poll-answers (by Poll-ID)
	// Output : array
	//-------------------------------------------------------------------------------
	function GetPollAnswers( $poll_id )
	{
		$sql_query = 	" SELECT * ".
						" FROM `".DBTB::GetTB( 'EGL_POLLS', 'POLLS_ANSWERS')."` AS answers ".
						" WHERE poll_id=$poll_id ".
						" ORDER BY answers.sub_index ASC";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query($sql_query));
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: fetch category polls (by cat-id)
	// Output : array
	//-------------------------------------------------------------------------------
	function GetCategoryPolls( $cat_id, $limit=100 )
	{
		$cat_id = (int)$cat_id;
		$sql_query = 	" SELECT polls.*, SUM(answers.hits) AS num_hits, members.nick_name AS member_nick_name ".
						" FROM `".TB_POLLS."` AS polls ".
						" LEFT JOIN `".DBTB::GetTB( 'EGL_POLLS', 'POLLS_ANSWERS')."` AS answers ".
						" ON answers.poll_id=polls.id ".
						" LEFT JOIN `{$GLOBALS['g_egltb_members']}` AS members ".
						" ON polls.member_id=members.id ".
						" WHERE polls.cat_id={$cat_id} ".
						" GROUP BY answers.poll_id ".
						" ORDER BY polls.start_time DESC ".
						" LIMIT 0,{$limit} ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query));
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: fetch category administrator
	// Output : array
	//-------------------------------------------------------------------------------
	function GetCategoryAdministrator( $cat_id )
	{
		$sql_query =" SELECT permissions.id, permissions.permissions, permissions.cat_id, permissions.admin_id, permissions.data, permissions.created,
					  		 members.id AS member_id, members.nick_name, members.email ".
					" FROM `{$GLOBALS['g_egltb_admin_permissions']}` AS permissions ".
					" LEFT JOIN `{$GLOBALS['g_egltb_admins']}` AS admins ".
					" ON admins.id=permissions.admin_id ".
					" LEFT JOIN `{$GLOBALS['g_egltb_members']}` AS members ".
					" ON admins.member_id=members.id".
					" WHERE permissions.data='{$cat_id}' && permissions.module_id='".MODULEID_INETOPIA_POLLS."' ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );		
		
	}
	
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: do poll-hit (by Answer-ID)
	// Output : true/false
	//-------------------------------------------------------------------------------
	function HitPoll_answer( $anwser_id )
	{
		$sql_query = "UPDATE `".DBTB::GetTB( 'EGL_POLLS', 'POLLS_ANSWERS')."` SET hits=hits+1 WHERE id=$anwser_id";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: save voting
	// Output : true/false
	//-------------------------------------------------------------------------------
	function SaveVote( $poll_id, $answer_id, $ip_address, $member_id )
	{
		$data = array( 	'poll_id' 	=> $poll_id,
						'ip' 		=> $ip_address,
						'member_id' => $member_id,
						'answer_id' => $answer_id,
						'created'	=> EGL_TIME,
					);
		return $this->pDBInterfaceCon->Query( $this->pDBInterfaceCon->CreateInsertQuery( TB_POLLS_VOTES, $data ));
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: check voting (IP) (currently voted)
	// Output : array - list of votes (1)
	//-------------------------------------------------------------------------------
	function AlreadyVoted_IP( $poll_id, $ip_address )
	{
		$sql_query = "SELECT * FROM `".DBTB::GetTB( 'EGL_POLLS', 'POLLS_VOTES')."` WHERE poll_id=$poll_id && ip='$ip_address'";
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query($sql_query) );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: check voting (MEMBER-ID) (currently voted)
	// Output : array - list of votes (1)
	//-------------------------------------------------------------------------------
	function AlreadyVoted_MEMBERID( $poll_id, $member_id )
	{
		$sql_query = "SELECT * FROM `".DBTB::GetTB( 'EGL_POLLS', 'POLLS_VOTES')."` WHERE poll_id=$poll_id && member_id='$member_id'";
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query($sql_query) );
	}	
};

?>