<?php
# ================================ Copyright © 2004-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================

if ( !class_exists('nusoapclient') ){
	require_once( EGL_SECURE.'libs'.EGL_DIRSEP.'nusoap'.EGL_DIRSEP.'nusoap.php');
}

# -[ defines ]-
ifndef( "MANAGEDCRON_URI_SERVICE",		1 );
ifndef( "MANAGEDCRON_URI_DYNAMIC",		2 );

# -[ class ] -
class ManagedCronsClient
{
	# -[ variables ]-
	var $pDBInterfaceCon	= NULL;
	var $sServerURL			= '';
	var $key				= '';
	
	/**
	 * constructor
	 * 
	 * 
	 */
	function ManagedCronsClient( &$pDBCon )
	{
	}
	

	/**	
	 * RegisterService
	 */
	function RegisterService(){
	}
	
	/**
	 * UnRegisterService
	 */
	function UnRegisterService(){
	}
};


?>