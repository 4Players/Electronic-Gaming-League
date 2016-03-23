<?php


//------------------------------------------------------------------------------
// Purpose:
//  Output:
//------------------------------------------------------------------------------
function smarty_function_date($params, &$smarty)
{
	# set standard settings
	$format = "%d.%m.%Y %H:%M:%S";
	$timestamp = EGL_TIME;
	
	# format set up ?
	if( !empty($params['format'])) 
	{
		$format = $params['format'];
	}
	if( Isset( $params['timestamp'] ) ) $timestamp =  $params['timestamp'];
	return strftime($format, $timestamp );
}


?>