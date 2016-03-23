<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


define( "MODULEID_INETOPIA_PREMIUM",	"9C8010A6-3576-4ba3-9A97-95739C043B1A" );
egl_require( dirname(__FILE__). EGL_DIRSEP.'classes'.EGL_DIRSEP.'PremiumCore.class.php' );


class module_inetopia_premium extends Module
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
					$data->ID 				= MODULEID_INETOPIA_PREMIUM;
					$data->sName 			= "Premium";
					$data->sVersion 		= "0.5";
					$data->sDevelopment 	= "Inetopia";
					$data->sHomepage 		= "http://www.inetopia.de";
					$data->sDescription		= "Premium System for Members & Teams";
				
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
				
				
				# ------------------------------------------
				# update expired accounts
				# ------------------------------------------
				$cPremiumCore = new PremiumCore( $gl_oVars->cDBInterface );
				$cPremiumCore->RefreshPremiumAccounts();
				
				
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
				$ID = $this->oInfos->ID;
				
				$aLngModBuffer 	= array();
				$cLanguage 		= new Language();
				$cLanguage->ParseRootFile( Language::ModuleLanguageFile( $gl_oVars, $ID, $gl_oVars->sWorkspace ), $aLngModBuffer );
				
				//$aLinkPool[sizeof($aLinkPool)] = new module_link_t( 'Ladder beitreten', "{\$url_file}page=$ID:member.joinladder" );
				$aLinkPool[sizeof($aLinkPool)] = new module_link_t( $aLngModBuffer['c1010'], 	"{\$url_file}page=$ID:member.register" );
				$aLinkPool[sizeof($aLinkPool)] = new module_link_t( $aLngModBuffer['c1011'], 	"{\$url_file}page=$ID:member.overview" );


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
				
				global $gl_oVars;
				$workspace = $wparam;
				$page = $lparam;

				
				$cPremiumCore = new PremiumCore( $gl_oVars->cDBInterface );
				
				# -------------------------------------------------------------------------------------
				# ATTACHED: member.info
				# -------------------------------------------------------------------------------------
				if( $workspace == 'hp' && $page == 'member.info' )
				{
					
					$aSum = $cPremiumCore->getActivatedCodeSummary( PARTTYPE_MEMBER, (int)$_GET['member_id'] );
					$gl_oVars->cTpl->assign( 'PREMIUM_ACCOUNTS',	$aSum );
					
					
					# set variables to attachment
					return array( 	'template_file' => 'member_degrees.tpl',
									'priority'	=> 1 );					
				}
				# -------------------------------------------------------------------------------------
				# ATTACHED: member.info
				# -------------------------------------------------------------------------------------
				if( $workspace == 'hp' && $page == 'team.info' )
				{
				
					# set variables to attachment
					$aSum = $cPremiumCore->getActivatedCodeSummary( PARTTYPE_TEAM, (int)$_GET['team_id'] );
					$gl_oVars->cTpl->assign( 'PREMIUM_ACCOUNTS',	$aSum );
					
					
					return array( 	'template_file' => 'team_degrees.tpl',
									'priority'	=> 1 );					
				}
				
							
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