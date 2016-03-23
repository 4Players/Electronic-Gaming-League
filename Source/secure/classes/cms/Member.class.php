<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-

define( "ACCTYPE_MEMBER",		2 );		# 'member'
define( "ACCTYPE_CLAN",			4 );		# 'clan'

#define( "ACCTYPE_1ON1_JOIN",	16 );		# => KEIN ACCOUNT - wird in member account angezeigt
#define( "ACCTYPE_TEAM_JOIN",	32 );		# => KEIN ACCOUNT - wird im clan angezeigt 



# -[ obj.s ] -

class memb_account_t
{
	var $id		= -1;
	var $type	= 'unknown';
	var $data	= NULL;
};



# -[ class ] -
class Member
{
	# -[ variables ]-
	var $pDBInterfaceCon			= NULL;
	var $Id					= -1;
	var $bIsAdmin			= false;
	var $MemberData			= NULL;
	var $aAdminPermissions	= array();
	var $oAdminData			= NULL;
	var $aClans				= array();
	var $aTeams				= array();
	var $cPM				= NULL;
	var $cClan				= NULL;
	var $cTeam				= NULL;
	var $bBuffersFilled		= false;
	
	
	# -[ functions ]-
	
	# =========================================================================
	# PUBLIC
	# =========================================================================

	//-------------------------------------------------------------------------------
	// Purpose: constructor
	//-------------------------------------------------------------------------------
	function Member ( &$pDBInterfaceCon )
	{
		$this->pDBInterfaceCon = &$pDBInterfaceCon;
		$this->cClan = new Clan( $this->pDBInterfaceCon );
		$this->cTeam = new Team( $this->pDBInterfaceCon );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: set current member_id
	// Output : true/false
	//-------------------------------------------------------------------------------
	function SetId( $member_id )
	{
		return ($this->Id = $member_id);
	}
	
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: gets memberdata
	// Output : true/false
	//-------------------------------------------------------------------------------
	function FillMemberBuffers()
	{
	
		if( !($this->Id) ) return false;

		# fetch / get memberdata
		$this->MemberData = $this->GetMemberDataById( $this->Id );
			
		# no member found ?
		if( !$this->MemberData )
		{
			return false;
		}
		
		# pm messages
		$this->cPM = new PM( $this->pDBInterfaceCon );
		$this->cPM->SetId( $this->Id );
		
		$this->bBuffersFilled = true;
		
		return true;	
		
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: gets admin & member data
	// Output : true/false
	//-------------------------------------------------------------------------------
	function FillBaseBuffers()
	{
	
		if( !($this->Id) ) return false;

		# fetch / get memberdata
		#$this->MemberData = $this->GetMemberDataById( $this->Id );
		$this->GetMemberAdminDataById( 	$this->Id, 			// member-ID
										$this->MemberData, 	// member-BUFFER
										$this->oAdminData 	// admin-BUFFER
									);
									
		
		# admin?
		if( $this->oAdminData )
		{
			$this->aAdminPermissions = $this->GetDBAdminPermissions( $this->oAdminData->id/*ADMIN-ID*/ );
			$bIsAdmin = true;
		}
		
		# no member found ?
		if( !$this->MemberData )
		{
			return false;
		}
		
		# pm messages
		$this->cPM = new PM( $this->pDBInterfaceCon );
		$this->cPM->SetId( $this->Id );
		
	
		$this->bBuffersFilled = true;
		
		return true;
	}
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------
	function FillClanBuffers()
	{
		$this->cClan->SetId( $this->Id );
		$this->cClan->FillBuffers();
		# cClan team structure
		
		
		return true;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------
	function FillTeamBuffers()
	{
		$this->cTeam->SetId( $this->Id );
		$this->cTeam->FillBuffers();
		# cClan team structure
		
		return true;
		
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: fill message buffer
	// Output : true/false
	//-------------------------------------------------------------------------------
	function FillMessageBuffer( $bInput=false, $bOutput=false )
	{
		if( $this->cPM )
		{
			# fill buffers
			return ($this->cPM->FillBuffers( $bInput, $bOutput ));
		}
		return false;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: return input/output messages
	// Output : pm_messages_t object
	//-------------------------------------------------------------------------------	
	function GetMessages( $type=NULL )
	{
		$obj = & new pm_messages_t;
		$obj->MemberId 		= $this->Id;
		
		if( $type == NULL )
		{
			$obj->aInput		= $this->cPM->GetInput();
			$obj->aOutput 		= $this->cPM->GetOutput();
		}
		else
		{
			if( $type == 'input' )
			{
				$obj->aInput		= $this->cPM->GetInput();
			}
			if( $type == 'output' )
			{
				$obj->aOutput		= $this->cPM->GetOutput();
			}
		}
		
		return $obj;
	}
	
	//-------------------------------------------------------------------------------
	// function links
	//-------------------------------------------------------------------------------
	
	function GetUnreadMessages(){ if( $this->cPM ) return $this->cPM->GetUnreadMessages();}
	function GetMessage($id){ if( $this->cPM ) return $this->cPM->GetMessage( $id ); }
	function ChangeMessage($obj,$id) { if( $this->cPM ) return  $this->cPM->ChangeMessage($obj,$id); }
	function CreatePM($obj) { if( $this->cPM ) return  $this->cPM->CreateMessage($obj); }
	/*
	ACHTUNG
	*/
	function GetClanAccount($id) { if( $this->cClan ) return  $this->cClan->GetAccount($id); } 
	function GetClanAccounts() { if( $this->cClan ) return  $this->cClan->GetAccounts();}
	#function GetClanAccounts() { if( $this->cTeam ) return  $this->cClan->GetAccounts();}
	function GetTeamAccount($id) { if( $this->cClan ) return  $this->cTeam->GetAccount($id);}
	function GetTeamAccounts() { if ($this->cTeam) return $this->cTeam->GetAccounts(); }
	
	
	
	#function GetClanTeams( $clan_id ) { if( $this->cClan ) return  $this->cClan->GetTeams($clan_id); } 
	#function GetClanTeam( $team_id ) { if( $this->cClan ) return  $this->cClan->GetTeam($team_id); } 
	#function GetClanTeamClan( $team_id ) { if( $this->cClan ) return  $this->cClan->GetTeamClan($team_id); } 
	#function GetClanTeamMembers( $team_id ) { if( $this->cClan ) return  $this->cClan->GetTeamMembers($team_id); } 
	#function GetClanTeamPermissions( $member_id,  $team_id ) { if( $this->cClan ) return  $this->cClan->GetTeamPermissions( $member_id, $team_id ); }
	
	
	
	function GetClanlistData( $id_list ) { if( $this->cClan ) return $this->cClan->__GetClanlistData( $id_list ); }
	function GetAdminPermissions() { return $this->aAdminPermissions; }
	function GetAdminData() { return $this->oAdminData; }
	function SetClanData($obj,$clan_id) { if( $this->cClan ) return  $this->cClan->SetClanData($obj, $clan_id); } 
	
	
	#function SetTeamData($obj,$team_id){ if( $this->cClan ) return  $this->cClan->SetTeamData( $obj, $team_id ); } 
	//..
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: set current member_id
	// Output : true/false
	//-------------------------------------------------------------------------------
	function CreateAccountList()
	{
		$aAccounts = array();
		
		# def
		$acc_t	= & new memb_account_t;
		
		$acc_t->data = $this->GetData();
		$acc_t->type = 'member';
		
	
		$aAccounts[sizeof($aAccounts)] = $acc_t;
		
		# CLANS 
		# set up clan-accounts
		$aClanAccounts = $this->cClan->GetAccounts();
		for( $i=0; $i < sizeof($aClanAccounts); $i++ )
		{
			$acc_t	= & new memb_account_t;
			$acc_t->data = $aClanAccounts[$i];
			$acc_t->type = 'clan';
	
			# save
			$aAccounts[sizeof($aAccounts)] = $acc_t;
		}
		
		
		# TEAMS
		$aTeamAccouns = $this->cTeam->GetAccounts();
		for( $i=0; $i < sizeof($aTeamAccouns); $i++ )
		{
			$acc_t	= & new memb_account_t;
			$acc_t->data = $aTeamAccouns[$i];
			$acc_t->type = 'team';

			# save
			$aAccounts[sizeof($aAccounts)] = $acc_t;
		}
		return $aAccounts;
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: set current member_id
	//-------------------------------------------------------------------------------
	function IsInAccountList( $participant, $parttype, &$pMyPart )
	{
		if( $parttype == PARTTYPE_MEMBER )
		{
			if( $participant->participant_id == $this->Id )
			{
				# save to myself
				$pMyPart = $participant;
				return true;	
			}
			
		}//if
		else if( $parttype == PARTTYPE_TEAM )
		{
			# is member currently joined ?
			$is_joined = (int)$this->cTeam->GetNumTeamJoins( $this->Id,  #own memberid
															 $participant->participant_id # own clan/team id
															);
			if( $is_joined ) 
			{
				
				# save to myself
				$pMyPart = $participant;
				return true;
			}
			return false;
		}//if
	}//IsInAccountlist
	
	//-------------------------------------------------------------------------------
	// Purpose: set current member_id
	//-------------------------------------------------------------------------------
	function & GetData()
	{
		# check whether the buffers are already filled ??
		if( !$this->bBuffersFilled ) $this->MemberData = $this->GetMemberDataById( $this->Id );
		return $this->MemberData;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: get memberdata by  member_id  (EXTERN)
	//-------------------------------------------------------------------------------
	function GetMemberDataById( $id )
	{
		if( !($id) ) return false;
		
		# set search values
		$obj 		= NULL;
		$obj->id 	= $id;
		
		# read member informations
		$member_data	= $this->pDBInterfaceCon->FetchObject( 
								$this->pDBInterfaceCon->Query( 
										$this->pDBInterfaceCon->CreateSelectQuery( $GLOBALS['g_egltb_members'], $obj, true 
														) # create query
															)  # execute query
																); # fetch object from result
		return $member_data;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function GetMemberBanDataById( $id )
	{
		$sql_query = " SELECT members.*, banlist.start_time AS ban_starttime, banlist.end_time AS ban_endtime ".
					 " FROM `{$GLOBALS['g_egltb_members']}` AS members ".
					 " LEFT JOIN `{$GLOBALS['g_egltb_banlist']}` AS banlist ".
					 " ON members.id=banlist.member_id ".
					 " WHERE members.id={$id} ";
					 
		$member_data	= $this->pDBInterfaceCon->FetchObject(  $this->pDBInterfaceCon->Query( $sql_query ));
		return $member_data;
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: get memberdata by  nick_name  (EXTERN)
	//-------------------------------------------------------------------------------
	function GetMemberDataByNickname( $name )
	{
		if( !($id) ) return false;
		
		# set search values
		$obj 				= NULL;
		$obj->nick_name 	= $name;
		
		# read member informations
		$member_data	= $this->pDBInterfaceCon->FetchObject( 
								$this->pDBInterfaceCon->Query( 
										$this->pDBInterfaceCon->CreateSelectQuery( $GLOBALS['g_egltb_members'], $obj, true 
														) # create query
															)  # execute query
																); # fetch object from result
		return $member_data;
	}
	

	
	//-------------------------------------------------------------------------------
	// Purpose: get memberdata by  member_id  (EXTERN)
	//-------------------------------------------------------------------------------
	function GetMemberAdminDataById( $member_id, &$pMemberData, &$pAdminData )
	{
		
		$sql_query = 	" SELECT members.*, admins.id AS admin_id, admins.member_id AS admin_member_id, admins.created AS admin_created ".
						" FROM `".$GLOBALS['g_egltb_members']."` AS members ".
						" LEFT JOIN `".$GLOBALS['g_egltb_admins']."` AS admins ".
						" ON members.id=admins.member_id ".
						" WHERE members.id={$member_id} ";
		
		# read member informations
		$oResultData = $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
		
		if( !$oResultData )
		{
			# ERROR
			return 0;
		}

		# save memberdata
		$pMemberData = $oResultData;
		
		# AdMIN
		if( (int)$oResultData->admin_id != 0 )
		{
			# save admindata
			$pAdminData->id 			= $oResultData->admin_id;
			$pAdminData->member_id		= $oResultData->admin_member_id;
			$pAdminData->created	 	= $oResultData->admin_created;
		}
		else
		{
			$pAdminData=NULL;
		}
		
		// wichtig, an dieser stelle
		unset( $pMemberData->admin_id );
		unset( $pMemberData->admin_member_id );
		unset( $pMemberData->admin_created );
		

		return 1;
	}
	
	

	
	//-------------------------------------------------------------------------------
	// Purpose: get memberdata by  member_id  (EXTERN)
	//-------------------------------------------------------------------------------
	function GetDBAdminPermissions( $admin_id )
	{
		
		$sql_query = 	" SELECT * ".
						" FROM `".$GLOBALS['g_egltb_admin_permissions']."` AS admin_permissions ".
						" WHERE admin_id={$admin_id} ";
		
		# read member informations
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: update profil
	//-------------------------------------------------------------------------------
	/*function UpdateProfil( $new_profil )
	{
		return ($this->MemberData = SetObjectVars( $this->MemberData, $new_profil ));
	}*/
	
	
	// =====================================================================================================
	// G L O B A L 
	// =====================================================================================================
	
	
	//-------------------------------------------------------------------------------
	// Purpose: check whether a member is currently exists
	// Output : true/false
	//-------------------------------------------------------------------------------
	function MemberExists( $obj )
	{
		# execute query
		$qre = $this->pDBInterfaceCon->Query( $this->pDBInterfaceCon->CreateSelectQuery( $GLOBALS['g_egltb_members'], $obj, NULL, true ) );
		if( !$qre ) return NULL;
		return ($this->pDBInterfaceCon->FetchObject($qre));
	}
	
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	function GetMemberData( $obj )
	{
		# execute query
		$qre = $this->pDBInterfaceCon->Query( $this->pDBInterfaceCon->CreateSelectQuery( $GLOBALS['g_egltb_members'], $obj, true, true ) );
		if( !$qre ) return NULL;
		return ($this->pDBInterfaceCon->FetchObject($qre));
	}
	
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	function SetMemberData( $obj )
	{
		# execute query
		return $this->pDBInterfaceCon->Query( $this->pDBInterfaceCon->CreateUpdateQuery(  $GLOBALS['g_egltb_members'], $obj ) . " WHERE id=".$this->Id );
	}
	
	
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	function SetMemberDataById( $obj, $id )
	{
		# execute query
		return $this->pDBInterfaceCon->Query( $this->pDBInterfaceCon->CreateUpdateQuery(  $GLOBALS['g_egltb_members'], $obj ) . " WHERE id=".(int)$id );
	}
	
	
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	function GetMemberIdByName( $name )
	{
		$sql_query = "SELECT mem_tb.id,mem_tb.nick_name FROM `".$GLOBALS['g_egltb_members']."` AS mem_tb WHERE nick_name='".$name."'";
		$qre = $this->pDBInterfaceCon->Query( $sql_query );
		if( !$qre ) return NULL;
		return ($this->pDBInterfaceCon->FetchObject($qre));
	}
	
	
	//-------------------------------------------------------------------------------
	// return membercount of overgiven data, comparing ...
	//-------------------------------------------------------------------------------
	function GetMemberCount( $obj, $b_or=false )
	{
		$sql_query = $this->pDBInterfaceCon->CreateSelectQuery( $GLOBALS['g_egltb_members'], $obj, NULL, $b_or, NULL, true);
		$qre = $this->pDBInterfaceCon->Query( $sql_query );
		if( !$qre ) return NULL;
		$data = ($this->pDBInterfaceCon->FetchObject($qre));
		return $data->row_count;	# rreturn count
	}

	
	//-------------------------------------------------------------------------------
	// Purpose: signin a member
	// Output : true/false
	//-------------------------------------------------------------------------------
	function Signin ( $object )
	{
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBInterfaceCon->CreateInsertQuery( $GLOBALS['g_egltb_members'], $object );
		return ($this->pDBInterfaceCon->Query( $sql_query ) );
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: signout a member
	// Output : true/false
	//-------------------------------------------------------------------------------
	function Signout( $id )
	{
		$sql_query = "DELETE FROM `". $GLOBALS['g_egltb_members']."` WHERE id=".(int)$id;
		return ($this->pDBInterfaceCon->Query( $sql_query ) );
	}


	# =========================================================================
	# PRIVATE
	# =========================================================================
	
	//...	
	
	# =========================================================================
	# STATIC PUBLIC
	# =========================================================================
	
	
	
	
	#-----------------------------------------
	# Purpose: 
	#-----------------------------------------
	function __GetMemberListData( $id_list )
	{
		$sql_query = 	" SELECT country.name AS country_name, country.image_file AS country_image_file, memb.nick_name AS participant_name, memb.id AS participant_id, memb.logo_file AS participant_logo_file, memb.photo_file AS participant_photo_file ".
						" FROM `".$GLOBALS['g_egltb_members']."` AS memb ".
						" LEFT JOIN `".$GLOBALS['g_egltb_countries']."` AS country ".
						" ON memb.country_id=country.id ".
						" WHERE FIND_IN_SET( memb.id, '$id_list') ";
						#" ORDER BY memb.id ";
						
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ));
		
	}
	

	
	#-----------------------------------------
	# Purpose: 
	#-----------------------------------------
	function __GetMemberNickName( $id )
	{
		$sql_query = "SELECT nick_name FROM `". $GLOBALS['g_egltb_members']."` WHERE id=$id";
		$obj = $this->pDBInterfaceCon->FetchObject(  $this->pDBInterfaceCon->Query( $sql_query ) );
		
		if( $obj )
		{
			return $obj->nick_name;
		}
		return 0;
	}
	

	
	
	#-----------------------------------------
	# Purpose:  gets detailed member informations (country,..)
	#-----------------------------------------
	function GetMemberInfoAsParttype( $member_id )
	{
		$sql_query 	= 	" SELECT country.name AS country_name, country.image_file AS country_image_file, memb.nick_name AS participant_name, memb.id AS participant_id, memb.logo_file AS participant_logo_file, memb.photo_file AS participant_photo_file ".
						" FROM `".$GLOBALS['g_egltb_members']."` AS memb ".
						" LEFT JOIN `".$GLOBALS['g_egltb_countries']."` AS country ".
						" ON memb.country_id=country.id ".
						" WHERE memb.id=$member_id ";
		return $this->pDBInterfaceCon->FetchObject($this->pDBInterfaceCon->Query( $sql_query ));
	}

	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: return the counter of registered members
	//-------------------------------------------------------------------------------
	function GetNumMembers()
	{
		$sql_query = 	" SELECT COUNT(*) AS num_members ".
						" FROM `".$GLOBALS['g_egltb_members']."` AS members".
						" ";
		$object = $this->pDBInterfaceCon->FetchObject($this->pDBInterfaceCon->Query( $sql_query ));
		return $object->num_members;
	}	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: return a list of all registered members
	//-------------------------------------------------------------------------------
	function GetMemberlist($WHERE='',$ORDER='', $ORDER_TYPE='' )
	{
		if( strlen($ORDER) > 0 ) $ORDER = " ORDER BY {$ORDER}";
		$sql_query 	=	" SELECT * FROM `".$GLOBALS['g_egltb_members']."` AS members ".
						" {$WHERE} " .
						" {$ORDER} {$ORDER_TYPE} ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query($sql_query));
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: return a list of members from db
	//-------------------------------------------------------------------------------
	function GetLimitedMemberlist( $limit_start, $limit_cnt, $ORDER='', $ORDER_TYPE='' )
	{
		if( strlen($ORDER) > 0 ) $ORDER = " ORDER BY {$ORDER}";
		$sql_query 	=	" SELECT members.*, country.image_file AS country_image_file, country.name AS country_name, members.photo_file, members.logo_file ".
						" FROM `".$GLOBALS['g_egltb_members']."` AS members ".
						" LEFT JOIN `".$GLOBALS['g_egltb_countries']."` AS country ".
						" ON members.country_id=country.id ".
						" {$ORDER} {$ORDER_TYPE}".	
						" LIMIT {$limit_start},{$limit_cnt} ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query($sql_query));
	}
	
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: return a email-list from member DB
	//-------------------------------------------------------------------------------
	function GetMailingList()
	{
		$sql_query 	= " SELECT email FROM `{$GLOBALS['g_egltb_members']}` AS members ".
					  "";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query($sql_query));
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: return a email-list from member DB
	//-------------------------------------------------------------------------------
	function UnlockMember( $member_id ){
		/*
			Sperre wieder aufgehoben => aufheben
		*/
		$cMember = new Member( $this->pDBInterfaceCon );
		if( $cMember->SetMemberDataById( array( "banned" => 0,
												"ban_start" => 0,
												"ban_end" => 0 ), 
												$member_id ))
		{
			return true;
		}//if
		else return false;
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function RefreshBanStatus( $MemberObj ){
		if( !isset($MemberObj) ) return false;
		
		
		#-------------------------------------------------------------
		# check => member locked??
		#-------------------------------------------------------------
		if( $MemberObj->banned )
		{
			if( ($MemberObj->ban_end-EGL_TIME) > 0 )
			{
				/*
				$login_try_obj->nickname 	= $MemberObj->nick_name;
				$login_try_obj->member_id 	= $MemberObj->id;
				$login_try_obj->result 		= LOGIN_MEMBER_LOCKED;
				return $login_try_obj;*/
				return false;
			}//if
			else
			{
				/*
					Sperre wieder aufgehoben => aufheben
				*/
				//$cMember = new Member( $this->pDBInterfaceCon );
				$this->SetMemberDataById( array( 	"banned" 		=> 0,
													"ban_start" 	=> 0,
													"ban_end" 		=> 0 ), 
										 $MemberObj->id );
				return true;
			}//if
		}//if
		return false;	
	}
	
	
};

?>