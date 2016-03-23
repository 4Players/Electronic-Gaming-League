<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


define( 'MODULERESULT_UNKNOWN',					1001 );
define( 'MODULERESULT_NOT_FOUND',				1002 );
define( 'MODULERESULT_NOT_LOADED',				1003 );
define( 'MODULERESULT_NOT_ACTIVAED',			1004 );
define( 'MODULERESULT_NOT_INSTALLED',			1005 );


# -[ defines ]-

class admin_module_data_t
{
	var $ModuleID		= EGL_NO_ID;
	var $aLeagueIDs		= array();
	var $sub_permission = '';
};


# -[ objects ]-
class module_data_request_t
{
	var $ID				= 'unknown';
	var $sName			= 'unknown';
	var $sVersion		= 'unknown';
	var $sDevelopment	= 'unknown';
	var $sHomepage		= 'unknown';
	var $sDescription	= 'unknown';
};

#---------------------------------------------------------------------------------------
#---------------------------------------------------------------------------------------
class module_tpl_links_t
{
	var $sCaption	= 'unknown';
	var $aLinks		= array();
};


#---------------------------------------------------------------------------------------
#---------------------------------------------------------------------------------------

class module_link_t
{
	var $sName		= '';
	var $sURL		= '';
	
	function module_link_t( $name, $url )
	{
		$this->sName 	= $name;
		$this->sURL 	= $url;
	}
};


class module_entry_t
{
	var $sURL		= '';
	var $sName		= 'unknown';
	var $Id 		= 0;
	
	
	
	#var $iCModId	= 'unknown';
	#var $iParttype	= NULL;
	#var $iPartId	= EGL_NO_ID;
	#var $iEntryId	= EGL_NO_ID;
};



class module_attachment_t
{
	var $ModuleID		= EGL_NO_ID;
	var $sLocalLink		= '';
};



class module_match_info
{
	var $sGameName	= "";
	var $iGameId	= EGL_NO_ID;
	var $sImgURL	= "";
	var $sEntry		= "";
};

#---------------------------------------------------------------------------------------
#---------------------------------------------------------------------------------------

class module_tpl_t
{
	var $sTemplate	= '';
	var $sDocument	= '';
	
	function module_file_info_t( $sTemplate, $sDocument )
	{
		$this->sTemplate = $sTemplate;
		$this->sDocument = $sDocument;
	}
};








# -[ class ] -
class Module
{
	# -[ variables ]-
	var $bInit			= false;
	var $aParams		= array();
	var $pDBCon 		= NULL;
	var $oInfos			= NULL;
	
	
	

	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	function Module ()
	{
	}		
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function Init ( &$pDBCon )
	{
		$this->pDBCon 	= &$pDBCon;
		$this->bInit	= true;
	}	
	
	//-------------------------------------------------------------------------------
	// Purpose: receives all events
	//-------------------------------------------------------------------------------
	function ProcessMessage( $event, &$data, $wparam=NULL, $lparam=NULL )
	{
		switch( $event )
		{
			# ----------------------
			# standard events
			# ----------------------
			case 'info':
			{
				if( get_class($data) == 'module_data_request_t' )
				{
					$data->cmID 		= "unkown";
					$data->sName 		= "unkown";
					$data->sVersion 	= "unkown";
					$data->sDevelopment = "unkown";
					$data->sHomepage 	= "unkown";
					$data->sDescription	= "unkown";
					
					# localize cmod data
					$this->oInfos 		= $data;
				}
			}break;
			case 'load':
			{
				# save params, entered in /cmods/cmodxy.ini
				$this->aParams = $data;
			}break;
			case 'unload':
			{
			}break;
			case 'install':
			{
			}break;
			case 'uninstall':
			{
			}break;
			
			# ----------------------
			# specific events
			# ----------------------

			case 'on_register_member':
			{
			}break;
			case 'on_unregister_member':
			{
			}break;
			
		
			# ----------------------
			# page events
			# ----------------------
			
			
			case 'match_info':
			{
				/*
						Detail informations
							>> name of joined cmod tabelle
							
							
						Data
							>> $data = array of match structures
							
				*/
				
			}break;

			case 'match_first_report':
			{
			}break;
			case 'match_second_report':
			{
			}break;
			
			
			
			case 'exec_template':
			{
			}break;
			
			case 'exec_document':
			{
			}break;
			
			
			# ----------------------
			# Kommunication Template/Page <=> cMod
			# ----------------------
						
			# multiplayer (team)
			case 'get_team_links':
			{
			}break;
			
			# single player (member)
			case 'get_member_links':
			{
			}break;
			
			# attachments on team.info..  => templates
			case 'get_teaminfo_attachment':
			{
			}break;
			
			# attachments on member.info.. => templates
			case 'get_memberinfo_attachment':
			{
			}break;			
			
			
			case 'page_access':
			{
				global $gl_oVars;
				
				# $data ->  $aAccessList
				# wparam -> $aAdminPerms
				# lparam -> page
				
				
				#------------------------------------------------------------------------------------------
				# check access to single pages	
				#------------------------------------------------------------------------------------------	
				switch( $lparam /* current page*/ )
				{
					
					
					# ----------------------------------------------------------
					# check match permission
					# ----------------------------------------------------------
					case 'admin.match':
					{
						
						$iMatchId 	= (int)$_GET['match_id'];
						$cMatch 	= new Match($gl_oVars->cMysql, $iMatchId);
						$oMatch		= $cMatch->GetData();
						
						
						# for each permission
						for( $i=0; $i < sizeof($wparam); $i++ )
						{
				
							
							# right cmod_id ?	
							if( $oMatch->module_id == $wparam[$i]->module_id )
							{
								
								if( module_sendmessage( $wparam[$i]->cmod_id, 'match_access', $oMatch, $iMatchId ) == PAGEACCESS_OK )
								{
									return PAGEACCESS_OK;
								}
								
							}//if
						}//for
						
						return PAGEACCESS_FAILED;
					
					}break;
					
					
					/*
					case 'admin.match.protests':
					{
						
						
						
						
						return PAGEACCESS_OK;
					}break;*/
				}
				
				#if( sizeof($wparam) > 0 ) return PAGEACCESS_OK;
				return PAGEACCESS_FAILED;
			}break;
			
			
			
			case 'page_secure':
			{
			}break;
			
			
			case 'entry_list':
			{
			};

			
			
			
			case 'export':
			{
			}break;
			
			
			
			case 'import':
			{
			}break;
			
			# ---------------------------------------------------------------------------------
			# ---------------------------------------------------------------------------------
			
			
		
			default:
			{
				return -1;
			}break;
			
			/*
				statistics
				medaille
			
			*/
			
			
		}//switch
		return -1;
	}// function ProcessMessage()
	
	
	
};

?>