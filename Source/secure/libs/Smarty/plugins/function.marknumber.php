<?php


//------------------------------------------------------------------------------
// Purpose:
//  Output:
//------------------------------------------------------------------------------
function smarty_function_marknumber($params, &$smarty)
{
	if( $params['number'] > 0 ){
		return "<font color=\"".$params['color1']."\">+".$params['number']."</font>";
	}
	if( $params['number'] < 0 ){
		return "<font color=\"".$params['color2']."\">".$params['number']."</font>";
	}
	if( $params['number'] == 0 ){
		return "<font color=\"".$params['color3']."\">".$params['number']."</font>";
	}
}


?>