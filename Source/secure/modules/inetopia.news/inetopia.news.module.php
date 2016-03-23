<?php
# ================================ Copyright � 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


define( "MODULEID_INETOPIA_NEWS",		'28D4D051-E0BE-4328-8D85-C6074695FE16' );

# ========================================================================================

DBTB::RegisterTB( 'MOD:INET:NEWS', 'EGL_NEWS',			'egl_news' );
DBTB::RegisterTB( 'MOD:INET:NEWS', 'EGL_NEWS_COMMENTS',	'egl_news_comments' );

# ========================================================================================
define( "TB_NEWS",						'egl_polls' );
define( "TB_NEWS_COMMENTS",				'egl_polls_answers' );

# ========================================================================================

egl_require( dirname(__FILE__) . '/classes/News.class.php' );

# ========================================================================================



class module_inetopia_news extends Module
{
	var $settings = array();
	
	
	
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
					$data->ID 				= MODULEID_INETOPIA_NEWS;
					$data->sName 			= "News";
					$data->sVersion 		= "0.9";
					$data->sDevelopment 	= "Inetopia";
					$data->sHomepage 		= "http://www.inetopia.de";
					$data->sDescription		= "News Management";
					$data->sSourceConst		= "modconst_news";
					
					# localize cmod data
					$this->oInfos = $data;
				
					return 1;
				}
			}break;
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
			case 'unload':
			{
				return 1;
			}break;
			case 'install':
			{
				# install tables
				return 1;
			}break;
			case 'uninstall':
			{
				# uninstall tables
				return 1;
			}break;
			
			
			
			
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
			case 'on_unregister_member':
			{
				return 1;
			}break;
			
		
			
			
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
			#   Input: 	$data =>  workspace
			#			$wparam => $page_tpl
			#			$lparam => $gl_oVars->sModuleId
			#  Output:  *true/false
			#-----------------------------------------------------------------------------------------------------
			case 'exec_template':
			{
				global $gl_oVars;
				
				/*
					$data =>  Workspace
					$wparam => $page_tpl
					$lparam => $cmID
				*/
				/*
				# ----------------------------------------
				# 
				#
				# ----------------------------------------
				if( $data == 'hp' )
				{
					/*
					$cNews = new News( $gl_oVars->cDBInterface );
					$aNews = News::SortDaily( $cNews->GetNews( 0, 20 ) );
					$gl_oVars->cTpl->assign( 'top_news', $aNews );
									
				} // if 'hp'
			
				if( $lparam == $this->oInfos->ID )
				{
					$gl_oVars->cTpl->assign( 'GLOBAL_COLOR', 'violet' );
				}
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
				
				$aLinkPool[sizeof($aLinkPool)] = new module_link_t( 'Polls', 	"{\$url_file}page={$ID}:admin.polls.list" );


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
				$cCup = new Cup( $gl_oVars->cDBInterface, NULL );

				$cup_id				= $data->entry_id;  ## entry_id 
				$participant_id		= $data->part_id;	# overgiven by engine
				$participant_type	= $data->part_type;	# overgiven by engine
				$status				= NULL;
				*/
				
				
							
				return NULL;
			}break;
			
			
			
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose: Zust�ndig, ob ein Member (abh�ngig von den Admin-Permissions) auf das match adminrechte hat
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
						// 
					}break;
				} //switch
				
				
				return PAGEACCESS_FAILED;
			}break;
			
			#=============================================================================================================	
			#=============================================================================================================	
			#=============================================================================================================	
			#================  SPECIAL MESSAGE EVENTS                                                 ====================	
			#=============================================================================================================	
			#=============================================================================================================	
			
			
			
			case 'get_settings':
			{
				return $this->settings[$wparam];
				 
			}break;
			

			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'get_overview_news':
			{
					global $gl_oVars;
					
					# declare/define classes / obejcts	
					$cNews		= new News( $gl_oVars->cDBInterface );
					
					# fetch data from db
					return $cNews->GetOverviewNews( (int)$wparam, (int)$lparam );
			}break;
			
			

			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'get_news':
			{
					global $gl_oVars;
					
					# declare/define classes / obejcts	
					$cNews		= new News( $gl_oVars->cDBInterface );
					
					# fetch data from db
					return $cNews->GetNews( (int)$wparam, (int)$lparam );
			}break;
			
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'get_game_news':
			{
					global $gl_oVars;
					
					$iGameId 	= (int)$wparam;
					
					# declare/define classes / obejcts	
					$cNews	= new News( $gl_oVars->cDBInterface );
					# fetch data from db
					return $cNews->GetGameNews( $iGameId );
			}break;
			
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			case 'get_category_news':
			{
					global $gl_oVars;
					
					$iCategoryId 	= (int)$wparam;
					//$iLimit			= (int)$lparam;
					
					# declare/define classes / obejcts	
					$cNews	= new News( $gl_oVars->cDBInterface );
					
					# fetch data from db
					return $cNews->GetCategoryNews( $iCategoryId );
			}break;
			
			
			
			#-----------------------------------------------------------------------------------------------------
			# Purpose:
			#  Output:
			#-----------------------------------------------------------------------------------------------------
			default:
			{
				return MODULERESULT_UNKNOWN;
				//return CModule::ProcessMessage( $event, $data, $wparam, $lparam );
			}break;
			
			
		}//switch
		
		return 1;
	}	
};

?>