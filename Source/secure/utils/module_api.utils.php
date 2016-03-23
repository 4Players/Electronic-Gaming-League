<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================
define( 'EGL_MODULE_DAPI_LOADED',	true );



//------------------------------------------------------------------------------
// Purpose:
//  Output:
//------------------------------------------------------------------------------
function module_checkid( $ID )
{
	if( strlen($ID) == MODULE_ID_LENGTH ) return true;
	return false;
}




//------------------------------------------------------------------------------
// Purpose:
//  Output:
//------------------------------------------------------------------------------
/*function module_getbyID( $id )
{
	global $gl_oVars;
	
	if( Isset( $gl_oVars->cModuleManager ) )
	{
		$oM = $gl_oVars->cModuleManager->GetModule( $const );	
		if( $oM ) return $oM->cmID;
	}
	return 'unknown';
}*/


function module_getid( $class_name )
{
	global $gl_oVars;
	
	if( Isset( $gl_oVars->cModuleManager ) )
	{
		$oM = $gl_oVars->cModuleManager->GetModuleByClassedName( $class_name );	
		if( $oM ) return $oM->ID;
	}
	return 'unknown';
}


//------------------------------------------------------------------------------
// Purpose:
//  Output:
//------------------------------------------------------------------------------
function module_sendmessage( $id, $event, &$data, $wparam=NULL, $lparam=NULL )
{
	global $gl_oVars;
	if( Isset( $gl_oVars->cModuleManager ) ) 
		return $gl_oVars->cModuleManager->SendMessage( $id, $event, $data, $wparam, $lparam );
	return 0;
}




/*
//------------------------------------------------------------------------------
// Purpose:
//  Output:
//------------------------------------------------------------------------------
function module_PostMessage( $cmid, $event, &$data )
{
	return 0;
}*/



//------------------------------------------------------------------------------
// Purpose:
//  Output:
//------------------------------------------------------------------------------
function module_exists( $cmid )
{
	global $gl_oVars;
	if( Isset( $gl_oVars->cModuleManager ) )
	{
		if( $gl_oVars->cModuleManager->GetModule( $cmid ) ) 
			return 1;
		else 
			return 0;
	}
	return 0;
}



?>