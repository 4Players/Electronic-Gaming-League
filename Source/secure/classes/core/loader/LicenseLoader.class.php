<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -


/*
FORMAT:
{KEY}
{LICENSE}
{CREATED}
{NAME}
{COMPANY}
*/


# -[ class ] -
class LicenseLoader
{
	# -[ variables ]-
	//var $aLicenseProperties	= array();
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	function LicenseLoader(){}
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function GetLicenseData ()
	{
		if( function_exists('ioncube_license_properties') )
		{
			return ioncube_license_properties();
		}//if
		else
		{
			DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "Couldn't load license properties - occured error: `function ioncube_license_properties not exists`" );
			return NULL;
		}
	}//function LicenseLoader
	
	// function GetLicenseData(){ return $this->aLicenseProperties; }
};

?>