<?php


//------------------------------------------------------------------------------
// Purpose:
//  Output:
//------------------------------------------------------------------------------
function smarty_function_compute_lines($params, &$smarty)
{
	if( is_array($params['array'])) $max_lines = sizeof($params['array']);
	else $max_lines = (int)$params['array'];
	
	$lines = (int)($max_lines/$params['items_per_line']);
	if( $lines == ($max_lines/$params['items_per_line']))
		return $lines;
	else return $lines+1;
}


?>