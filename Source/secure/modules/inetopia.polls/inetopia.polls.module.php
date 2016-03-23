<?php
# ================================ Copyright © 2004-2007 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================

/**
 * 
 *
 * @copyright 	Inetopia
 * @author		Inetopia <support@inetopia.de>
 * @package 	EGL.Module.Polls
 **/
 
# defines
define( "TB_POLLS",					'egl_polls' );
define( "TB_POLLS_ANSWERS",			'egl_polls_answers' );
define( "TB_POLLS_VOTES",			'egl_polls_votes' );
define( "MODULEID_INETOPIA_POLLS",	"080EB2A4-10F7-4b54-AB0B-870870CC6072" );

DBTB::RegisterTB( 'EGL_POLLS', 'POLLS',				'egl_polls' );
DBTB::RegisterTB( 'EGL_POLLS', 'POLLS_ANSWERS',		'egl_polls_answers' );
DBTB::RegisterTB( 'EGL_POLLS', 'POLLS_VOTES',		'egl_polls_votes' );

egl_require( dirname(__FILE__).EGL_DIRSEP.'classes'.EGL_DIRSEP.'Polls.class.php' );

class module_inetopia_polls extends Module
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
					$data->ID 				= MODULEID_INETOPIA_POLLS;
					$data->sName 			= "Polls";
					$data->sVersion 		= "0.8";
					$data->sDevelopment 	= "Inetopia";
					$data->sHomepage 		= "http://www.inetopia.de";
					$data->sDescription		= "Surveys";
					$data->sSourceConst		= "modconst_polls";
					
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
				#save params
				$this->aParams = $data;
				
				# load settings
				$setting_file = EGL_SECURE.'modules'.EGL_DIRSEP.$this->aParams['module_path'].EGL_DIRSEP.'settings.php';
				if( file_exists( $setting_file))
				{
					include_once( $setting_file );
					$this->settings['cat_root_id'] = $cat_root_id;
				}
				return 1;
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
			case 'get_current_poll':
			{
				global $gl_oVars;
				
				$iCatId	= (int)$wparam;
				
				$cPoll = new Polls( $gl_oVars->cDBInterface );
				return $cPoll->getCurrentPoll( $iCatId);
				
			}break;
			
			# -------------------------------------------------------
			# 
			# -------------------------------------------------------
			case 'get_poll_answers':
			{
				global $gl_oVars;
				
				$iPollId	= (int)$wparam;
				
				$cPoll = new Polls( $gl_oVars->cDBInterface );
				return $cPoll->GetPollAnswers( $iPollId );
				
			}break;
			
			# -------------------------------------------------------
			# 
			# -------------------------------------------------------
			case 'get_catrgory_polls':
			{
				global $gl_oVars;
				
				$iCatId	= (int)$wparam;
				
				
				$cPoll = new Polls( $gl_oVars->cDBInterface );
				return $cPoll->GetCategoryPolls( $iCatId );
				
			}break;		

			# -------------------------------------------------------
			# 
			# -------------------------------------------------------
			case 'already_voted':
			{
				global $gl_oVars;
				
				$ip			= $wparam;			// ip-address
				$member_id	= (int)$lparam;		// member-id
				$oPoll		= $data;			// poll object [DB]
				
				# ---------------------------------------
				# poll object exists?
				# ---------------------------------------
				if( $oPoll )
				{
					$cPolls = new Polls( $gl_oVars->cDBInterface );
					if( $oPoll->lock_ip )
						return $cPolls->AlreadyVoted_IP( (int)$oPoll->id, $ip );
					if( $oPoll->lock_memberid && $member_id != -1)
						return $cPolls->AlreadyVoted_MEMBERID( (int)$oPoll->id, $member_id);
					return false;
				} return false;
			}break;

					
			# -------------------------------------------------------
			# 
			# -------------------------------------------------------
			case 'get_settings':
			{
				return $this->settings[$wparam];
				 
			}break;
			

			# -------------------------------------------------------
			# 
			# -------------------------------------------------------
			case 'get_poll_answers':
			{
				global $gl_oVars;
				
				$iPollId = (int)$wparam;
				
				$cPoll = new Polls( $gl_oVars->cDBInterface );
				return $cPoll->GetPollAnswers( $iPollId );
				
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
				
				# ----------------------------------------
				# 
				#
				# ----------------------------------------
				if( $data == 'hp' )
				{
			
					# get current question 
										
					# ------------------------------------
					# polls
					# ------------------------------------
					$cPolls = new Polls( $gl_oVars->cDBInterface );
					$menu_aPolls = $cPolls->GetPolls();
					for( $i=0; $i < sizeof($menu_aPolls); $i++ )
					{
						$menu_aPolls[$i]->answers = $cPolls->GetPollAnswers( $menu_aPolls[$i]->id );
					}//for
					$gl_oVars->cTpl->assign( 'menu_polls', $menu_aPolls );	
									
				} // if 'hp'
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
			
			
			# -------------------------------------------------------
			# 
			# -------------------------------------------------------
			case 'exec_admin_cmod':
			{
				
				
				return 1;
			}break;
			
			
			# ----------------------
			# Kommunication Template/Page <=> cMod
			# ----------------------
			
			
			case 'get_admin_links':
			{
				
				$aLinkPool = array();
				
				# get cmod ID
				$ID = $this->oInfos->ID;
				
				$aLinkPool[sizeof($aLinkPool)] = new module_link_t( 'Polls', 	"{\$url_file}cmod=$ID&page=admin.polls.list" );


				# save in output
				$data = $aLinkPool;
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
				return 1;
			}break;
			
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			# attachments on team.info..  => templates
			case 'get_teaminfo_attachment':
			{
				
				return NULL;
			}break;
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			# attachments on member.info.. => templates
			case 'get_memberinfo_attachment':
			{
				return NULL;
			}break;
			
			
			
			case 'get_matchinfo_attachment':
			{
				return NULL;
			}break;
			
			
			
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
			case 'admin_page_access':
			{
				# $data ->  $aAccesslist
				# wparam -> $ocModAdmin
				# lparam -> page
							
				$page			= $lparam;
				$acModAdmin 	= $wparam;
				$aAccesslist 	= $data;

				/*
				
					=> sollter nicht zum Einsatz kommen
				
				*/
				
				
				switch( $lparam /* PAGE */ )
				{
					/*
					case 'admin.cup':
					{
						$iCupId = (int)$_GET['cup_id'];
						
						$num_admin_perms = sizeof($acModAdmin);
						
						for( $i=0; $i < $num_admin_perms; $i++ )
							if( $iCupId == $acModAdmin[$i]->data )
							{
								return PAGEACCESS_OK;
							}
						
						
					}break;
					default:
					{
					}break;
					*/
				}
				
				
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