<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


# -[ defines ]-
define( "PAGEACCESS_OK", 			1 );
define( "PAGEACCESS_FAILED", 		2 );


class base_access_t
{
	var $permissions	= 'unknown';
	function base_access_t( $permissions ){
		$this->permissions = $permissions;
	}
}

# -[ objects ]-


class clan_access_t extends base_access_t
{
	var $clan_id		= -1;
	var $aTeams			= array();
	
	function clan_access_t( $permissions, $clan_id, $aTeams ){
		$this->permissions = $permissions;
		$this->clan_id = $clan_id;
		$this->teams = $aTeams;
	}
};

class team_access_t extends base_access_t
{
	var $team_id		= -1;
	function clan_access_t( $permissions, $clan_id, $teams ){
		$this->permissions = $permissions;
		$this->clan_id = $clan_id;
		$this->teams = $teams;
	}
};

class admin_access_t extends base_access_t 
{
	var $module_id		= EGL_NO_ID;
	var $admin_id		= -1;
	var $data			= NULL;			
	function admin_access_t( $permissions, $admin_id, $module_id, $data ){
		$this->permissions = $permissions;
		$this->admin_id = $admin_id;
		$this->module_id = $module_id;
		$this->data = $data;
	}
}

# -[ class ] -
class PageAccess
{
	# -[ variables ]-
	var $aClans			= array();
	var $pcMember		= NULL;
	var $aVarBuffer		= array();
	var $bInit			= false;
	var $pDBCon			= NULL;
	var $sPACallbackRoot= '/';
	var $bCallbacksEnabled= false;
	
	
	var $aLastAccessList = array();
	
	
	# -[ functions ]-
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output :
	//-------------------------------------------------------------------------------
	function PageAccess ( &$pMember, &$pDBCon )
	{
		if( $pMember ) $this->pcMember = &$pMember;
		if( strtoupper(get_parent_class($pDBCon)) == 'DBCONNECTION' ) 
		{
			$this->pDBCon = &$pDBCon; 
		}
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : true/false
	//-------------------------------------------------------------------------------	
	function GetVarBuffer()
	{
		return $this->aVarBuffer;
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: enables callback functions
	// Output : true/false
	//-------------------------------------------------------------------------------
	function EnableCallbacks( $root )
	{
		if( strlen($root)>0 && file_exists($root))
		{
			$this->bCallbacksEnabled = true;
			$this->sPACallbackRoot = $root;
			return true;
		}//if
		return false;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: receive the buffer to pa/gc list
	// Output : true/false
	//-------------------------------------------------------------------------------	
	function & GetVarBufferPointer()
	{
		return $this->aVarBuffer;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : true/false
	//-------------------------------------------------------------------------------	
	function SetAccessFile( $sFilename )
	{
		# try loading page_access file
		if( file_exists( FIX_URL_SEP($sFilename) ) )
		{
			// $this->aVarBuffer = parse_ini_file( FIX_URL_SEP($sFilename), true ); # parse complex tyüe
			$this->aVarBuffer = parse_ini_file( FIX_URL_SEP($sFilename), false );
			$this->bInit = true;
			return true;
		}//if	
		else
		{
			//DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't load access file `PageAccess::SetAccessFile()`" );
		}	
		return false;
	}

	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : true/false
	//-------------------------------------------------------------------------------
	function Evaluate( $workspace, $bLoggedIn, $page, $clan_id, $team_id, $module_id=EGL_NO_ID )
	{
		global $gl_oVars;
		
		if( !$this->bInit )
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't evaluate page '$page' - AccessFile hasn't been set!" );
			return PAGEACCESS_FAILED;
		}//if
		

		if( $this->pDBCon == NULL )
		{
			DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "PageAccess Evaluate could have some problemes by loading page '$page' - DBConnection hasn't been set!" );
			//return PAGEACCESS_FAILED;
		}//if

		$oMemberData	= NULL;		 # later contains the member	 data
		
		# load buffer
		//$pPageAccess 	= &$this->aVarBuffer[$workspace];
		$pPageAccess 	= &$this->aVarBuffer;
		
		/***********************
			normaly it returns true(1)  -> according to the current workspace
			
			=> MOVED TO Document, gehört hier nicht rein :))
			
		***********************/
		/*if( $gl_oVars->pcRuntimeEngine->PageAccessCheck() == 0 )
		{
			return PAGEACCESS_FAILED;
		}*/
				
		# ---------------------------------------------------------
		# if the page accesslist is empty => set the page as accessed
		# ---------------------------------------------------------
		if( !Isset($pPageAccess[$page]) || strlen($pPageAccess[$page]) == 0 )
		{
			return PAGEACCESS_OK;
		}
	
		/*
		#--------------------------------------------------
		# 
		#--------------------------------------------------
		if( (!$team_id && !$clan_id)  )
		{
			return PAGEACCESS_FAILED;
		}
		
		#--------------------------------------------------
		# 
		#--------------------------------------------------
		if ($team_id&&!$clan_id)
		{
			return PAGEACCESS_FAILED;
		}
		*/

		
		#--------------------------------------------------
		# fetch memberadata
		#--------------------------------------------------
		$oMemberData 		= $this->pcMember->GetData();
		/*if( !$oMemberData )
		{
			#echo "Error";
			return PAGEACCESS_FAILED;
		}*/
		 
		

		# ------------------------------------------------------
		# ------------------------------------------------------
		$bModuleAdminRequest	= false;
		$bModuleRequest			= false;
		$aModuleAdmin			= array();	# contain list of current module_id permissions
		$bAccess 				= false;
		$aTeamPermissions 		= array();

		
		# ------------------------------------------------------
		# get page access items, set up in page_acess.conf
		# ------------------------------------------------------
		# remove whitespaces if there are
		$aPageAccessItems = explode( ',', str_replace(' ','',$pPageAccess[$page]) ); 
		
		
		if( sizeof($aPageAccessItems) == 0 ) return PAGEACCESS_OK;
		//if( !$bLoggedIn ) return PAGEACCESS_FAILED;

		# =======================================================
		# C R E A T E    A C C E S S L I S T
		# =======================================================
		$aAccesslist = array();

	
		# ONLY IF LOGIN !!
		if( $oMemberData )
		{
			$aAccesslist[sizeof($aAccesslist)] = new base_access_t( 'member' );
			
			#----------------------------------------------		
			# A D M I N S
			#----------------------------------------------		
			$aAdminPermissions 	= $this->pcMember->GetAdminPermissions();
			$oAdmin			 	= $this->pcMember->GetAdminData();
			if( $oAdmin ) $aAccesslist[sizeof($aAccesslist)] = new admin_access_t( 'admin', -1, -1, NULL );	// admin allgeein setzen
	
			// add admin.++  permissions to accesslist
			for( $iAdmin=0; $iAdmin< sizeof($aAdminPermissions); $iAdmin++ )
			{
				$aAccesslist[sizeof($aAccesslist)] = new admin_access_t( 	'admin.'.$aAdminPermissions[$iAdmin]->permissions, 
																			$aAdminPermissions[$iAdmin]->admin_id, 
																			$aAdminPermissions[$iAdmin]->module_id, 
																			$aAdminPermissions[$iAdmin]->data );
			}//for
			
			
			#----------------------------------------------		
			# C L A N S 
			#----------------------------------------------		
			$oClanAccount = $this->pcMember->GetClanAccount( $clan_id );
			if( $oClanAccount )
			{
				$aAccesslist[sizeof($aAccesslist)] = new clan_access_t( 'clan.'.$oClanAccount->permissions, $oClanAccount->id, array() );
			}//if
			
		
			#----------------------------------------------		
			# T E A M S 	
			#----------------------------------------------		
			if( $team_id )
			{
				/*
				$aTeamAccounts = $this->pcMember->GetTeamAccounts();
				for( $i=0; $i < sizeof($aTeamAccounts); $i++ )
				{
					if( $aTeamAccounts[$i]->id == $team_id )
					{
						$aAccesslist[sizeof($aAccesslist)] = 'team.'.$aTeamAccounts[$i]->permissions;
					}//if
				}//for
				*/

				if( $this->pDBCon )
				{
					$cTeam = new Team( $this->pDBCon );
					$oTeamPermissions = $cTeam->GetTeamPermissions( $oMemberData->id, $team_id );
				
					# add to list
					$aAccesslist[sizeof($aAccesslist)] = new team_access_t( 'team.'.$oTeamPermissions->permissions );
				}//if
			}//if
			
			
			
			
			
		} // if logged in
		//else return PAGEACCESS_FAILED;		/* Otherwise FALSE */
			
		

		# ------------------------------------------------------
		# compare page accessitems && accesslist
		# ------------------------------------------------------
		$aPermissionList = array();	// validated permissions
		
		
		
		// declare callbackmanager
		$cPACallbackManager = new CallbackManager();
		if( $gl_oVars->bModuleURLAttempt )
		{
			$cPACallbackManager->Init( MODULE_DIR.$gl_oVars->oModule->sModulePath.EGL_DIRSEP.'workspaces'.EGL_DIRSEP.$workspace.EGL_DIRSEP.'callbacks'.EGL_DIRSEP.'pageaccess'.EGL_DIRSEP, $GLOBALS['gl_oVars'] );
		}
		else
		{
			$cPACallbackManager->Init( EGL_SECURE.'workspaces'.EGL_DIRSEP.$workspace.EGL_DIRSEP.'callbacks'.EGL_DIRSEP.'pageaccess'.EGL_DIRSEP, $GLOBALS['gl_oVars'] );
		}		
		
		
		#echo "<textarea style='width:100%;' rows=20>".nl2br( print_r( $aPageAccessItems, 1))."</textarea>";
		#echo "<textarea style='width:100%;' rows=20>".nl2br( print_r( $aAccesslist, 1))."</textarea>";
		
		# start comparing
		$num_pageaccessitems=sizeof($aPageAccessItems);
		for( $iPAI=0;  $iPAI < $num_pageaccessitems; $iPAI++ )
		{
			$const 	= 'unknown';
 			$bAll 	= false;

			
 			$aPermit = explode( '.', $aPageAccessItems[$iPAI] );
 			/*
 				"front.back"
 				--
 				$aPermit[0] = front
 				$aPermit[1] = back
 			*/
			#----------------------------------
			# CHECK CALLBACK?
			#
			# Callback found => add to list
			#
			#----------------------------------
 			if( ($aPermit[0] == 'callback' || /* module/or base callback */
 				$aPermit[0] == 'base_callback') && /* only base workspace */
 				strlen($aPermit[1]) > 0 )
 			{
 				$_CALLBACK_TYPE = 'callback';
 				
 				# -------------------------------------------------
 				# reconfigure CallbackManager if necessay
 				# 
 				# base_callbacks are located in roots of workspaces
 				# -------------------------------------------------
 				if( $aPermit[0] == 'base_callback' )
 				{
 					$_CALLBACK_TYPE = 'base_callback';
					$cPACallbackManager->Init( EGL_SECURE.'workspaces'.EGL_DIRSEP.$workspace.EGL_DIRSEP.'callbacks'.EGL_DIRSEP.'pageaccess'.EGL_DIRSEP, $GLOBALS['gl_oVars'] );
 				}

				#
				#
				#
				$__access_permissions	= $aPageAccessItems[$iPAI];
				$__access_parameters	= '';
				
				// parametes available?
				$param_tag_start=0;
				if( $param_tag_start=strpos( $__access_permissions, '(' ) )
				{
					$param_tag_closed = strpos( $__access_permissions, ')' );
					if( $param_tag_closed )
					{
						$__access_parameters = substr( $__access_permissions, $param_tag_start+1, $param_tag_closed-($param_tag_start+1) ); //strlen($__access_permissions)-$param_tag_closed );
						$__access_permissions = substr( $__access_permissions, 0, $param_tag_start );
					}
					else
					{
						// wrong syntax
						// DEBUG( );
						continue;
					}
				}
				
 				# define access object
 				//$oAccessObject = new base_access_t( substr( $aPageAccessItems[$iPAI], strlen($_CALLBACK_TYPE)+1, strlen($aPageAccessItems[$iPAI])- strlen($_CALLBACK_TYPE)+1) );
 				# changed, 24.01.07
 				$oAccessObject = new base_access_t( substr( $__access_permissions, strlen($_CALLBACK_TYPE)+1, strlen($__access_permissions)- strlen($_CALLBACK_TYPE)+1) );

 				# callback exists?
 				if( $cPACallbackManager->CallbackExists( $oAccessObject->permissions ) )
 				{
 					$result_callback = $cPACallbackManager->Call( $oAccessObject->permissions, array( 'parameters' => $__access_parameters, 'current_permission' => $oAccessObject,  'permission_list' => $aPermissionList ) );
	 				switch( $result_callback )
	 				{
	 					# callback-call, falls true => Rechte erhalten
	 					case 1:
	 					{
	 						// add premission to permission accessed list
		 					$aPermissionList[sizeof($aPermissionList)] = $oAccessObject;
	 					}break;
	 					# recht enicht erhalten
	 					case 0:
	 					{
	 					}break;	
	 					# rechte komplett aufgehoben
	 					case -1:
	 					{
	 						# reset/clear buffer
	 						$aPermissionList = array();
	 						
	 						# end process
	 						return PAGEACCESS_FAILED;
	 					}break;	
		 				
	 				}
 				}
	 			else
	 			{
	 				# wenn callback nicht vorhanden => Rechte erhalten
	 				# Bei Callbacks nicht so, da funktionen keine wirklichen Rechte sind, d.h. diue Funktion ist hier ein MUSS
	 				// $aPermissionList[sizeof($aPermissionList)] = $oAccessObject;
	 			}

	 			continue;
 			}//if callback ?
 			
			#---------------------------------- 						
			# ALL OF SECTION
			#---------------------------------- 						
 			if( $aPermit[1] == 'all' )
 			{
 				$bAll 	= true;
 				$const 	= $aPermit[0];
 			}//if

 			# ---------------------------------
 			# check [MY OWN] accesslist		
 			# ---------------------------------
 			$num_accesslist=sizeof($aAccesslist);
			for( $iC=0; $iC < $num_accesslist; $iC++ )
			{
				/***********************************************************************************/
				if( $bAll )
				{
		 			$aSubPermit = explode( '.', $aAccesslist[$iC]->permissions );
		 			
		 			# primary permission equal to sub permission ?
		 			if( $aSubPermit[0] == $const )
		 			{
	 					# prüfe callback vorhanden?
	 					# ACHTUNG ausnahme -> hier wird die übergreifende Konstante als Callbackfunktion genutzt
	 					# d.h. xxx.all
	 					#
	 					
		 				if( $cPACallbackManager->CallbackExists( $aPageAccessItems[$iPAI] ) )
		 				{
		 					# callback-call, falls true => Rechte erhalten
		 					if( $cPACallbackManager->Call( $aPageAccessItems[$iPAI],  /*$aAccesslist[$iC]*/array( 'current_permission' =>  new base_access_t($aPageAccessItems[$iPAI]),  'permission_list' => $aPermissionList ) ) )
		 					{
			 					//$aPermissionList[sizeof($aPermissionList)] = $aAccesslist[$iC];
			 					$aPermissionList[sizeof($aPermissionList)] = new base_access_t($aPageAccessItems[$iPAI]);
		 					}
		 				}
		 				else
		 				{
		 					# wenn callback nicht vorhanden => rechte erhalten
			 				//$aPermissionList[sizeof($aPermissionList)] = $aAccesslist[$iC]; # object base_access_t
			 				$aPermissionList[sizeof($aPermissionList)] = new base_access_t($aPageAccessItems[$iPAI]);
		 				}
						
		 				continue;
		 			}
				}//if
				else
				/***********************************************************************************/
				{
					if( $aPageAccessItems[$iPAI] == $aAccesslist[$iC]->permissions )
					{
						
		 				if( $cPACallbackManager->CallbackExists( $aAccesslist[$iC]->permissions ) )
		 				{
		 					# callback-call, falls true => Rechte erhalten
		 					if( $cPACallbackManager->Call( $aAccesslist[$iC]->permissions,  array( 'current_permission' => $aAccesslist[$iC],  'permission_list' => $aPermissionList ) ) )
		 					{
			 					$aPermissionList[sizeof($aPermissionList)] = $aAccesslist[$iC];
		 					}
		 				}
		 				else
		 				{
		 					# wenn callback nicht vorhanden => rechte erhalten
			 				$aPermissionList[sizeof($aPermissionList)] = $aAccesslist[$iC]; # object base_access_t
		 				}
						
		 				continue;
		 				
					}//if
				}//if
			}//for
			
		}//for( $iPAI=0;  $iPAI < $num_pageaccessitems; $iPAI++ )  :: Compare both Permissionlist :: AccessFile[$aPageAccessItems] <==> UserPermissions[$aPermissionList]
				
				
		/*
		1. Schritt erstelle die komplette Permissionliste, die dem User die Seitenberechtigungen geben
			=> gespeichert in $aPermissionList
		
		2. Schritt suche die richtige Callbackfunktion? (=> suche so lange, bis eine eine Callbackfunktion die berechtigung erlaubt?
			=> ?? kann es hierbei Probleme geben?
		*/
		
		//echo "<textarea style='width:100%;' rows=50>".print_r($aPermissionList,1)."</textarea>";
		
		if( sizeof($aPermissionList) ) $bAccess = true;
		
		
		# save accesslist
		$this->aLastAccessList = $aAccesslist;
		
		
		//echo nl2br( print_r( $aAccesslist, 1));
	
		# ---------------------------------------------------------
		# current page has been accessed - last global check
		#
		# ---------------------------------------------------------
		if( $bAccess ){
			return PAGEACCESS_OK;
		}
		
		return PAGEACCESS_FAILED;		
	}//
	

	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : true/false
	//-------------------------------------------------------------------------------
	function GetLastAccessList($type=NULL)
	{
		$return_list = array();
		for( $i=0; $i < sizeof($this->aLastAccessList); $i++ )
		{
			$access_data = db_read_array_string( str_replace( '.', ',', $this->aLastAccessList[$i]->permissions ) );
			if( $type )
			{
				if( $access_data[0] == $type )
					$return_list[sizeof($return_list)] = $access_data;
			}
			else $return_list[sizeof($return_list)] = $access_data;
		}
		return $return_list;
	}//GetLastAccessList

};


?>