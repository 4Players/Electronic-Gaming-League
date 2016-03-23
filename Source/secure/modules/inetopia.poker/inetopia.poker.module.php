<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


define( "MODULEID_INETOPIA_POKER",	"AB08158B-64C7-4d3c-955D-E29D151AC005" );
egl_require( dirname(__FILE__) . EGL_DIRSEP.'classes'.EGL_DIRSEP.'PokerCMS.class.php' );
egl_require( dirname(__FILE__) . EGL_DIRSEP.'classes'.EGL_DIRSEP.'PokerOrganiser.class.php' );
egl_require( dirname(__FILE__) . EGL_DIRSEP.'classes'.EGL_DIRSEP.'PokerSessions.class.php' );


class module_inetopia_poker extends Module
{
	
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
					$data->ID 				= MODULEID_INETOPIA_POKER;
					$data->sName 			= "Pokervill";
					$data->sVersion 		= "0.1";
					$data->sDevelopment 	= "Inetopia";
					$data->sHomepage 		= "http://www.inetopia.de";
					$data->sDescription		= "";
				
					# localize cmod data
					$this->oInfos = $data;
				
					return 1;
				}
			}break;
			
			# -------------------------------------------------------
			# 
			# -------------------------------------------------------
			case 'load':
			{
				global $gl_oVars;
			
				if( $gl_oVars->bLoggedIn ){
					$cPokerOrganiser = new PokerOrganiser( $gl_oVars->cDBInterface );	
					$aOrganiser = $cPokerOrganiser->GetOrganiser($gl_oVars->iMemberId);
					$gl_oVars->cTpl->assign( 'ORGANISER_LIST', $aOrganiser );
				}
				
				$gl_oVars->cTpl->assign( 'ROOT_URL', PageNavigation::MyRootURL() );				
			
			}break;
			
			
			# -------------------------------------------------------
			# 
			# -------------------------------------------------------
			case 'unload':
			{
				return 1;
			}break;
			
			# -------------------------------------------------------
			# 
			# -------------------------------------------------------
			case 'install':
			{
				# install tables
				return 1;
			}break;
			
			
			# -------------------------------------------------------
			# 
			# -------------------------------------------------------
			case 'uninstall':
			{
				# uninstall tables
				return 1;
			}break;
			
			# -------------------------------------------------------
			# 
			# -------------------------------------------------------
			case 'get_settings':
			{
 
			}break;
			

			# -------------------------------------------------------
			# 
			# -------------------------------------------------------
			case 'get_poll_answers':
			{
				
			}break;
			
			
			
			# -------------------------------------------------------
			# 
			# -------------------------------------------------------
			case 'optimize':
			{
				
				return 1;
			}break;
		
			# ----------------------
			# specific events
			# ----------------------
			case 'on_register_member':
			{
				return 1;
			}break;
			
			
			# -------------------------------------------------------
			# 
			# -------------------------------------------------------
			case 'on_unregister_member':
			{
				return 1;
			}break;
			
		
			# -------------------------------------------------------
			# 
			# -------------------------------------------------------
			case 'on_teamjoin_request':
			{
				
				return 1;
			}break;
			
			
			# ----------------------
			# page events
			# ----------------------
			
	
			case 'match_info':
			{
				
				return 1;
			}break;
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'match_first_report':
			{
				
				return 1;
			}break;
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'match_second_report':
			{				
				return 1;
			}break;
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'match_administration':
			{
				return 1;
			}break;
			
			
		
			/*
			case 'match_revolk_administration':
			{
				return 1;
			}break;*/
			
			
			case 'page_init':
			{
								
				
			}break;
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#   Input: 	$data =>  RelDir
			#			$wparam => $page_tpl
			#			$lparam => $gl_oVars->bCModActivated
			#  Output:  *true/false
			#-----------------------------------------------------------------------------------------------------
			case 'exec_template':
			{
				global $gl_oVars;
				
				/*
					$data =>  workspace
					$wparam => $page_tpl
					$lparam => $ID
				*/
				
				return  true;
			}break;
			
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'exec_document':
			{
				
				
				return 1;
			}break;
			
			
			
			
			# ----------------------
			# Kommunication Template/Page <=> Module
			# ----------------------
			
			
			case 'get_admin_links':
			{
				
				return 1;				
				
			}break;
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			# multiplayer (team)
			case 'get_team_links':
			{
				return 1;
			}break;
			

			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			# single player (member)
			case 'get_member_links':
			{
				global $gl_oVars;
				$aLinkPool = array();
				
				# get cmod ID
				$ID 		= $this->oInfos->ID;
				$iMemberId 	= (int)$gl_oVars->iMemberId;
				
				$aLngModBuffer 	= array();
				$cLanguage 		= new Language();
				$cLanguage->ParseRootFile( Language::ModuleLanguageFile( $gl_oVars, $ID, $gl_oVars->sWorkspace ), $aLngModBuffer );
				
				$aLinkPool[sizeof($aLinkPool)] = new module_link_t( 'Meine Veranstaltungen', 	"{\$url_file}page=$ID:sessions.my" );
				$aLinkPool[sizeof($aLinkPool)] = new module_link_t( 'Veranstaltung', 			"{\$url_file}page=$ID:sessions.list" );

				# save in output
				$data = $aLinkPool;
				
				return 1;
			}break;
			
			
		#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			# attachments on team.info..  => templates
			case 'template_attachment':
			{
				/**
				 * $wparam 	=> workspace
				 * $lparam  => page
				 * 
				 */
				
										
				return NULL1;	
			}			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'entry_list':
			{
				
				return NULL;
			}break;
			
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'match_list':
			{
				/*
				global $gl_oVars;
				*/
							
				return NULL;
			}break;
			
			
			
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose: Zuständig, ob ein Member (abhängig von den Admin-Permissions) auf das match adminrechte hat
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'match_access':
			{

				#	if( $obj ) return PAGEACCESS_OK;
				return PAGEACCESS_FAILED;
			}break;
			
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'entry_access':
			{
				
				
			}break;
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'page_access':
			{
				# $data ->  $aAccesslist
				# wparam -> $ocModAdmin
				# lparam -> page
				
				
				
		
				if( sizeof($wparam) > 0 ) return PAGEACCESS_OK;
				return PAGEACCESS_FAILED;
			}break;
			
			
		
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			default:
			{
				return MODULERESULT_UNKNOWN;
				//return $this->ProcessStandardMessage( $event, $data, $wparam, $lparam );
				//return Module::ProcessMessage( $event, $data, $wparam, $lparam );
			}break;
			
			
		}//switch
		
		return 1;
	}	
};

?>