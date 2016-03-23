<?php
# ================================ Copyright © 2004-2007 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================

// require_once( EGL_PUBLIC . 'workspace.init.php' );

class HpRuntime extends RuntimeEngine 
{
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------	
	function InitDatabase()
	{
		return $this->SetDatabaseConnectingData( new db_connecting_data() /*standard connection data*/ );
	}

	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------
	function CreateStatistics()
	{
		global $gl_oVars;
		
		
		$cMatches 				= new Match( $gl_oVars->cDBInterface, NULL );
		$cClans 				= new Clan( $gl_oVars->cDBInterface );
		
		$gl_oVars->oStatictics	= new egl_statistics_t;
		
		# set statisitcs
		$gl_oVars->oStatictics->num_members = $gl_oVars->cMember->GetNumMembers();
		$gl_oVars->oStatictics->num_matches = $cMatches->GetNumMatches();
		$gl_oVars->oStatictics->num_clans 	= $cClans->GetNumClans();
		$gl_oVars->oStatictics->num_teams 	= $cClans->GetNumTeams();
		$gl_oVars->oStatictics->num_online 	= $gl_oVars->cLogin->GetOnlineUserCount();
		
		# provid the template with statisctic data
		$gl_oVars->cTpl->assign( 'statistics', $gl_oVars->oStatictics );
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------
	function EvaluateLoginstate()
	{
		global $gl_oVars;
		
		#==========================================
		# Login - check
		#==========================================
		$bCheckCookieLogin = false;
		
		if( Isset( $_SESSION['member']['id'] ) )
		{
			if( $gl_oVars->bModuleURLAttempt ){
				$current_page = $gl_oVars->sModuleId.':'.$gl_oVars->sURLPage;
			}else{
				$current_page = $gl_oVars->sURLPage;
			}
		
			# check login access ? !!	
			$check_result = $gl_oVars->cLogin->CheckLoginAccess( $_SESSION['member']['id'], Session::GetId(), $current_page  );
			if( $check_result == LOGIN_ACCESS_OK )
			{
				$gl_oVars->bLoggedIn = true;
				$gl_oVars->iMemberId = $_SESSION['member']['id'];

			}#if login access
			else if( LOGIN_ACCESS_TIMEOUT )		# LOGIN_ACCESS_SESSID_FAILED
			{
				# login_check failed
				
				 # ONLY FOR TIMEOUTS
				$bCheckCookieLogin = true;
			}//if
		}
		else
		{
			#echo "Not logged";
			
			$bCheckCookieLogin = true;
		} //if $_SESSION['member']['id']
		
		
		
		if( $bCheckCookieLogin )
		{
			# ------------------------------------------------
			# check cookie
			# ------------------------------------------------
			if( isset( $_COOKIE['member']['id'] ) )
			{
				#
				#		COOKIE DATA FOUND => try login
				#		data: id, check_sum
				#
				$login_obj = $gl_oVars->cLogin->TryCookieLogin( $_COOKIE['member']['id'], $_COOKIE['member']['check'] );
				if( $login_obj->result == LOGIN_TRY_SUCCESSED )
				{
					# LOGIN
					$gl_oVars->bLoggedIn = true;
					$gl_oVars->iMemberId = $_SESSION['member']['id'] = $_COOKIE['member']['id'];
					
				} // if login Access
				
			}//if isset $_COOKIE 'member[id]'
		
		}#

		return 1;
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------
	function InitPage()
	{
		global $gl_oVars;
		
	
		
		#==========================================
		# loggedin ??
		#==========================================		
		if( $gl_oVars->bLoggedIn )
		{
			$gl_oVars->cMember->SetId( $gl_oVars->iMemberId );
			if( !$gl_oVars->cMember->FillBaseBuffers() ||
				!$gl_oVars->cMember->FillClanBuffers() ||
				!$gl_oVars->cMember->FillTeamBuffers())
			{
				
				$gl_oVars->bLoggedIn = false;
				unset( $_SESSION['member']['id'] );
				return 0;
			}
				
			
			# fetch memberdata
			$gl_oVars->oMemberData = &$gl_oVars->cMember->GetData();
			
			# selected manuel saved language
			if( isset($gl_oVars->oMemberData->language) && strlen($gl_oVars->oMemberData->language) > 0){
				$this->SelectLanguage( $gl_oVars->oMemberData->language );
			}//if
			
			#----------------------------------------------------------
			# account locked??
			#----------------------------------------------------------
			if( $gl_oVars->oMemberData->banned )
			{
				# on lock => lockout
				if( ($gl_oVars->oMemberData->ban_end-EGL_TIME) > 0 )
				{
					$gl_oVars->cLogin->Logout( $gl_oVars->oMemberData->id );
					$gl_oVars->bLoggedIn = false;
					unset( $_SESSION['member']['id'] );
					return 1;
				}//if
				
				# on unlock => unlock member => save to DB
				else 
				{
					$gl_oVars->cMember->SetMemberData( array(	"banned" 		=> 0,
																"ban_start" 	=> 0,
																"ban_end" 		=> 0, ) 
																);				
				}//if
			}//if
			
				
			# fetch admin(data)permissions
			$aAdminPerms 	= $gl_oVars->cMember->GetAdminPermissions();
			$_aAdminPerms 	= array();
			
			
			// admin permissions available??
			if( sizeof($aAdminPerms))
			{
				for( $i=0; $i < sizeof($aAdminPerms); $i++ )
					$_aAdminPerms[sizeof($_aAdminPerms)] = $aAdminPerms[$i]->permissions;
			}
			# provide template with admin_permissions
			$gl_oVars->cTpl->assign( 'admin_permissions', $_aAdminPerms );
			
				
			# provid the smarty engine with memberdata
			$gl_oVars->cTpl->assign( 'member', $gl_oVars->oMemberData );
				
							
			# set global vars
			$gl_oVars->aMemberAccounts = array();
	
			# account data
			$gl_oVars->aMemberAccounts = $gl_oVars->cMember->CreateAccountList();
			
			# get unread messages
			$gl_oVars->cTpl->assign( 'pm_unread_count', (int)$gl_oVars->cMember->GetUnreadMessages() );
			$gl_oVars->cTpl->assign( 'memb_accounts', 	$gl_oVars->aMemberAccounts );
				
			
			$gl_oVars->cTpl->assign( 'is_loggedin', $gl_oVars->bLoggedIn );
			# //.... other things
		}//if		
		

		
		# create an alias for clan_id&team_id to library link
		if( Isset($_GET['clan_id']) && Isset($_GET['team_id'] ) )
		{
			$url_clanteam = 'clan_id='.(int)$_GET['clan_id'].'&team_id='.(int)$_GET['team_id'].'';
			$gl_oVars->cTpl->assign( 'url_clanteam', $url_clanteam );
		}
		
		
		
		$cCountry = new Country( $gl_oVars->cDBInterface );
		$gl_oVars->cTpl->assign( 'gl_countries', $cCountry->GetCountries() );
		
		
		// $this->CreateStatistics();
		
		$cGames = new GamePool( $gl_oVars->cDBInterface );
		$aPGames = $cGames->GetGames();
		$gl_oVars->cTpl->assign( 'pgames', $aPGames );
		
		# ----------------------------------------
		# GLOBAL GAME DATA CUPS | LADDERS
		#
		# ----------------------------------------
		if( isset($_COOKIE['member']['game_id']) )
		{
			for( $i=0; $i < sizeof($aPGames); $i++ ){
				if( $aPGames[$i]->id == (int)$_COOKIE['member']['game_id']){
					$oGame = $aPGames[$i];
					$gl_oVars->cTpl->assign( 'CURRENT_GAME', $oGame );
					break;
				}
			}
			if( $i==sizeof($aPGames)) unset($_COOKIE['member']['game_id']);
			
			// cups
			$aGameCups = module_sendmessage( '61A47C28-FE74-488d-B8E4-A11FEDBB935A', 'get_cups', $__DATA__, (int)$_COOKIE['member']['game_id'] );
			$gl_oVars->cTpl->assign( 'game_cups', $aGameCups );
			
			// ladder
			$aGameLadders = module_sendmessage( 'A9CCDCBF-C696-422c-A0D8-91223A9C22E6', 'get_ladders', $__DATA__, (int)$_COOKIE['member']['game_id'] );
			$gl_oVars->cTpl->assign( 'game_ladders', $aGameLadders );
		}
		else
		{
		}
		return 1;			
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------
	function FirstInits()
	{
		global $gl_oVars;
		$gl_oVars->cTpl->assign( 'GLOBAL_COLOR', 'blue' );
		return $this->SetDebugSecurity( EGL_DEBUGSECURITY_MIDDLE );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------
	function LastInits()
	{
		return 1;	
	}//
}

?>