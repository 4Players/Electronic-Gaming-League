<?php
# ================================ Copyright © 2004-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================

if ( !class_exists('nusoapclient') ){
	require_once( EGL_SECURE.'libs'.EGL_DIRSEP.'nusoap'.EGL_DIRSEP.'nusoap.php');
}

# -[ class ] -
class ServiceClient
{
	# -[ variables ]-
	var $pDBInterfaceCon	= NULL;
	var $sServerURL			= '';
	var $key				= '';
	var $cSOAPClient		= NULL;
	
	/**
	 * constructor
	 * 
	 * 
	 */
	function ServiceClient( &$pDBCon, $server_url )
	{
		$this->pDBInterfaceCon 	= &$pDBCon;
		$this->sServerURL		= $server_url;
	}
	
	/**
	 * SetKey
	 */
	function SetKey( $key ){
		return ($this->key = $key);
	}	

	/**
	 * Caller
	 */
	function Call( $service, $params=NULL ){
		// try fetching managed crons
		$this->cSOAPClient		= new nusoapclient( $this->ServiceURI($service) );
		$caller_params = array( 'key'	=> $this->key );
		
		if( is_array($params) ){
			$caller_params = array_merge( array( 'key'	=> $this->key ), $params );
		}
		// call 
		if ($response = $this->cSOAPClient->call( 'run', $caller_params ))
		{
			// get cronlist
			return $response;
		}
		else
		{
			return 0;
		}	
	}
	
	/**
	 * generate total service-uri
	 */
	function ServiceURI($service){
		return $this->sServerURL.':'.$service;
	}
	function IsFault(){
		return $this->cSOAPClient->fault;
	}
	function GetFaultString(){
		return $this->cSOAPClient->faultstring;
	}
	function GetFaultCode(){
		return $this->cSOAPClient->faultcode;
	}
	function GetError() {
		return $this->cSOAPClient->getError();
	}
	
};

?>