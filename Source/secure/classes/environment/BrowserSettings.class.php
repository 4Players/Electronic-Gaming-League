<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================






# -[ class ]-
class BrowserSettings
{
	# -[ variables ]-
	//var $pDBCon	= NULL;

	
	# -[ functions ]-
	var $aSettings	= array();
	var $sAgent		= "unknown";
	

	//-------------------------------------------------------------------------------
	// Purpose: constructor
	//-------------------------------------------------------------------------------
	function BrowserSettings ()
	{
		if( !($this->aSettings = @get_browser()))
		{
			DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "Error occured on reading BrowserSetting [get_browser(): browscap ini directive not set.] " );
		}
		$this->sAgent = $HTTP_USER_AGENT;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	//-------------------------------------------------------------------------------
	function GetKeyValue( $key )
	{
		return $this->aSettings[$key];
	}
};


?>