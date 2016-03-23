<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================




# -[ defines ]-




# -[ class ] -
class Document
{
	# -[ variables ]-
	var $oVars		= NULL;
	
	# -[ functions ]-
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	//-------------------------------------------------------------------------------
	function Document ( &$vars )
	{
		$this->oVars = &$vars;
	}

	
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	//  Output: 
	//-------------------------------------------------------------------------------
	function ConfigurePage()
	{
		# send 'page_init' event to modules
		module_sendmessage( -1, 'page_init', $__DATA__ );
		
		
		#===================================================================================================================
		# PAGE
		#===================================================================================================================
		
		$this->oVars->cTpl->assign( 'URL_ROOT',	$this->oVars->sURLDomainRoot );
		$this->oVars->cTpl->assign( 'url_file',	$this->oVars->sURLFile.'?' );
		if( $this->oVars->bModuleActivated )
		{
			$this->oVars->cTpl->assign( 'url_page',	$this->oVars->sModuleId.':'.$this->oVars->sURLPage );
		}
		else 
			$this->oVars->cTpl->assign( 'url_page', $this->oVars->sURLPage );

		$module_tpl = '';
		$module_doc = '';
		
		$bPageAccessFileLoaded 	= false;
		//$bPageAccessFileLoaded	= false;
		
		
		# ---------------------------------------------------
		# LOAD MODULE FILE
		# ---------------------------------------------------
		if( $this->oVars->oModule->bInstalled /*$this->oVars->bModuleActivated*/ )
		{
			$sModuleRoot = MODULE_DIR . $this->oVars->oModule->sModulePath. EGL_DIRSEP;
			
			# write template/document data to Smarty	|| loading documents
			/*$page_tpl = $sModuleRoot . 'templates/'.$this->oVars->sWorkspace.'/'.$this->oVars->sURLPage.'.tpl';
			$page_doc = $sModuleRoot . 'documents/'.$this->oVars->sWorkspace.'/'.$this->oVars->sURLPage.'.doc.php';*/
			
			$page_tpl = $sModuleRoot . 'workspaces'.EGL_DIRSEP.$this->oVars->sWorkspace.EGL_DIRSEP.'templates'.EGL_DIRSEP.EGL_REAL_LOCATION($this->oVars->sURLPage).'.tpl';
			$page_doc = $sModuleRoot . 'workspaces'.EGL_DIRSEP.$this->oVars->sWorkspace.EGL_DIRSEP.'documents'.EGL_DIRSEP.EGL_REAL_LOCATION($this->oVars->sURLPage).'.doc.php';
			
			
			# ONLY FOR ADMIN PANEL
			if( $this->oVars->sWorkspace == 'admin' )
			{
				
				# save current module file
				
				$module_tpl = $page_tpl;
				$module_doc = $page_doc; 
				
				
				# set base cmod file /modules/{MODULE_ID}/workspaces/admin/templates/main.tpl !!!
				
				$page_tpl = $sModuleRoot . 'workspaces'.EGL_DIRSEP.$this->oVars->sWorkspace.EGL_DIRSEP.'templates'.EGL_DIRSEP.'main.tpl';
				$page_doc = $sModuleRoot . 'workspaces'.EGL_DIRSEP.$this->oVars->sWorkspace.EGL_DIRSEP.'documents'.EGL_DIRSEP.'main.doc.php';
			}//if
			

		
			# setup module_id loaded			
			$this->oVars->cTpl->assign( 'CURRENT_MODULE_ID',	$this->oVars->sModuleId );
			

			// load access file
			$sPageAccessFilename = FIX_URL_SEP( $sModuleRoot . 'workspaces'.EGL_DIRSEP.$this->oVars->sWorkspace.EGL_DIRSEP.'gc'.EGL_DIRSEP.'pageaccess.gc' );
			
			//echo $sPageAccessFilename;
			if( file_exists($sPageAccessFilename))
			{
				# set PageAcces file
				if( !$this->oVars->cPageAccess->SetAccessFile ( $sPageAccessFilename ) )
				{
					// error
					DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't load PageAccess file `".$sPageAccessFilename.'`' );
				}else $bPageAccessFileLoaded=true;
			}
			else
			{
				DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "PageAccess file in module `{$this->oVars->oModule->sName}#`{$this->oVars->oModule->ID}` not found - ".$sPageAccessFilename."`" );
			}
			
			
			
			# ----------------------------------------------------------
			# ----------------------------------------------------------
			# Try loading cMod language-File
			# ----------------------------------------------------------
			# ----------------------------------------------------------
			if( !$this->oVars->cLanguage->ParseFile( $sModuleRoot.'workspaces'.EGL_DIRSEP.$this->oVars->sWorkspace.EGL_DIRSEP.'languages'.EGL_DIRSEP, $this->oVars->aLngBuffer['module'] ) )
			{
				DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "Couldn't load module language file" );
			} else DEBUG( MSGTYPE_INFO, __FILE__, __LINE__, "Module language file loaded." );			
			
			
		}//if
		
		
		# ---------------------------------------------------
		# LOAD EGL-SOFTWARE FILE
		# ---------------------------------------------------
		else
		{
		
			# write template/document data to Smarty	|| loading documents
			/*$page_tpl = EGL_SECURE . 'templates/'.$this->oVars->sWorkspace.'/'.$this->oVars->sURLPage.'.tpl';
			$page_doc = EGL_SECURE . 'documents/'.$this->oVars->sWorkspace.'/'.$this->oVars->sURLPage.'.doc.php';*/
			
			$page_tpl = WORKSPACE_DIR.$this->oVars->sWorkspace.EGL_DIRSEP.'templates'.EGL_DIRSEP.EGL_REAL_LOCATION($this->oVars->sURLPage).'.tpl';
			$page_doc = WORKSPACE_DIR.$this->oVars->sWorkspace.EGL_DIRSEP.'documents'.EGL_DIRSEP.EGL_REAL_LOCATION($this->oVars->sURLPage).'.doc.php';
			


			$this->oVars->cTpl->assign( 'url_file',	$this->oVars->sURLFile.'?' );
			$this->oVars->cTpl->assign( 'url_page',	$this->oVars->sURLPage );

			
			// load access file
			//$sPageAccessFilename = FIX_URL_SEP( $sModuleRoot . '/'.$this->oVars->sWorkspace.'/gc/pageaccess.gc' );
			$sPageAccessFilename = FIX_URL_SEP( WORKSPACE_DIR . $this->oVars->sWorkspace.EGL_DIRSEP.'gc'.EGL_DIRSEP.'pageaccess.gc' );
			if( file_exists( $sPageAccessFilename ))
			{	
				if( !$this->oVars->cPageAccess->SetAccessFile ( $sPageAccessFilename ) )
				{
					DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't load PageAccess file `".$sPageAccessFilename."`" );
				}//else
				else $bPageAccessFileLoaded = true;
			}
			else
			{
				DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "PageAccess file in module `{$this->oVars->oModule->ID}` not found - ".$sPageAccessFilename."`" );
			}//if
		}		
		
		
		# provide current pagedir to tempalte-files			
		$this->oVars->cTpl->assign( 'page_dir', 		dirname( $page_tpl ));
		$this->oVars->cTpl->assign( 'PAGE_DIR', 		dirname( $page_tpl ));
		
		
		#------------------------------------------------------------------------------
		# load PAM data & try evaluation
		#------------------------------------------------------------------------------
		$iPageAccess = PAGEACCESS_FAILED;
		
		/***********************
		normaly it returns true(1)  -> according to the current workspace
		Wird schon bereits von der Runtime-Engine der access verboten? => Normalerweise NEIN (d.h. access=1)
		***********************/
		if( $this->oVars->pcRuntimeEngine->PageAccessCheck() )
		{
			// Evaluate 
			if( $bPageAccessFileLoaded )
			{
				if( ($iPageAccess=$this->oVars->cPageAccess->Evaluate( 	$this->oVars->sWorkspace, 
																		$this->oVars->bLoggedIn, 
																		$this->oVars->sURLPage, 
																		(int)$_GET['clan_id'], 
																		(int)$_GET['team_id'], 
																		$this->oVars->sModuleId )	) == PAGEACCESS_OK )
				{
					# success	
				}
				else
				{
					//$page_tpl = WORKSPACE_DIR.$this->oVars->sWorkspace.EGL_DIRSEP.'templates'.EGL_DIRSEP.'error.tpl';
					//$page_doc = WORKSPACE_DIR.$this->oVars->sWorkspace.EGL_DIRSEP.'documents'.EGL_DIRSEP.'error.doc.php';
				}
			}//if pageaccess file loaded
			else
			{
				// keine page access datei gefunden
				// => automatischer access
				$iPageAccess = PAGEACCESS_OK;
				//echo "test";
			}
		}//if access denied by runtimeengine ??,
	
		
		
		if( $iPageAccess == PAGEACCESS_FAILED )
		{
			$page_tpl = WORKSPACE_DIR.$this->oVars->sWorkspace.EGL_DIRSEP.'templates'.EGL_DIRSEP.'error.tpl';
			$page_doc = WORKSPACE_DIR.$this->oVars->sWorkspace.EGL_DIRSEP.'documents'.EGL_DIRSEP.'error.doc.php';
		}
		
			
		#--------------------------------------------------------
		# set file tempate file
		#--------------------------------------------------------
		if( $this->oVars->cTpl->template_exists( $page_tpl ) )
		{
			$bModule	= false;	
			$this->oVars->cTpl->assign( 'page_file',	$page_tpl );
			
			
			# load cmod tpl if neccessary
			if( strlen($module_tpl) > 0 )
			{
				if( $this->oVars->cTpl->template_exists( $module_tpl ) )	
				{
					$this->oVars->cTpl->assign( 'module_file', $module_tpl );
					$bModule = true;
				}//if
			}//if
			
			# send to ALL
			# EVENT: 'execute_document'
			module_sendmessage( -1, 'exec_document', $this->oVars->sWorkspace, $page_doc, $this->oVars->sModuleId );
			
			
			
			
			# -----------------------------------------------
			# template found ? => require document data
			# -----------------------------------------------
			if( !$bModule )
			{
				if( file_exists( $page_doc ) )
				{
					# INCLUDE
					if( !$this->save_include( $page_doc ) )
					{
						// save include done
					}//if
				}//if
			}
			else
			{
				# load module doc if neccessary
				if( file_exists( $module_doc ) )
				{
					$this->save_include( $module_doc );
				}//if
			
			}			
			


			# to all cmods	
			# EVENT: 'execute_template'
			module_sendmessage( -1, 'exec_template', $this->oVars->sWorkspace, $page_tpl,  $this->oVars->sModuleId );
			
			
			# ---------------------------------------------
			# generate module-attachment
			# ---------------------------------------------
			$cAttachmentEngine = new AttachmentEngine( $this->oVars );
			$sAttachedCode = $cAttachmentEngine->GenerateModuleAttachment( $this->oVars->sWorkspace, $this->oVars->sURLPage );
			
			# assign attached content to general template / design-teampalte			
			$this->oVars->cTpl->assign ( 'ATTACHED_CONTENT', $sAttachedCode );
			
		} // else
		else  
		{
			$page_tpl	= WORKSPACE_DIR . $this->oVars->sWorkspace.EGL_DIRSEP.'templates'.EGL_DIRSEP.'home.tpl';
			$page_doc	= WORKSPACE_DIR . $this->oVars->sWorkspace.EGL_DIRSEP.'documents'.EGL_DIRSEP.'home.doc.php';
			
			# send to all mods
			module_sendmessage( -1, 'exec_document', $this->oVars->sWorkspace, $page_doc, $this->oVars->sModuleId );
			
			
			if( file_exists( $page_doc ) )
			{
				$this->save_include( $page_doc );
			}//if

			# set fiule
			$this->oVars->cTpl->assign( 'page_file', $page_tpl );

			# send template execution
			module_sendmessage( -1, 'exec_template', $this->oVars->sWorkspace, $page_tpl, $this->oVars->sModuleId );
		}//if
		
		
		return 1;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: include document/php file, wihout var access
	//  Output: 
	//-------------------------------------------------------------------------------
	function save_include( $page_doc )
	{
		include( $page_doc );
	}
};

?>