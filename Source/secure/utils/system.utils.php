<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


#--------------------------------------------------
# delete file
#--------------------------------------------------
function _unlink( $file )
{
	if( !unlink($file))
	{
		//DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couln't delete `{$file}`" );
		return 0;
	} //if
	return 1;
}




#--------------------------------------------------
# copy file
#--------------------------------------------------
function _copy($source_file,$destionation_file)
{
	if( !copy( $source_file, $destionation_file ))
	{
		//DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couln't delete `{$file}`" );
		return 0;
	} //if
	return 1;
}


#--------------------------------------------------
# copy file
#--------------------------------------------------
function _mkdir( $url, $mode )
{
	if( !mkdir( $url, $mode ))
	{
		//DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couln't delete `{$file}`" );
		return 0;
	} //if
	return 1;
}


#--------------------------------------------------
# constant currently defined ?
#--------------------------------------------------
function ifdef( $define )
{
	return defined( $define );
}



#--------------------------------------------------
# constant currently defined ?
#--------------------------------------------------
function ifndef( $def, $value )
{
	if( !defined( $define ) ) return define( $def, $value );
	return 0;
}


//-------------------------------------------------------
// Purpose: delete filename from server
// Output : true/false
//-------------------------------------------------------
function delete_file( $file_link )
{
	if( !file_exists($file_link))return false;
	return unlink( $file_link );
}


//-------------------------------------------------------
// Purpose: declare overgiven variable to the overgiven class
// Output : true/false
//-------------------------------------------------------
function declare_class( &$obj, $class_name, $parameters="" )
{
	if( !ifclass($class_name) ) return false;
	/*if( !get_class_vars($class_name) ) {
		return false;
	}*/
	@eval( "\$obj = new {$class_name}({$parameters}); ");
	return true;
}



#--------------------------------------------------
# class currently declared ??
#--------------------------------------------------
function ifclass( $class )
{
	return class_exists( $class );
}


#--------------------------------------------------
# 
#--------------------------------------------------
function varofclass( $class, $var )
{
	if( class_exists($class))
	{
		$aVars = get_class_vars($class);
		return $aVars[$var];
	}
	return 'unknown';
}

#--------------------------------------------------
# 
#--------------------------------------------------
function egl_extension_loaded( $extension )
{
}


#--------------------------------------------------
# 
#--------------------------------------------------
function ShutdownSystem()
{
	exit;
}


?>