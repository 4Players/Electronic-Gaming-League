<?php
# ================================ Copyright � 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-


# -[ objectlist ] -
class callback_t
{
	var $paid			= 'unknown';
	var $functions		= array();
};


# -[ class ] -
class CallbackManager
{
	# -[ variables ]-
	var $bInit			= false;
	var $aCallbacks		= array();
	var $poVars			= NULL;
	var $sRoot			= '/';
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================

	/** 
	* CallbackManager::CallbackManager
	*/
	function CallbackManager ()
	{
	}//function 
	
	
	/**
	* CallbackManager::Init
	*/
	function Init( $root, &$poVars )
	{
		# load callbacks
		$this->poVars 	= &$poVars;	# save poiunter for calling callback functions
		$this->sRoot	= $root;
		
		$this->bInit 	= true;
		
		
		return true;
	}//function 
	
	
	/**
	* CallbackManager::Init
	*/
	function Call( $func='', $params=NULL )
	{
		if( !$this->bInit) return false;
		
		$filename = $this->sRoot;
		$aFuncList = explode( '.', $func );
		for( $i=0; $i < sizeof($aFuncList)-1; $i++ ) $filename .= $aFuncList[$i].EGL_DIRSEP;
		$filename .= $aFuncList[sizeof($aFuncList)-1].'.callback.php';

		if( isset( $this->aCallbacks[$func]) ) 
		{
			return $this->aCallbacks[$func]->call( array( $this->poVars, $params ) );
		}
		else 
		{
			if( $this->RegisterCallbackFile( $func, $filename ) )
			{
				if( isset( $this->aCallbacks[$func]) ) 
				{
					return $this->aCallbacks[$func]->call( array( $this->poVars, $params ) );
				}
				else 
				{
				}
			}//if
		}//if
		return NULL;
	}

	
	
	/**
	* CallbackManager::Init
	*/
	function CallbackExists( $func='' )
	{
		$filename = $this->sRoot;

		# create file
		$aFuncList = explode( '.', $func );
		for( $i=0; $i < sizeof($aFuncList)-1; $i++ ) $filename .= $aFuncList[$i].EGL_DIRSEP;
		$filename .= $aFuncList[sizeof($aFuncList)-1].'.callback.php';
		
		# last check
		return ( file_exists($filename) && $filename[strlen($filename)-1] != EGL_DIRSEP );
	}

	
	/**
	* CallbackManager::Init
	*/
	function RegisterCallback( $func, $filename, $functionname )
	{
		if( !isset($this->aCallbacks[$func]) )
		{
			$this->aCallbacks[$func] = FunctionLoaderFactory::LoadFunctionInstance( $filename, $functionname );
			return true;
		}//if
		else
		{
			DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "Couldn't load Callback function `{$func}` in `{$functionname}`, callback already exists " );
			return false;
		}
	}//function RegisterCallback
	
	
	
	/**
	* CallbackManager::Init
	*/
	function RegisterCallbackFile( $func, $filename )
	{
		$callback_structure_start = 0;//strlen('');
		$callback_structure_end = strlen('.callback.php');
		
		//$base_filename 	= basename($filename);
		// real functio name: FUNC-NAME.callback.php
		//$filefunc		= substr( $base_filename, $callback_structure_start, strlen($base_filename)-($callback_structure_start+$callback_structure_end) );;
		$functionname  	= 'callback';

		// file exists?		
		if( file_exists($filename) && $filename[strlen($filename)-1] != EGL_DIRSEP )
		{
			if( $this->RegisterCallback( $func, $filename, $functionname ) )
			{
				return true;	
			}
			else
			{
			}
		}//if
		else 
		{
		}
		return false;
	}//function RegisterCallback
	
	
	/**
	* CallbackManager::LoadCallbackListFromRoot
	*/
	/*
	
	---------------------
	currently not up to date. Last Modification - 14.08.06
	(1) section - func removed
	(2) dynamic func-list added
	
	function LoadCallbackListFromRoot( $root )
	{
		$cDir = new MyDirectory();
		if( $cDir->Open( $root ))
		{
			$aDirs 	= $cDir->GetDirs();
			$aFiles = $cDir->GetFiles();
			
			# load callbacks from filelist
			for( $f=0; $f < sizeof($aFiles); $f++)
			{
				//$this->RegisterCallbackFile( GetLastNodeDirname($root), $root.$aFiles[$f] );
				$this->RegisterCallbackFile( '', $root.$aFiles[$f] );
			}//for
			
			
			# load callbacklist from earch {paid}/ filelist
			for( $n=0; $n < sizeof($aDirs); $n++ )
			{
				$cSectionDir = new MyDirectory();
				$next_root = $root.$aDirs[$n].EGL_DIRSEP;
				if( $aSectionDir->Open($next_root) )
				{
					$aSectionFiles = $aSectionDir->GetFiles();
					for( $n2=0; $n2 < sizeof($aSectionFiles); $n2++)
					{
						$this->RegisterCallbackFile( GetLastNodeDirname( $root.$aDirs[$n]), $next_root.$aSectionFiles[$n2] );
					}//for
				}//if
				
			}//for 
			return true;
		}
		else
		{
			return false;
		}
	}//function 
	*/
	
};


?>