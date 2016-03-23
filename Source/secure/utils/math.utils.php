<?php
# ================================ Copyright � 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



#--------------------------------------------------
# isint Integer
#--------------------------------------------------
function isint( $var )
{
	if( round($var) == $var ) return 1;
	return false;
}



#--------------------------------------------------
# ispow check pows:P
#--------------------------------------------------
function ispow( $num )
{
	$_t = log($num)/log(2);
	$result = isint( $_t );

	if( $result ) return 1;
	return 0;
}





#--------------------------------------------------
# 
#--------------------------------------------------
function getnextpow( $num, $pow )
{
	$tmp = log($num)/log($pow);
	return pow( $pow, ((int)$tmp)+1 );
}


?>