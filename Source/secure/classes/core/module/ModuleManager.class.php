<?php
# ============================== Copyright (c) 2004-2007 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-
define( "MODULE_ID_LENGTH",		36 );
define( "MODULEFILE_STATE",		"modules.ini" );



# -[ objectlist ] -
class module_t
{
	/*
		ID			 => module ID
		name 		=> module name
		version		=> module version
		description	=> module description
		module_path	=> module path
		module_class	=> module class --> callback function
	*/
	
	var $aParams		= array();
	var $ID				= 'unknown';
	var $sName			= 'unknown';
	var $sVersion		= 'unknown';
	var $sDevelopment	= 'unknown';
	var $sHomepage		= 'unknown';
	var $sDescription	= 'unknown';
	var $sModulePath	= 'unknown'; 
	var $sModuleFile	= 'unknown'; 
	var $sModuleClass	= 'unknown'; 
	var $sSourceConst	= '';
	var $iSize			= 0; /*bytes*/
	var $bActivated		= false;
	var $bInstalled		= false;
	var $cModule		= NULL;
	var $sClassedName	= 'unknown';
};



# -[ class ] -
class ModuleManager
{
	# -[ variables ]-
	var $aModules			= array();	
	var $pDBCon 			= NULL;

	# -[ functions ]-
	

	//-------------------------------------------------------------------------------
	// Purpose: constructor
	//-------------------------------------------------------------------------------
	function ModuleManager ( &$pDBCon )
	{
		$this->pDBCon 	= &$pDBCon;
	}	

	//-------------------------------------------------------------------------------
	// Purpose: initialise the whole cmod manager
	// Output : true/false
	//-------------------------------------------------------------------------------
	function Init()
	{
		$aErrors = array();
		
		# fetch right 
		$aModuleFileList = $this->GetModuleList( EGL_SECURE.'modules' );
		
		# try to load modules
		$iModuleCnt=0;
		$num_module_files = sizeof($aModuleFileList);
		for( $iMod=0; $iMod < $num_module_files; $iMod++ )
		{
			$module_file = EGL_SECURE.'modules'.DIRECTORY_SEPARATOR.$aModuleFileList[$iMod];
			
			$pCTmpMod = new module_t;
			
			# ====================================32+6
			# load cfg-file of current cmod
			# ====================================
			
			# read params
			# fileexits already checked in CCModManager::GetModlist

			# fetch informations from initfile
			$pCTmpMod->aParams 			= parse_ini_file( $module_file );
			$pCTmpMod->bActivated 		= false;
			$pCTmpMod->bInstalled 		= false;
			$pCTmpMod->sModulePath 		= $pCTmpMod->aParams['module_path'];
			$pCTmpMod->sModuleFile 		= $pCTmpMod->aParams['module_file'];
			$pCTmpMod->sModuleClass 	= $pCTmpMod->aParams['module_class'];			
		
			# ====================================
			# FILE CHECK
			# ====================================
			
			# ...
			# ...
			
			# ====================================
			# load main.php => main part of cmod
			# 				=> including all other necessary files
			# ====================================

			# only if installed

			# check class
			$module_class_inc = MODULE_DIR . $pCTmpMod->sModulePath . DIRECTORY_SEPARATOR . $pCTmpMod->sModuleFile;
			
			# -------------------------
			# include cmod class => file
			# -------------------------
			if( file_exists($module_class_inc) )	
			{
				require_once($module_class_inc);
			}
			
			# otherwise skip this file
 			else 
			{
				$aErrors[sizeof($aErrors)] = "Couldn't load '{$pCTmpMod->sModuleClass}' ";
				DEBUG( MSGTYPE_ERROR,__FILE__, __LINE__, "Couldn't load Module [$module_class_inc] not found");
				continue;	# skip file
			}
			
			
			# get data 
			$module_data = new module_data_request_t;
			#if( Isset($pCMod) ) unset($pCMod);
			#$cTempCMod = NULL;


			
			# define class => fetch informations
			if( declare_class( $pCTmpMod->cModule, $pCTmpMod->sModuleClass ) )
			{
				if( $pCTmpMod->cModule->ProcessMessage( 'info', $module_data ) )
				{
					$pCTmpMod->ID 				= $module_data->ID;
					$pCTmpMod->sName 			= $module_data->sName;
					$pCTmpMod->sVersion			= $module_data->sVersion;
					$pCTmpMod->sDescription 	= $module_data->sDescription;
					$pCTmpMod->sDevelopment 	= $module_data->sDevelopment;
					$pCTmpMod->sHomepage 		= $module_data->sHomepage;
					$pCTmpMod->sSourceConst 	= $module_data->sSourceConst;
					$pCTmpMod->sClassedName		= strtoupper( ModuleManager::GetClassedName( get_class($pCTmpMod->cModule) ) );
					
					# right syntax data
					if( strlen($pCTmpMod->sName) > 0 && module_checkid($pCTmpMod->ID) )
					{
					
						#------------------------------------------------------------
						# inc
						# finally add to cmodlist
						#------------------------------------------------------------
						if( !$this->GetModule($pCTmpMod->ID) )
						{
							
							/*CHANGED */
							$this->aModules[$iModuleCnt] = $pCTmpMod;
							
							# incl cmodule counter
							$iModuleCnt++;
						}//if cmod exists ?
						else
						{
							DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couln't load Module [{$module_class_inc}], ID [{$pCTmpMod->ID}] currently in use" );
							continue;
						}//if
					}//if
					else 
					{
						DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couln't load Module [{$cmod_class_inc}], ID [{$pCTmpMod->ID}] invalid ID" );
						Unset($pCTmpMod);
						# ERROR
					}
				}//if
			}//if
			else
			{
				DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couln't declare Module-Class  [{$module_class_inc}], ID [{$pCTmpMod->sModuleClass}] currently in use" );
				continue;
			}
			
		}//for

		return 1;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: releases memory + sends unload message
	// Output : true/flase
	//-------------------------------------------------------------------------------		
	function Release()
	{
		return $this->UnloadModules();
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: create/load cmod callback functions
	// Output : true/flase
	//-------------------------------------------------------------------------------	
	function LoadModules()
	{
		$a_ini_params = $this->GetModuleini();	# load cmod ini file	(PARAMS)
		$aInstalledModules = explode( ',', $a_ini_params['modules_installed'] );	# convert cmods to an array format
		$aActivatedModules = explode( ',', $a_ini_params['modules_activated'] );	# convert cmods to an array format
		
	
		# load modules
		$num_installed_modules = sizeof($aInstalledModules);
		for( $i=0; $i < $num_installed_modules; $i++ )
		{
			$oModule = &$this->GetModule( $aInstalledModules[$i] );
			$oModule->bInstalled = true;			# load single module
	
			
			# check whether the current module is activated ?
			$num_activated_modules = sizeof($aActivatedModules);
			for( $k=0; $k < $num_activated_modules; $k++ )
			
				# only load cmod if its activated
				if( $aActivatedModules[$k] == $aActivatedModules[$i] )
				{
					# load cmod => if activated
					if( $this->LoadModule( $aActivatedModules[$k] ) )
					{
						# send 'load' message
						$this->SendMessage( $aActivatedModules[$i], 'load', $oModule->aParams );
				
					}//if
					else 	
					{
						# ERROR
						DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couln't load Module [ID:{$aActivatedModules[$k]}] " );
						continue;
					}//if
				}//if
		}//for
		# finally sort modules
		#uasort( $this->aCMods, "sort_cmods"  );
		return true;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------	
	function UnloadModules()
	{
		
		$num_modules = sizeof($this->aModules);
		for( $i=0; $i < $num_modules; $i++ )
		{
			if( $this->aModules[$i]->bActivated )
			{
				 $this->aModules[$i]->cModule->ProcessMessage( 'unload', $__DATA__ );
				 $this->UnloadModule( $this->aModules[$i]->ID );
			}
		}//for
		return true;
	}//unloadmodules
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------	
	function LoadModule( $ID )
	{
		$pModule = &$this->GetModule( $ID );
		
		if( !$pModule ) return false;
		if( $pModule->bActivated ) return false;
		
		
		/*
		ACHTUNG: wird bereits in  INIT() geladen !!!
		
		----------------------------------------------------------------
		# create callback class
		if( declare_class( $pcMod->cCMod, $pcMod->sCModClass ) )
		{
			# init module
			$pcMod->->Init( $this->pDBCon );	
			
		
			# set cmod to initialised
			$pcMod->bActivated = true;
			
			return true;
		}//if
		*/
		
		
		# init cmod
		$pModule->cModule->Init( $this->pDBCon );	
			
		
		# set cmod to initialised
		$pModule->bActivated = true;
			
		return true;

		/*
		return false;*/
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------	
	function UnloadModule( $cmid )
	{
		$pcMod = &$this->GetModule( $cmid );
		if( !$pcMod ) return false;
		if( !$pcMod->bActivated ) return false;
		
		# send 'unload' message
		#$cMod->cCMod->ProcessMessage( 'unload', $__DATA__ );		

		Unset( $pcMod->cModule );
		$pcMod->bActivated = false;
		
		return true;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------	
	function InstallModule( $ID )
	{
		
		$pModule = &$this->GetModule( $ID );
		if( !$pModule ) return false;		# does the mod exists ?
		if( $pModule->bInstalled ) return false;	# currenty initialised
		
		
		# try loading cMod
		if( $this->LoadModule( $ID ) )
		{
			# send install message
			$pModule->cModule->ProcessMessage( 'install', $__DATA__ );
			
			# get ini data
			$init_params = $this->GetModuleini();
			
			# get installed data
			$aModules = db_read_array_string( $init_params['modules_installed'] );
			
			# add item
			$aModules[sizeof($aModules)] = $ID;
			
			# create ini data
			$new_params['modules_installed'] = db_create_array_string($aModules);
			
			# write new init file
			$this->WriteModuleini( $new_params );
			
			
			# $cMod 'load' event to cmod
			# $cMod->cCMod->ProcessMessage( 'load', $cMod->aParams );
			
		}//if
		return true;
	}//InstallcMod
	

	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------	
	function UninstallModule( $ID )
	{
		$pModule = &$this->GetModule( $ID );
		if( !$pModule ) return false;		# does the mod exists ?
		if( !$pModule->bInstalled ) return false;	# currenty initialised
		if( $pModule->bActivated ) return false;	# currenty activated ?


		# send uninstall message
		// $this->SendMessage( $ID, 'uninstall', $__DATA__ );	# funktioniert nicht, da man nicht aktivierten modulen keine nachrichten schicken kann.?
		$pModule->cModule->ProcessMessage( 'uninstall', $__DATA__ );
		
		
		# unload module
		$this->UnloadModule( $ID );
		#----------------------------------------------
		# save new installed cmods
		#----------------------------------------------
		
		
		# get ini data
		$init_params = $this->GetModuleini();
			
		# get installed data
		$aInstalledModules = db_read_array_string( $init_params['modules_installed'] );
		$aActivatedModules = db_read_array_string( $init_params['modules_activated'] );

		# delete installed item
		$num_installed_modules = sizeof($aInstalledModules);
		for( $i=0; $i < $num_installed_modules; $i++ )
			if( $aInstalledModules[$i] == $ID )
				DeleteItemOfArray( $aInstalledModules, $i );
				
		# delete activated item
		$num_activated_modules = sizeof($aActivatedModules);
		for( $i=0; $i < $num_activated_modules; $i++ )
			if( $aActivatedModules[$i] == $ID )
				DeleteItemOfArray( $aActivatedModules, $i );				
	
		# create ini data	
		$new_params['modules_installed'] = db_create_array_string($aInstalledModules);		
		$new_params['modules_activated'] = db_create_array_string($aActivatedModules);		
		
		# write new init file
		$this->WriteModuleini( $new_params );
		
		return true;
	}//uninstallcmod
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------		
	function ActivateModule( $ID )
	{
		$oCMod = &$this->GetModule( $ID );		
		if( !$oCMod ) return false;		# does the mod exists ?
		if( !$oCMod->bInstalled ) return false;	# currenty initialised
		if( $oCMod->bActivated ) return false; # already activated ?
		
		# load cmod
		if( !$this->LoadModule( $ID ) ) return false;

		# send load message
		$this->SendMessage( $ID, 'load', $oCMod->aParams /* Parametes saved in cmod_file.ini*/ );
		
		# get ini data
		$init_params = $this->GetModuleini();
		
		# read current activated cmods
		$aActivatedModules = db_read_array_string($init_params['modules_activated']);

		
		# add new module
		$aActivatedModules[sizeof($aActivatedModules)] = $ID;
			
		# create ini data
		$new_params['modules_activated'] = db_create_array_string( $aActivatedModules);		
		
		# save 
		# write new init file
		$this->WriteModuleini( $new_params );
		
		return true;
	}
	

	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------		
	function DeactivateModule( $ID )
	{
		$oCMod = &$this->GetModule( $ID );		
		if( !$oCMod ) return false;		# does the mod exists ?
		if( !$oCMod->bInstalled ) return false;	# currenty initialised
		if( !$oCMod->bActivated ) return false; # activated ?		
		
		# send unload message
		$this->SendMessage( $ID, 'unload', $__DATA__ );

		# unload cmod
		if( !$this->UnloadModule( $ID ) ) return false;

		# get ini data
		$init_params = $this->GetModuleini();		
			
		# read current activated cmods
		$aActivatedModules = db_read_array_string($init_params['modules_activated']);
		
		# delete activated item
		for( $i=0; $i < sizeof($aActivatedModules); $i++ )
			if( $aActivatedModules[$i] == $ID )
				DeleteItemOfArray( $aActivatedModules, $i );
				
		# create ini data
		$new_params['modules_activated'] = db_create_array_string( $aActivatedModules);		
		
		# save 
		# write new init file
		$this->WriteModuleini( $new_params );				
		
		return true;
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: gets a list of files containing the cmod directory
	// Output : array
	//-------------------------------------------------------------------------------	
	function GetModuleList( $module_root )
	{
		$aModules = array();
		
		# open dir 
		$cDir = new MyDirectory();
		if( $cDir->Open( $module_root ) )
		{
			$aModules = $cDir->GetFiles( array('mod') );
			$cDir->Close();
		}// open dir
		else 
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't read modulelist from {$module_root}" );
		}
		return $aModules;
	}
	

	/*
	//-------------------------------------------------------------------------------
	// Purpose: posts a message to a module with parameter, identified by $id
	// Output : mixed
	//-------------------------------------------------------------------------------
	function PostMessage( $cmid,  $event, &$data  )
	{
	}*/
	
	
	//-------------------------------------------------------------------------------
	// Purpose: sends a message to a cmod with overgiven parameter, identified by $cmid
	// Output : mixed
	//-------------------------------------------------------------------------------
	function SendMessage( $ID, $event, &$data, $wparam=NULL, $lparam=NULL )
	{

		# sen d to all cmods
		if( $ID == -1 )
		{
			# send message to each cmod
			$num_modules = sizeof($this->aModules);
			for( $i=0; $i < $num_modules; $i++ )
			{
				// module activated
				if( $this->aModules[$i]->bActivated )
				{
					// try sending eventmessage
					$result = $this->aModules[$i]->cModule->ProcessMessage( $event, $data, $wparam, $lparam );

					// unknown result received
					if( $result == MODULERESULT_UNKNOWN )
					{
						// DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "<b>Warning:</b> SendMessage '$event' to Module : From ID:$ID invalid results received.");
					}
					//return $result;
				}//if
				else
				{
					//DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "Couldn't send message \"{$event}\" to [{$this->aModules[$i]->ID}] {{$this->aModules[$i]->sName}} - module not activated");
					continue;
				} //if
			}//for
			
			// module not found ?
			//DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "Couldn't send message \"{$event}\" to [{$this->aModules[$i]->ID}] {{$this->aModules[$i]->sName}} - no modules available ");
			return true;
		}
		else 
		{
			$oModule = $this->GetModule( $ID );
			
			// module found?
			if( !$oModule ) 
			{
				DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "Couldn't send single message \"{$event}\" to [$ID] {{$oModule->sName}} - module not found ");
				return 0;
			}
			// module activated?
			if( !$oModule->bActivated )
			{
				DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "Couldn't send single message \"{$event}\" to [$ID] {{$oModule->sName}} - module not activated");
				return 0;
			}
			
			# send message
			return $oModule->cModule->ProcessMessage( $event, $data, $wparam, $lparam );
		}//if
		return false;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: returns a list of loaded cmods
	// Output : array
	//-------------------------------------------------------------------------------
	function GetModules()
	{
		return $this->aModules;
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: searches right cmod by id
	// Output : array
	//-------------------------------------------------------------------------------
	function & GetModule( $ID )
	{
		$num_modules = sizeof($this->aModules);
		for( $i=0; $i < $num_modules; $i++ )
			if( $this->aModules[$i]->ID == $ID )
					return $this->aModules[$i];
		return NULL;
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: searches right cmod by id
	// Output : array
	//-------------------------------------------------------------------------------
	function ModuleAvailable( $ID )
	{
		$num_modules = sizeof($this->aModules);
		for( $i=0; $i < $num_modules; $i++ )
			if( $this->aModules[$i]->ID == $ID && $this->aModules[$i]->bActivated  )
					return true;
		return false;
	}
		
	
	//-------------------------------------------------------------------------------
	// Purpose: searches right cmod by const
	// Output : array
	//-------------------------------------------------------------------------------
	function & GetModuleByConst( $const )
	{
		for( $i=0; $i < sizeof($this->aModules); $i++ )
		{
			if( $this->aModules[$i]->sSourceConst == $const )
			{
				return $this->aModules[$i];
			}//if
		}//for
		return NULL;		
	}
	
	
	# =========================================================================
	# GET ACTIVATED MODULES
	# =========================================================================	
	function GetActivatedModules()
	{
		$aModules = array();
		for( $i=0; $i < sizeof($this->aModules); $i++ )
		{
			if( $this->aModules[$i]->bActivated )
			{
				/* POINTER ?? ! */
				$aModules[sizeof($aModules)] = $this->aModules[$i];
			}//if
		}//for
		return $aModules;
	}
	
	
	# =========================================================================	
	# GET ACTIVATED MODULES
	# =========================================================================	
	function GetClassedName( $class_name )
	{
		$num = strlen("module_");
		return substr( $class_name, $num, strlen($class_name)-$num);
	}
	
	# =========================================================================	
	# get module by classedname
	# =========================================================================	
	function GetModuleByClassedName( $classed_name )
	{
		$aModules = $this->GetActivatedModules();
		for( $i=0; $i < sizeof($aModules); $i++ )
			if( $aModules[$i]->sClassedName == strtoupper($classed_name) )
				return $aModules[$i];
		return NULL;
	}
	
	
	

	# =========================================================================
	# INI FLE CONFIGURATION MANAGEMENT
	# =========================================================================	
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output : ini file content
	//-------------------------------------------------------------------------------
	function GetModuleini()
	{
		$s_module_ini_file = EGL_SECURE . MODULEFILE_STATE;
		return parse_ini_file( $s_module_ini_file );
		#return db_read_array_string( $aCMod_ini['cmods_installed'] );
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------	
	function WriteModuleini( $params )
	{
		$s_module_ini_file = EGL_SECURE . MODULEFILE_STATE;
		$aModule_ini = parse_ini_file( $s_module_ini_file );
		
		# open ini file
		# => write new data
		$cFile = new File();
		if( $cFile->Open( $s_module_ini_file, "wb" ) )
		{
			while( list($var_name, $var_value) = each($aModule_ini) ) 
			{
				# overwrite ??
				if( Isset( $params[$var_name] ) )
				{
					$str_line =  $var_name . " = \"" . $params[$var_name]."\"\n";
					$cFile->Write( $str_line );
				}
				else 
				{
					$str_line = $var_name . " = \"" .$var_value."\"\n";
					$cFile->Write( $str_line );
				}//if
			}//while
			
			$cFile->Close();
		}
		else 
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't find module-state file in [".MODULEFILE_STATE."] " );
		}
	}//WriteModuleini
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------	
	function GetModuleRoot( $module_id ){
		$oModule = $this->GetModule( $module_id );
		if( $oModule ){
			return EGL_SECURE.'modules'.EGL_DIRSEP.$oModule->sModulePath.EGL_DIRSEP;
		}
		return 'unknown_module';
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------	
	function ModuleActivated( $module_id ){
		$aModules = $this->GetActivatedModules();
		for( $i=0; $i < sizeof($aModules); $i++ )
			if( $aModules[$i]->ID == $module_id )
				return true;
		return false;
	}//if
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------	
	function GetModuleRootByParam( $oVars, $module_id, $workspace='' )
	{
		if( isset($oVars->cModuleManager))
		{
			$oModule = $oVars->cModuleManager->GetModule( $module_id );
			if( $oModule )
			{
				if( $workspace == '' )
					return EGL_SECURE.'modules'.EGL_DIRSEP.$oModule->sModulePath.EGL_DIRSEP;
				else
					return EGL_SECURE.'modules'.EGL_DIRSEP.$oModule->sModulePath.EGL_DIRSEP.'workspaces'.EGL_DIRSEP.$workspace.EGL_DIRSEP;
			}
		}
		return 'error';
	}	
};

?>