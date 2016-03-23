<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



define( "LOGIN_MEMBER_LOCKED",			10 );

define( "LOGIN_TRY_FAILED",				20 );
define( "LOGIN_TRY_SUCCESSED",			21 );
define( "LOGIN_MEMBER_NOT_ACTIVATED",	22 );

define( "LOGIN_ACCESS_TIMEOUT",			50 );
define( "LOGIN_ACCESS_SESSID_FAILED",	60 );
define( "LOGIN_ACCESS_OK",				70 );



# -[ object ]-
class onlinelist_item_t
{
	var $id				= E_NULL;
	var $member_id		= E_NULL;
	var $last_action	= E_NULL;
	var $session_id		= E_NULL;
};

# -[ object ]-
class login_try_t
{
	var $result		=0;
	var $member_id	=0;
	var $nickname	=0;
};



# -[ class ] -
class Login
{
	# -[ variables ]-
	var $pDBInterfaceCon	= NULL;
	
	
	# -[ functions ]-
	
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	function Login ( &$pDBInterfaceCon )
	{
		$this->pDBInterfaceCon = &$pDBInterfaceCon;
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: try to login
	// Output : 0-not found / 1-no access to login/ else return user_id
	//-------------------------------------------------------------------------------
	function TryLogin( $login_id, $password, $id_as_email=false )
	{
		if( !$this->pDBInterfaceCon)return 0;
	
		$login_try_obj = new login_try_t;
		$login_try_obj->result = LOGIN_TRY_FAILED;

		# prüfe Mysql-Verbindung
		if( !$this->pDBInterfaceCon->Connected() )
			return $login_try_obj;
		

		# define query
		$query = '';
		if( !$id_as_email ) 
			$query = "SELECT activation_time, banned, ban_start, ban_end, id, email, nick_name, password FROM `".$GLOBALS['g_egltb_members']."` WHERE id=".(int)$login_id." AND password=\"".md5($password)."\"";
		else 
			$query = "SELECT activation_time, banned, ban_start, ban_end, id, email, nick_name, password FROM `".$GLOBALS['g_egltb_members']."` WHERE email=\"".$this->pDBInterfaceCon->EscapeString($login_id)."\" AND password=\"".md5($password)."\"";
		$qre = $this->pDBInterfaceCon->Query( $query );
		if( !$qre ) return NULL;

		# get object
		$MemberObj = $this->pDBInterfaceCon->FetchObject(  $qre );
		if( !$MemberObj ) return $login_try_obj;

			
		#-------------------------------------------------------------
		# check => member locked??
		#-------------------------------------------------------------
		if( $MemberObj->banned )
		{
			if( ($MemberObj->ban_end-EGL_TIME) > 0 )
			{
				$login_try_obj->nickname 	= $MemberObj->nick_name;
				$login_try_obj->member_id 	= $MemberObj->id;
				$login_try_obj->result 		= LOGIN_MEMBER_LOCKED;

				return $login_try_obj;
			}//if
			else
			{
				/*
					Sperre wieder aufgehoben => aufheben
				*/
				$cMember = new Member( $this->pDBInterfaceCon );
				$cMember->SetMemberDataById( array( "banned" 		=> 0,
													"ban_start" 	=> 0,
													"ban_end"		=> 0 ), 
											 $MemberObj->id );
			}
			
			
		}//if
		#-------------------------------------------------------------
		# check => not activated?
		#-------------------------------------------------------------
		if( $MemberObj->activation_time == 0 )
		{
		
			$login_try_obj->nickname 	= $MemberObj->nick_name;
			$login_try_obj->member_id 	= $MemberObj->id;
			$login_try_obj->result 		= LOGIN_MEMBER_NOT_ACTIVATED;
			
			return $login_try_obj;
		}
		

		/*
		$this->Onlinelist_UpdateAll();*/
		
		# -----------------
		# Save session vars
		# -----------------
		
		# save id to session
		$_SESSION['member']['id'] = $MemberObj->id;
		
		# save cookies
		if( $_POST['login_cookies'] == 'yes' )
		{
			setcookie( "member[id]", $MemberObj->id, EGL_COOKIETIME );
			/*
				CHECK contains of md5 from $password and the addional member_id
			*/
			setcookie( "member[check]", md5($MemberObj->password.$MemberObj->id), EGL_COOKIETIME  );
		}
		
		// manager user
		if( $this->ManageUser( $MemberObj->id, Session::GetId(), EGL_TIME /*current time*/ ) )
		{
			$login_try_obj->nickname 	= $MemberObj->nick_name;
			$login_try_obj->member_id 	= $MemberObj->id;
			$login_try_obj->result 		= LOGIN_TRY_SUCCESSED;
			
			# set current login time
			$update_query = "UPDATE `".$GLOBALS['g_egltb_members']."` SET last_login=".EGL_TIME." WHERE id=".$MemberObj->id;
			$qre = $this->pDBInterfaceCon->Query( $update_query );
			if( !$qre ) return NULL;
			
			if( !$this->UpdateOnlineList( true ) )
			{
				DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Coudn't update onlinelist `Login::UpdateOnlineList`" );
			}

			# login successed
			return $login_try_obj;
		}
			
		# login failed
		return $login_try_obj;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function TryCookieLogin( $id, $check )
	{
		if( !$this->pDBInterfaceCon)return 0;

		$login_try_obj = new login_try_t;
		$login_try_obj->result = LOGIN_TRY_FAILED;

		# prüfe Mysql-Verbindung
		if( !$this->pDBInterfaceCon->Connected() )
			return $login_try_obj;
		
		# define query
		$query = "SELECT banned, ban_start, ban_end, id, nick_name, password FROM `".$GLOBALS['g_egltb_members']."` WHERE id=$id";
		$qre = $this->pDBInterfaceCon->Query( $query );
		if( !$qre ) return NULL;
		
		# get object
		$MemberObj = $this->pDBInterfaceCon->FetchObject(  $qre );
		if( !$MemberObj ) return $login_try_obj;
		
		#-------------------------------------------------------------
		# check => member locked??
		#-------------------------------------------------------------
		if( $MemberObj->banned )
		{
			if( ($MemberObj->ban_end-EGL_TIME) > 0 )
			{
				$login_try_obj->nickname 	= $MemberObj->nick_name;
				$login_try_obj->member_id 	= $MemberObj->id;
				$login_try_obj->result 		= LOGIN_MEMBER_LOCKED;
								
				return $login_try_obj;
			}//if
			else
			{
				/*
					Sperre wieder aufgehoben => aufheben
				*/
				$cMember = new Member( $this->pDBInterfaceCon );
				$cMember->SetMemberDataById( array( "banned" 		=> 0,
													"ban_start" 	=> 0,
													"ban_end"		=> 0 ), 
											 $MemberObj->id );
			}
			
			
		}//if


		# check md5 checksum
		if( md5($MemberObj->password.$MemberObj->id) == $check )
		{
			#$login_try_obj->result = LOGIN_TRY_SUCCESSED;	
			
			// manager user
			if( $this->ManageUser( $MemberObj->id, Session::GetId(), EGL_TIME /*current time*/ ) )
			{
				$login_try_obj->nickname 	= $MemberObj->nick_name;
				$login_try_obj->member_id 	= $MemberObj->id;
				$login_try_obj->result 		= LOGIN_TRY_SUCCESSED;
				
				
				# set current login time
				$update_query = "UPDATE `".$GLOBALS['g_egltb_members']."` SET last_login=".EGL_TIME." WHERE id=".(int)$MemberObj->id;
				$qre = $this->pDBInterfaceCon->Query( $update_query );
				if( !$qre ) return NULL;
				
				# login successed
				
				return $login_try_obj;
			}
			
		}// check md5
		
		return $login_try_obj;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function Logout( $member_id )
	{
		if( !$this->pDBInterfaceCon)return 0;
		# delete session
		#Session::Destroy();
		unset( $_SESSION['member'] );
		
		// remove user from onlinelist
		$this->RemoveUser( $member_id );
		
		$this->DeleteCookies();
		
		return false;		
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function DeleteCookies()
	{
		# destroy cookie
		setcookie( "member[id]", "", EGL_TIME - 3600 );
		setcookie( "member[check]", "", EGL_TIME - 3600 );
		
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function IsLogged( $member_id )
	{
		// prüfe ob der login access auf die member_id und session_id noch gegeben ist !
		return $this->Onlinelist_CheckLoginAccess( $member_id, Session::GetId() );
	}
	
	/*************************************************************************************************************/
	
	//-------------------------------------------------------------------------------
	// Purpose: Prüft ob die aktuelle Onlinelist Id noch aktuell ist/ oder der unaktive Zeitraum zu lange war
	// Output : return false, if user not accessed
	//-------------------------------------------------------------------------------
	function CheckLoginAccess( $member_id, $session_id, $page='' )
	{
		if( !$this->pDBInterfaceCon)return 0;
		global $gl_oVars;
		
		# prüfe Mysql-Verbindung
		if( !$this->pDBInterfaceCon->Connected() )
			return false;
			

		$query = "SELECT * FROM `".$GLOBALS['g_egltb_onlinelist']."` WHERE member_id=".(int)$member_id;
		if( !($qre = $this->pDBInterfaceCon->Query( $query )))
			return false;
		
		// eintrag gefunden ?
		$data = NULL;
		if( !($data = $this->pDBInterfaceCon->FetchObject( $qre ) ) )
			 return false;
		
		// prüfe ob die Zeit abgelaufen ist ? inaktivität, oder der user von einer weiteren person verwendet wird ?
		if( (EGL_TIME-$data->last_action) > ($gl_oVars->oConfigs->max_inactive_time ) ||  	#  update noch im zeitlichen Ramen ?
			$data->session_id != $session_id )												#  oder andere session_id in online-list ?
		{

			# delete / destroy session
			Session::Destroy();

			// kein anderer Benutzer online ! !?
			if( $data->session_id == $session_id  )
			{
				$this->RemoveUser( $member_id );
				return LOGIN_ACCESS_TIMEOUT;
			}
			else
			{
	
				// nicht mehr online, weil andere benutzer sich eingeloggt hat
				return LOGIN_ACCESS_SESSID_FAILED;
			}
		}
		else
		{ # alles in ordnung => update timestamp
			
			// update timestamp
			if( $this->UpdateUser( $member_id, NULL, EGL_TIME, $page ) )
				return LOGIN_ACCESS_OK;
		}
		
		return false;
	}
	

	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function ManageUser( $member_id, $session_id, $timestamp, $page='' )
	{
		if( !$this->pDBInterfaceCon)return 0;
		# prüfe Mysql-Verbindung
		if( !$this->pDBInterfaceCon->Connected() )
			return false;

			
		# prüfe ob user in der Onlineliste vorhanden ?
		$query = "SELECT * FROM `".$GLOBALS['g_egltb_onlinelist']."` WHERE member_id=".(int)$member_id;
		if( !($qre = $this->pDBInterfaceCon->Query( $query )))
		{
			return false;
		}
		
	
		
		// falls user nicht in der onlinelist vorhanden ?
		if( !($data = $this->pDBInterfaceCon->FetchObject( $qre ) ) )
		{
			// füge  neuen Eintrag in die Liste ein
			return  $this->AddUser( $member_id, $session_id, $timestamp );
		}
		// falls user in der onlinelist vorhanden
		else
		{
			// update eintrag !
			return $this->UpdateUser( $member_id, $session_id, $timestamp, $page );
		}
	}// function ManageUser
	

	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function AddUser( $member_id, $session_id, $timestamp)
	{
		if( !$this->pDBInterfaceCon)return 0;

		// definne + execute query
		$query = "INSERT INTO `".$GLOBALS['g_egltb_onlinelist']."` (member_id,session_id,last_action)VALUES('$member_id','$session_id','$timestamp') ";
		return $this->pDBInterfaceCon->Query( $query );
	}

	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function RemoveUser( $member_id )
	{
		if( !$this->pDBInterfaceCon)return 0;
		// execute query

		$query = "DELETE FROM `".$GLOBALS['g_egltb_onlinelist']."` WHERE member_id=".(int)$member_id;
		return $this->pDBInterfaceCon->Query( $query );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function UpdateUser( $member_id, $session_id, $timestamp, $page )
	{
		if( !$this->pDBInterfaceCon)return 0;
		if( $session_id == NULL &&  $timestamp == NULL  ) return false;
		
		$updates="";
		
		// prüfe welche daten geänder3t werden sollen
		if( $session_id != NULL )	$updates .= ",session_id='$session_id'";
		if( $timestamp != NULL )	$updates .= ",last_action='$timestamp'";
		if( $timestamp != NULL )	$updates .= ",last_page='$page'";
		
		// lösche überschuss
		$updates[0] = ' ';
		
		//echo $updates;
		
		// execute query
		$query = "UPDATE `".$GLOBALS['g_egltb_onlinelist']."` SET $updates WHERE member_id=".(int)$member_id;
		return $this->pDBInterfaceCon->Query( $query );
	}	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function UpdateOnlineList( $bOptimize=false )
	{
		if( !$this->pDBInterfaceCon)return 0;
		# prüfe Mysql-Verbindung
		if( !$this->pDBInterfaceCon->Connected() )
			return false;
			
		global $gl_oVars;

		$sql_query = "DELETE FROM `".$GLOBALS['g_egltb_onlinelist']."` WHERE (".EGL_TIME."-last_action) > ".(($gl_oVars->oConfigs->max_inactive_time));
		$qre = $this->pDBInterfaceCon->Query( $sql_query );
		
		// optimize onlinelist
		if( $bOptimize )
			$this->pDBInterfaceCon->Query( "OPTIMIZE TABLE `".$GLOBALS['g_egltb_onlinelist']."` " );
		
		return $qre;
	}
	
	/*************************************************************************************************************/
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function GetOnlineUserCount()
	{
		if( !$this->pDBInterfaceCon)return 0;
		# prüfe Mysql-Verbindung
		if( !$this->pDBInterfaceCon->Connected() )
			return false;
			
		$query = "SELECT COUNT(*) AS numOnlineUsers FROM `".$GLOBALS['g_egltb_onlinelist']."` ";
		$qre = $this->pDBInterfaceCon->Query( $query );
		if( !$qre ) return 0;
		$data = $this->pDBInterfaceCon->FetchObject($qre);
		return $data->numOnlineUsers;
	}	
	
};

?>