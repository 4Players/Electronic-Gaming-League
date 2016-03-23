<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


function InvertArray( &$array )
{
	$new_array = array();
	for( $i=0; $i < sizeof($array); $i++ )
		$new_array[$i] = $array[sizeof($array)-1-$i];
	$array = $new_array;
}



function DeleteItemOfArray( &$array, $item )
{
	
	
	$part_1 = array_slice( $array, 0, $item );
	$part_2 = array_slice( $array, $item+1, sizeof($array)-($item+1) );
	
	$array =  array_merge( $part_1, $part_2 );

	/*
	$new_array = array();
	for( $i=0; $i < sizeof($array); $i++ )
		if( $item != $i )
			$new_array[sizeof($new_array)] = $array[$i];
	$array = $new_array;
	*/
	
}


function MergeArrayByFilter( $array_1, $array_2 )
{
	$new_array  = array();
	
	# array 1
	for( $i=0; $i < sizeof($array_1); $i++ )
	{
		for( $s=0; $s < sizeof($new_array); $s++ )
			if( $new_array[$s] == $array_1[$i] )
				break;
				
		if( $s==sizeof($new_array) )
			$new_array[sizeof($new_array)] = $array_1[$i];
	}
	
	# array 2
	for( $i=0; $i < sizeof($array_2); $i++ )
	{
		for( $s=0; $s < sizeof($new_array); $s++ )
			if( $new_array[$s] == $array_2[$i] )
				break;
				
		if( $s==sizeof($new_array) )
			$new_array[sizeof($new_array)] = $array_2[$i];
	}

	return $new_array;
}


function MergeObjects( $obj1, $obj2 )
{
	
	$big_array = array();
	$cnt=0;
	
	for( $i=0; $i < sizeof($obj1); $i++ )
	{
		$_obj_var_list = get_object_vars($obj1[$i]);
		if( gettype($obj1[$i]) == 'array' ) $_obj_var_list = $obj1[$i];
		
		while( list($var_name, $var_value) = each($_obj_var_list) )	
			$big_array[$i][$var_name] = $var_value;
		$cnt++;
	}
	
	
	
	for( $i=0; $i < sizeof($obj2); $i++ )
	{
		$_obj_var_list = get_object_vars($obj2[$i]);
		if( gettype($obj2[$i]) == 'array' ) $_obj_var_list = $obj2[$i];
		
		while( list($var_name, $var_value) = each($_obj_var_list) )	
			$big_array[$i][$var_name] = $var_value;
		$cnt++;
	}
	return $big_array;
}




function MergeArrays( $obj1, $obj2 )
{
	$big_array = array();
	$cnt=0;
	
	while( list($var_name, $var_value) = each($obj1) )	
	{
		$big_array[$var_name] = $var_value;
	}
	$cnt++;
	
	while( list($var_name, $var_value) = each($obj2) )	
		$big_array[$var_name] = $var_value;
		$cnt++;
	return $big_array;
}


function DefArray( &$array )
{
	$array = array();
}

?>