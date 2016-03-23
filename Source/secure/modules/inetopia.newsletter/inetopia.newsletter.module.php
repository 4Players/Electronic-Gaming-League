<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


define( "MODULEID_INETOPIA_NEWSLETTER",		"84B8331B-03E5-4f1b-9967-D77A569AAF9F" );



egl_require( dirname(__FILE__) . '/classes/InetNewsletter.class.php' );


class module_inetopia_newsletter extends Module
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
					$data->ID 				= MODULEID_INETOPIA_NEWSLETTER;
					$data->sName 			= "Newsletter";
					$data->sVersion 		= "1.0";
					$data->sDevelopment 	= "Inetopia";
					$data->sHomepage 		= "http://www.inetopia.de";
					$data->sDescription		= "Newsletter mailing system ";
					//$data->sSourceConst		= "modconst_news";
					
					# localize cmod data
					$this->oInfos = $data;
				
					return 1;
				}
			}break;
			case 'load':
			{
				#save params
				$this->aParams = $data;
			
				return 1;
			}break;
			case 'unload':
			{
				return 1;
			}break;
			case 'install':
			{
				# install tables
				
				return $this->SQLInstall();
			}break;
			case 'uninstall':
			{

				return $this->SQLUninstall();
				# uninstall tables
			}break;
			
			
			case 'reset':
			{

				return $this->SQLReset();
				# uninstall tables
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
			#			$lparam => $gl_oVars->bCModActivated
			#  Output:  *true/false
			#-----------------------------------------------------------------------------------------------------
			case 'exec_template':
			{
				global $gl_oVars;
				
				/*
					$data =>  Workspace
					$wparam => $page_tpl
					$lparam => $ModuleID
				*/
				
				# ----------------------------------------
				# 
				#
				# ----------------------------------------
				if( $data == 'hp' )
				{
					
									
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
			case 'add_email':
			{
				global $gl_oVars;
				$cNewsletter = new InetNewsletter( $gl_oVars->cDBInterface, "egl_inetopia_newsletter" );
				
				$email = $wparam;
				// check email??
				if( !$cNewsletter->MailExists($email))
				{
					$cNewsletter->AddMail( array( "code" => CreateRandomPassword(20),
												  "email" => $email,
												  "created" => EGL_TIME ) );
					return 1;
				}else return 0;
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
				
				return PAGEACCESS_FAILED;
			}break;
			
			#=============================================================================================================	
			#=============================================================================================================	
			#=============================================================================================================	
			#================  SPECIAL MESSAGE EVENTS                                                 ====================	
			#=============================================================================================================	
			#=============================================================================================================	

		
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
	
	
	
	
	#-----------------------------------------------------------------------------------------------------
	# Purpose: execute sql installation
	#  Output: true/false
	#-----------------------------------------------------------------------------------------------------
	function SQLInstall()
	{
		$sql_newsletter_list 
				= 'CREATE TABLE `egl_inetopia_newsletter` ('
		        . ' `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, '
		        . ' `code` VARCHAR(40) NOT NULL, '
		        . ' `email` VARCHAR(255) NOT NULL, '
		        . ' `num_mails` INT NOT NULL, '
		        . ' `created` INT NOT NULL'
		        . ' )'
		        . ' TYPE = innodb'
		        . ' COMMENT = \'EGL - Inetopia Newsletterlist\';';
		        
		$sql_newsletter_drafts 
				= 'CREATE TABLE `egl_inetopia_newsletter_drafts` ('
		        . ' `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, '
		        . ' `type` VARCHAR(255) NOT NULL, '
		        . ' `from_name` VARCHAR(255) NOT NULL, '
		        . ' `from_email` VARCHAR(255) NOT NULL, '
		        . ' `title` VARCHAR(255) NOT NULL, '
		        . ' `text` TEXT NOT NULL, '
		        . ' `signature` VARCHAR(255) NOT NULL, '
		        . ' `distribution_enabled` INT NOT NULL DEFAULT \'0\', '
		        . ' `created` INT NOT NULL DEFAULT \'0\''
		        . ' )'
		        . ' TYPE = innodb'
		        . ' COMMENT = \'EGL - Inetopia Newsletter Drafts\';';
		        
		global $gl_oVars;
		
		
		// interface correct?
		if( $gl_oVars->cDBInterface )
		{
			if( $gl_oVars->cDBInterface->Query( $sql_newsletter_list ) )
			{
				if( $gl_oVars->cDBInterface->Query( $sql_newsletter_drafts ) )
				{
					return 1;
				}
			}
			else
			{
			}
		}
		else
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't execute SQL install by Module [".$this->oInfos->ID."] - DBInterface not initialised" );
		}
		return 0;
	}
	
	
	
	#-----------------------------------------------------------------------------------------------------
	# Purpose: execute sql uninstallation
	#  Output: true/false
	#-----------------------------------------------------------------------------------------------------
	function SQLUninstall()
	{
		$sql_1 = 'DROP TABLE `egl_inetopia_newsletter`';
		$sql_2 = 'DROP TABLE `egl_inetopia_newsletter_drafts`';
		
		global $gl_oVars;
		
		// interface correct?
		if( $gl_oVars->cDBInterface )
		{
			if( $gl_oVars->cDBInterface->Query( $sql_1 ) )
			{
				if( $gl_oVars->cDBInterface->Query( $sql_2 ) )
				{
					return 1;
				}//if
			}//if
		}
		else
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't execute SQL uninstall by Module [".$this->oInfos->ID."] - DBInterface not initialised" );
		}
		return 0;
	}
	
	
	
	
	#-----------------------------------------------------------------------------------------------------
	# Purpose: execute sql uninstallation
	#  Output: true/false
	#-----------------------------------------------------------------------------------------------------
	function SQLReset()
	{
		$sql_1 = 'TRUNCATE TABLE `egl_inetopia_newsletter`';
		$sql_2 = 'TRUNCATE TABLE `egl_inetopia_newsletter_drafts`';
		
		
		global $gl_oVars;
		
		// interface correct?
		if( $gl_oVars->cDBInterface )
		{
			if( $gl_oVars->cDBInterface->Query( $sql_1 ) )
			{
				if( $gl_oVars->cDBInterface->Query( $sql_2 ) )
				{
					return 1;
				}//if
			}//if
		}
		else
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't execute SQL reset by Module [".$this->oInfos->ID."] - DBInterface not initialised" );
		}
		return 0;
	}
	
	
};

?>