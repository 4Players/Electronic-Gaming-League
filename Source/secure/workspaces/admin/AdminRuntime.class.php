<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================

// require_once( EGL_PUBLIC . 'workspace.init.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'soap'.EGL_DIRSEP.'ServiceClient.class.php' );

class AdminRuntime extends RuntimeEngine 
{
	/**
	* AdminRuntime::EvaluateLoginstate()
	*
	*/
	function EvaluateLoginstate()
	{
		#-----------------------------------------------
		# define global variables
		#-----------------------------------------------
		global $gl_oVars;		

		if( $_SESSION['admin']['loggedin'] )
		{
			$gl_oVars->bLoggedIn = true;
			$gl_oVars->cTpl->assign( 'is_loggedin', true );
		}
		else{

			# => no loggedin? => forwarding to login
			if( $gl_oVars->sURLPage != 'login' )
			{
				header( "location: admin.php?page=login" );
			}
		}

		#==========================================
		# provide template with module data
		#==========================================
		$aModules = $gl_oVars->cModuleManager->GetModules();

		$gl_oVars->cTpl->assign( 'modules', $aModules );

		# LOGIN CHECK	
		
		return 1;
	}
	

	
	/**
	* AdminRuntime::InitDatabase()
	*
	*/
	function InitDatabase()
	{
		return $this->SetDatabaseConnectingData( new db_connecting_data() );
	}

	
	
	/**
	* AdminRuntime::InitPage()
	*
	*/
	function InitPage()
	{
		global $gl_oVars;
		
	
		return 1;			
	}
	
	
	/**
	* AdminRuntime::FirstInits()
	*
	*/
	function FirstInits()
	{
		return $this->SetDebugSecurity( EGL_DEBUGSECURITY_LOW );
	}

	
	/**
	* AdminRuntime::LastInits()
	*
	*/
	function LastInits()
	{
		global $gl_oVars;
		
		$this->SaveBookmark();
		
		return 1;	
	}
	
	
	/**
	* AdminRuntime::SaveLastPage()
	*
	*/
	function SaveBookmark()
	{
		global $gl_oVars;
		if( !isset($_SESSION['pagestore'])){
			$_SESSION['pagestore'] = array();
		}
		
		if( isset($_GET['save_page'])){
			
			$save_page = $_GET['save_page'];
			# decrypt page		
			$save_page=str_replace( chr(33), chr(38), $save_page);	// '|' => '&'
			$save_page=str_replace( chr(36), chr(63), $save_page);	//'$' => '?'
			
			
			// chr() ord()
			//echo $save_page;
	
			# split page into patches
			$url_patches = explode( '?', $save_page );
			
			# current URL
			$curr_url_vars = array();
			parse_str( $url_patches[1], $curr_url_vars );
	
			$max_length = 22;
			if( strlen($curr_url_vars['page']) > $max_length)
				$page_name = substr( $curr_url_vars['page'], strlen($curr_url_vars['page'])-$max_length, $max_length);
			else
				$page_name = $curr_url_vars['page'];
			
			$_SESSION['pagestore'] = array_reverse( $_SESSION['pagestore'] );
			$_SESSION['pagestore'][sizeof($_SESSION['pagestore'])] = array();
			$_SESSION['pagestore'][sizeof($_SESSION['pagestore'])-1]['name'] 	= $page_name;
			$_SESSION['pagestore'][sizeof($_SESSION['pagestore'])-1]['link'] 	= $save_page;
			$_SESSION['pagestore'][sizeof($_SESSION['pagestore'])-1]['created'] = EGL_TIME;
			$_SESSION['pagestore'] = array_reverse( $_SESSION['pagestore'] );
			
			//echo sizeof($_SESSION['pagestore']);
			
		}
		elseif( isset($_GET['del_page'])){
			
			//echo $_GET['del_page'];
			//unset($_SESSION['pagestore']);
			//$_SESSION['pagestore'] = array();
			//unset($_SESSION['pagestore'][$_GET['del_page']]);
			//DeleteItemOfArray( $_SESSION['pagestore'],  (sizeof($_SESSION['pagestore'])-1)-(int)$_GET['del_page'] );;
			DeleteItemOfArray( $_SESSION['pagestore'],  (int)$_GET['del_page'] );;
		}
		elseif( $_GET['a']=='clear_pagestore'){
			unset($_SESSION['pagestore']);
			$_SESSION['pagestore'] = array();
		}
				
		return 1;
	}//function
	
	function CheckV(){
		return '1b322036b2e94f678341cee9feb1fc0e';
	}
};

?>