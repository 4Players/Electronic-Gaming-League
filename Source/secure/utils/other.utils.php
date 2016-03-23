<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


# global var
$g_aPageErrors			= array();
	
//-------------------------------------------------------
// Purpose: ADD ERROR
//-------------------------------------------------------
function ADD_PAGE_ERROR( $str )
{
	$GLOBALS['g_aPageErrors'][sizeof($GLOBALS['g_aPageErrors'])] = $str;
}


//-------------------------------------------------------
// Purpose: ADD ERROR
//-------------------------------------------------------
function GET_PAGE_ERRORS()
{
	return $GLOBALS['g_aPageErrors'];
}


//-------------------------------------------------------
// Purpose: creates a random password
// Output : current created password
//-------------------------------------------------------
function CreateRandomPassword( $length=5 )
{
	$Password = "";
	for( $t=0; $t < $length; $t++ ) // x ziffern
	{
		srand ((double)microtime()*1000000);
		$char_t = rand(0,2);		

		srand ((double)microtime()*1000000);

		if( $char_t == 0 ) # number
		{
			$Password .=  rand(0,9 );
		}
		if( $char_t == 1 ) # big char
		{
			$Password .=chr( rand(65,90 ) );
		}
		if( $char_t == 2 ) # little char
		{
			$Password .= chr( rand(97,122 ) );
		}
	}
	return $Password;
}


//-------------------------------------------------------
// Purpose: convert an object to array containing the object values
// Output : array obj
//-------------------------------------------------------
function ConvertObjectToArray( $obj )
{
	if( !$obj ) return NULL;
	if( sizeof($obj) == 0 ) return NULL;
	
	$aArray = array();
	
	$_obj_var_list = get_object_vars($obj);
	
	
	while( list($var_name, $var_value) = each($_obj_var_list) ) 
		$aArray[$var_name] = $var_value;
	
	return $aArray;
}


//-------------------------------------------------------
// Purpose: convert an array object to array containing the object values
// Output : array obj
//-------------------------------------------------------
function ConvertArrayObjectToArray( $obj )
{
	if( sizeof($obj) == 0 ) return NULL;
	$buffer = array();
	for( $i=0; $i < sizeof($obj); $i++ )
	{
		$buffer[$i] = ConvertObjectToArray( $obj[$i] );
	}
	return $buffer;
}

/*
ACHTUNG: Unsicher !!!
//-------------------------------------------------------
// Purpose: convert an array to a object containing the same vars & values
// Output : object
//-------------------------------------------------------
function ConvertArrayToObject( $array )
{
	$temp_obj = NULL;
	
	# try to convert buffer
	while( list($var_name, $var_value) = each($array) )
	{
		echo "<br>".$var_name."=>".$var_value;
		eval(  "\$temp_obj->$var_name = \"$var_value\"; " );
	}
	return $temp_obj;
}
*/




//-------------------------------------------------------
// Purpose: convert an 2d object to a 2d array
// Output : array-object
//-------------------------------------------------------
function Convert2DObjectTo2DArray( $obj )
{
	if( sizeof($obj) == 0 ) return NULL;
	$aArray = array();
	while( list($var_name, $var_value) = each($obj) )
	{
		$aArray[$var_name] = ConvertObjectToArray( $var_value );
	}
	return $aArray;
}

//-------------------------------------------------------
// Purpose: convert an 2d object to a 2d array
// Output : array-object
//-------------------------------------------------------
function Convert2DArrayObjectTo2DArray( $obj )
{
	if( sizeof($obj) == 0 ) return NULL;
	$aArray = array();
	while( list($var_name, $var_value) = each($obj) )
	{
		$aArray[$var_name] = ConvertArrayObjectToArray( $var_value );
	}
	return $aArray;
}

//==================================================================================
//==================================================================================
//==================================================================================

function recuConvertXArrayObjectArray( $obj, &$pOut )
{
	if( !is_array( $obj ) )
	{
		if( !is_object($obj))
		{
			$pOut = $obj;
		}
		else
		{
			#echo $obj->id;
			$pOut = ConvertObjectToArray( $obj );
		}
	}
	else
	{
		$pOut = array();
		for( $i=0; $i < sizeof($obj); $i++ )
		{
			recuConvertXArrayObjectArray( $obj[$i], $pOut[sizeof($pOut)] );
		}//for
	}//if
}


function ConvertXArrayObjectArray( $obj )
{
	$data=NULL;
	recuConvertXArrayObjectArray( $obj, $data);
	return $data;
}



//==================================================================================
//==================================================================================
//==================================================================================



//-------------------------------------------------------
// Purpose: set empty vars to str
// Output : object
//-------------------------------------------------------
function SetNoInputString( $obj, $str )
{
	$aArray = array();
	while( list($var_name, $var_value) = each($obj) ) 
	{
		if( strlen($var_value) == 0) 
			$aArray[$var_name] = $str;
		else $aArray[$var_name] = $var_value;
	}
	return $aArray;	
}

/*
//-------------------------------------------------------
// Purpose: set vars to object
// Output : object containing the new data /vars
//-------------------------------------------------------
function SetObjectVars( $obj, $var_object  )
{
	$aObjArray = ConvertObjectToArray( $obj );
	$aObjVarArray = ConvertObjectToArray( $var_object );
	
	# update object
	while( list($var_name, $var_value) = each($aObjVarArray) )
	{
		$aObjArray[$var_name] = $var_value;
	}
	return ConvertArrayToObject( $aObjArray );
}
*/




//-------------------------------------------------------
// Purpose: 
// Output : 
//-------------------------------------------------------
function _RESMSG( $str )
{
	return $str;
}




//-------------------------------------------------------
// Purpose: 
// Output : 
//-------------------------------------------------------





#==================================================================================================================
#==================================================================================================================
#
# Q U I C K    S O R T 
#
#==================================================================================================================
#==================================================================================================================

/*
function sort_cmods( $a, $b )
{
	$state_a = 0;
	$state_b = 0;
	
	
	
	if( $a->bActivated ) $state_a++;
	if( $a->bInstalled ) $state_a++;
	
	if( $b->bActivated ) $state_b++;
	if( $b->bInstalled ) $state_b++;
	
	if( $state_a == $state_b ) return 0;
	
		
	return ( $state_a > $state_b ) ?  -1:1;
}*/


?>