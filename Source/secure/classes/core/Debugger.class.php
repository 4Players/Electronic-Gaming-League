<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-
define( "MSGTYPE_ERROR",	1 );
define( "MSGTYPE_WARNING",	2 );
define( "MSGTYPE_INFO",		3 );

define( "MSGTYPE_QUERY",	4 );


define( "DEBUGSTATE_LOW",		1 );
define( "DEBUGSTATE_MIDDLE",	2 );
define( "DEBUGSTATE_HIGH",		3 );

define( "DEBUGGER_ROOT", FIX_URL_SEP( EGL_SECURE . 'debug'.EGL_DIRSEP ) );

# -[ objectlist ] -
class debug_msg_t
{
	var $file	= 'unknown';
	var $line	= -1;
	var $msg	= '';
	var $type	= 0;
	var $basefile = 'unknown';
	var $bench_time=0;
	var $real_type=0;
};





# - [class] -
class Debugger
{
	var $bEnabled		= true;
	
	var $aMsgs			= array();
	var $cSmarty 		= NULL;
	var $sName			= 'unknown';
	var $bSingleFile	= false;
	var $iDebugstate	= DEBUGSTATE_LOW;
	var $bAlertOnError 	= true;
	var $sRoot			= DEBUGGER_ROOT;
	var $bOnlyOffhandedOnError = true;
	var $cBenchTime		= NULL;
	var $iBenchTime		= 0;

	# tpl vars
	var $sOutputDir		= '';
	var $sTplDir 		= '';
	var $sTplCompileDir	= '';
	var $sTplCacheDir	= '';
	var $sTplConfigDir	= '';
	var $sTplFile		= '';
	
	var $aVars			= array();
	var $iDebugSecurity	= EGL_DEBUGSECURITY_HIGH;
	var $pRuntimeEngine	= NULL;
	
	#---------------------------------------------------------------------------------------
	# Purpose:
	#  Output:
	#---------------------------------------------------------------------------------------
	function Debugger( $bSingleFile, $name=NULL )
	{
		$this->bSingleFile = $bSingleFile;
		if( strlen($name) > 0 ) 
			$this->sName = $name;
		else
			$this->name = substr( md5( CreateRandomPassword(10) ), 0, 10 );
			
		# declare smarty template engine
		$this->cSmarty = new Smarty();
	}
	
	
	
	#---------------------------------------------------------------------------------------
	# Purpose:
	#  Output:
	#---------------------------------------------------------------------------------------
	function Init( &$pRuntimeEngine )
	{
		/*
			inits
		*/
		$this->pRuntimeEngine = &$pRuntimeEngine;
		return 1;
	}
	
	
	#---------------------------------------------------------------------------------------
	# Purpose:
	#  Output:
	#---------------------------------------------------------------------------------------
	function AssignVar( $name, $value )
	{
		$this->aVars[$name] = $value;
	}
	
	
	
	
	
	#---------------------------------------------------------------------------------------
	# Purpose:
	#  Output:
	#---------------------------------------------------------------------------------------
	function BuildOutput( $outputfile='' )
	{
		####### CHECK DIRECTORIES ########
		if( !is_dir($this->sTplDir) ) { print "<br><b>Couldn't find template directory `{$this->sTplDir}`</b>"; return 0;}
		if( !is_dir($this->sTplCompileDir) ) { print "<br><b>Couldn't find compile directory `{$this->sTplCompileDir}`</b>"; return 0;}
		if( !is_dir($this->sTplCacheDir) ) { print "<br><b>Couldn't find cache directory `{$this->sTplCacheDir}`</b>"; return 0;}
		
		
		####### CHECK INPUT #############
		if( strlen($outputfile) > 0 )
		{
			$debug_output_filename = $outputfile;
		}
		else
		{
			# define output file
			if( !$this->bSingleFile ) 
				$debug_output_filename = FIX_URL_SEP( $this->sRoot . $this->sOutputDir . strftime( "/".$this->sName."_%d.%m.%y_%H.%M.%S.htm" ) ); 
			else 
				$debug_output_filename = FIX_URL_SEP( $this->sRoot .'/'. $this->sOutputDir .'/'. $this->sName.'.htm' ); 
		}//if
		
	
		# create outputfile stream
		$oFile = new File();
		if( $oFile->Open( $debug_output_filename, 'w' ) )
		{
			/*
			for( $iMsg=0; $iMsg < sizeof($this->aMsgs); $iMsg++ )
				$oFile->Write( "<br>".htmlspecialchars("<Debugger|Line/{$this->aMsgs[$iMsg]->line}/File/{$this->aMsgs[$iMsg]->file}/ ? Msg/{$this->aMsgs[$iMsg]->msg} >") );
			*/
			# define template DE
			$this->cSmarty->template_dir 	= $this->sTplDir; 
			$this->cSmarty->config_dir 		= $this->sTplConfigDir;
			$this->cSmarty->compile_dir 	= $this->sTplCompileDir;
			$this->cSmarty->cache_dir	 	= $this->sTplCacheDir;

			# provide template engine with received msg buffer
			$this->cSmarty->assign( "msgs", $this->aMsgs );
			if( strlen($debug_output_filename) > 70 ) $debug_output_filename = "[...]".substr( $debug_output_filename, strlen($debug_output_filename)-70, 70 );
			$this->cSmarty->assign( "output_file", $debug_output_filename );
			$this->cSmarty->assign( "project_name", $this->sName );
			$this->cSmarty->assign( "bench_time", $this->iBenchTime );
			
			
			$query_counter=0;
			$error_counter=0;
			$warning_counter=0;
			$info_counter=0;
			
			// fetch statistic
			for( $iMsg=0; $iMsg < sizeof($this->aMsgs); $iMsg++ )
			{
				if( $this->aMsgs[$iMsg]->type == MSGTYPE_ERROR ) $error_counter++;
				if( $this->aMsgs[$iMsg]->type == MSGTYPE_INFO ) $info_counter++;
				if( $this->aMsgs[$iMsg]->type == MSGTYPE_WARNING ) $warning_counter++;
				if( $this->aMsgs[$iMsg]->type == MSGTYPE_QUERY ) $query_counter++;
				
				$this->aMsgs[$iMsg]->basefile = basename($this->aMsgs[$iMsg]->file);
			}//for
			
			$this->cSmarty->assign( "error_counter",		$error_counter );
			$this->cSmarty->assign( "info_counter", 		$info_counter );
			$this->cSmarty->assign( "warning_counter", 		$warning_counter );
			$this->cSmarty->assign( "query_counter", 		$query_counter );
			
			
			// provide template with assigned vars/contents
			while( list($var_name, $var_value) = each($this->aVars) ) 
			{
				$this->cSmarty->assign( $var_name, $var_value );
			}//while
		
			
			# compile template
			if( $this->cSmarty->template_exists($this->sTplFile))
			{
				$oFile->Write( $this->cSmarty->fetch( $this->sTplFile ) );
			}
			
			# close output file
			$oFile->Close();
			return 1;
		}		
		else 
		{
			// fehler
		}
		
		return 0;
	}
	
	
	#---------------------------------------------------------------------------------------
	# Purpose:
	#  Output:
	#---------------------------------------------------------------------------------------
	function Release()
	{
		
		// check -> errors occured ?
		$num_messages=sizeof($this->aMsgs);
		
		$bErrorOccured=false;
		$bWarningOccured=false;
		for( $iMsg=0; $iMsg <$num_messages ; $iMsg++ )
		{
			if( $this->aMsgs[$iMsg]->type == MSGTYPE_ERROR ) $bErrorOccured=true;
			if( $this->aMsgs[$iMsg]->type == MSGTYPE_WARNING )$bWarningOccured=true;
		}//for

		// take offhanded save		
		//if( $bWarningOccured )
		//{
			if( $bErrorOccured )
			{
				// check => offhanded permissions?
				if( $this->bOnlyOffhandedOnError )
				{
					$debug_output_filename = FIX_URL_SEP( $this->sRoot . $this->sOutputDir . strftime( "/offhanded/".$this->sName."_%d.%m.%y_%H.%M.%S.htm" ) ); 
					$this->BuildOutput( $debug_output_filename );
					// javascript message output
					if( $this->bAlertOnError )
					{
						$this->OutputJavaMessage( "Error occured - Saved in [{$debug_output_filename}] -> Please contact the EGL-Support Team on eglonline.de.Thank you!");
					}//if
					
				}//if $this->bOnlyOffhandedOnError
			}//if $bErrorOccured
			/*elseif( $bWarningOccured )
			{
				$debug_output_filename = FIX_URL_SEP( $this->sRoot . $this->sOutputDir . strftime( "/offhanded/".$this->sName."_%d.%m.%y_%H.%M.%S.htm" ) ); 
				$this->BuildOutput( $debug_output_filename );
			}*/
			
			
		//}//if$bWarningOccured
	}// function release
	
	
	
	#---------------------------------------------------------------------------------------
	# Purpose:
	#  Output:
	#---------------------------------------------------------------------------------------
	function SetRootDir( $dir ) {$this->sRoot = $dir; return 1;}
	function SetOutputDir( $dir ) {	$this->sOutputDir = $dir; return 1;}
	function SetAlertOffhandedOutput( $is ){$this->bAlertOnError = $is; return 1; }
	function SetBenchTimer( &$cBechTime ) { $this->cBenchTime = &$cBechTime; return 1; }
	function SetBenchTime( $bench_time ) { $this->iBenchTime =$bench_time; return 1; }
	function SetDebugSecurity( $debugmode ) {$this->iDebugSecurity=$debugmode; return 1; }
	
	
	#---------------------------------------------------------------------------------------
	# Purpose:
	#  Output:
	#---------------------------------------------------------------------------------------
	function SetTemplateValues( $tpl_file, $tpl_dir,  $cfg_dir, $compile_dir , $cache_dir )
	{
		
		$this->sTplDir 			= $tpl_dir;
		$this->sTplCompileDir	= $compile_dir;
		$this->sTplCacheDir		= $cache_dir;
		$this->sTplConfigDir	= $cfg_dir;
		$this->sTplFile			= $tpl_file;
		return 1;
	}	
	
	
	#---------------------------------------------------------------------------------------
	# Purpose:
	#  Output:
	#---------------------------------------------------------------------------------------
	function AddMsg( $type, $file, $line, $msg )
	{
		$pMsg = &$this->aMsgs[sizeof($this->aMsgs)];
		$pMsg = new debug_msg_t;
		$pMsg->real_type=$pMsg->type = $type;
		$pMsg->file = $file;
		$pMsg->line = $line;
		$pMsg->msg = $msg;
		if( isset($this->cBenchTime))$pMsg->bench_time=round($this->cBenchTime->runTime(),5);
		
		/*if( $this->iDebugSecurity == EGL_DEBUGSECURITY_MIDDLE )
		{
			do nothing..
		}*/

		if( $this->iDebugSecurity == EGL_DEBUGSECURITY_LOW )
		{
			if( $pMsg->type == MSGTYPE_ERROR )$pMsg->type = MSGTYPE_WARNING;
		}
		
		if( $this->iDebugSecurity == EGL_DEBUGSECURITY_HIGH )
		{
			if( $pMsg->type == MSGTYPE_WARNING )$pMsg->type = MSGTYPE_ERROR;
		}
		
		
		// evaluate systemstop
		if( $pMsg->type == MSGTYPE_ERROR )
		{
			if( $this->pRuntimeEngine) $this->pRuntimeEngine->SystemSopped();
			else
			{
				print( "RuntimeEngine stopped. For more information see debug files!" );
				exit;
			}//if
		}//if
		
		return 1;
	}
	
	#---------------------------------------------------------------------------------------
	# Purpose:
	#  Output:
	#---------------------------------------------------------------------------------------
	function Save( $template_dir, $compile_dir, $base_tpl=0 )
	{
		return 1;
	}
	
	/**
	 * 
	 */
	function OutputJavaMessage( $msg )
	{
		print
			"\n<script type=\"text/javascript\">".
	  			" alert(\"{$msg}\");".
			" </script>";
		return 1;	
	}
	
	#---------------------------------------------------------------------------------------
	# Purpose:
	#  Output:
	#---------------------------------------------------------------------------------------
	function ShowDebugFile( $focused=false )
	{
		if( !$this->bSingleFile ) $debug_output_filename = FIX_URL_SEP( $this->sRoot . $this->sOutputDir . strftime( "/%d.%m.%y_%H.%M.%S.htm" ) ); 
		else $debug_output_filename = FIX_URL_SEP( $this->sRoot .'/'. $this->sOutputDir .'/'. $this->sName.'.htm' ); 
		
		/*
			create javascript output
		*/
		$javascript_output = "";
		if( $focused )
		{
			$javascript_output =
				"\n<script type=\"text/javascript\">\n<!--\n".
	  				"window.open(\"file:///{$debug_output_filename}\", \"DEBUG Output\", \"width=300,height=200,scrollbars\");".
	  				"window.focus();\n".
				"-->\n</script>\\n";
		}
		else
		{
			$javascript_output =
				"\n<script type=\"text/javascript\">\n<!-- \n".
	  				"window.open(\"file:///{$debug_output_filename}\", \"DEBUG Output\", \"width=300,height=200,scrollbars\");\n".
	  				#"w.focus();".
				"-->\n</script>\n";
		}
	
		print $javascript_output;
	}
	
	
	function Enable(){	$this->bEnabled = true; }
	function Disable(){	$this->bEnabled = false; }
};


#---------------------------------------------------------------------------------------
# Purpose: detailled debug output
#---------------------------------------------------------------------------------------
function DEBUG( $type, $file, $line, $msg )
{
	global $gl_oVars;
	if( $gl_oVars->cDebugger ) return $gl_oVars->cDebugger->AddMsg( $type, $file, $line, $msg );
	

	/* FALL BACK */
	if( $type == MSGTYPE_ERROR )
	{
		echo nl2br(htmlspecialchars("\n<FALL-BACK|Debugger|Line/{$line}/File/{$file}/ ? Msg/{$msg} >"));
		return 0;
	}//if
}



#---------------------------------------------------------------------------------------
# Purpose: simple message [info] output
#---------------------------------------------------------------------------------------
function TRACE( $string )
{
	DEBUG( MSGTYPE_INFO, 'N/A', 'N/A', $string );
}


?>