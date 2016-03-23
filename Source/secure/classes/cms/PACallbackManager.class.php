<?php
/*
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
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

class func_callback_function_t
{
	var $filename		= '';
	var $functionname	= 'unknown';
	var $pafunc			= '';
	
	function call()
	{
		if( function_exists($this->functionname) )
		{
			global $gl_oVars;
			return call_user_func( $this->functionname, $gl_oVars );
		}else return false; //'unknown function';
	}//function call()
};



# -[ class ] -
class CallbackManager
{
	# -[ variables ]-
	var $bInit			= false;
	var $aCallbacks		= array();
	//var $numCallbacks	= 0;
	var $poVars			= NULL;
	var $sRoot			= '/';
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function PACallbackManager ()
	{
	}//function 
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------
	function Init( $root, $poVars )
	{
		# load callbacks
		$this->poVars 	= &$poVars;	# save poiunter for calling callback functions
		$this->sRoot	= $root;
		
		$this->bInit 	= true;
	}//function 
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------
	function Call( $paid, $pafunc )
	{
		if( !$this->bInit) return false;
		
		$filename = $this->sRoot;
		//if( $paid == '' ) $filename .= "";
		if( $paid != '' ) $filename .= "{$paid}".EGL_DIRSEP."pacallback.{$paid}.{$pafunc}.php";
		//$functionname  	= 'pacallback_'.$pafunc;
		if( isset( $this->aCallbacks[$paid][$pafunc]) ) return $this->aCallbacks[$paid][$pafunc]->call( $this->poVars );
		else 
		{
			echo "load callback function";
			if( $this->RegisterCallbackFile( $paid, $filename ) )
			{
				if( isset( $this->aCallbacks[$paid][$pafunc]) ) 
				{
					return $this->aCallbacks[$paid][$pafunc]->call( $this->poVars );
				}
				else 
				{
				}
			}//if
		}//if
	}


	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------
	function RegisterCallback( $filename, $paid, $pafunc, $functionname )
	{
		$pCallback = NULL;
		if( !isset($this->aCallbacks[$paid]) )$this->aCallbacks[$paid] = array();
		$pCallback = &$this->aCallbacks[$paid][$pafunc];
		
		if( !isset($pCallback) )
		{
			$pCallback = new pa_callback_function_t();
			$pCallback->filename 		= $filename;
			$pCallback->functionname	= $functionname;
			$pCallback->pafunc			= $pafunc;
			
			return true;
		}//if
		else
		{
			DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "Couldn't load PACallback function `{$paid}:{$pafunc}` as `{$functionname}`, callback already exists " );
			return false;
		}
	}//function RegisterCallback
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------
	function RegisterCallbackFile( $paid,  $filename )
	{
		$callback_structure_start = strlen("pacallback.{$paid}.");
		$callback_structure_end = strlen(".php");
		
		$base_filename 	= basename($filename);
		$pafunc			= substr( $base_filename, $callback_structure_start, strlen($base_filename)-($callback_structure_start+$callback_structure_end) );;
		$functionname  	= "pacallback_{$paid}_".$pafunc;
		

		// file exists?		
		if( file_exists($filename) )
		{
			if( include( $filename ) )
			{
				if( function_exists( $functionname ) )
				{
					if( $this->RegisterCallback( $filename, $paid, $pafunc, $functionname ) )
					{
						return true;	
					}
					else
					{
					}//if
				}//if
				else
				{
				}
				
			}//if
			else
			{
			}

		}//if
		else 
		{
		}
		return false;
	}//function RegisterCallback
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------
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
				$cPAIDDir = new MyDirectory();
				$next_root = $root.$aDirs[$n].EGL_DIRSEP;
				if( $cPAIDDir->Open($next_root) )
				{
					$aPAIDFiles = $cPAIDDir->GetFiles();
					for( $n2=0; $n2 < sizeof($aPAIDFiles); $n2++)
					{
						$this->RegisterCallbackFile( GetLastNodeDirname( $root.$aDirs[$n]), $next_root.$aPAIDFiles[$n2] );
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
	
};
*/
?>