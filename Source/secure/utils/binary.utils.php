<?php
# ================================ Copyright � 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


//-------------------------------------------------------
// Purpose:
//-------------------------------------------------------
function wb_integer($integer)
{
	return	chr(($integer & 0xff000000) >> 24). 	// write byte[1]
			chr(($integer & 0x00ff0000) >> 16).		// write byte[2]
			chr(($integer & 0x0000ff00) >> 8).		// write byte[3]
			chr(($integer & 0x000000ff));			// write byte[4]
}


//-------------------------------------------------------
// Purpose:
//-------------------------------------------------------
function wb_float($float)
{
}


//-------------------------------------------------------
// Purpose:
//-------------------------------------------------------
function wb_double($double)
{
}



#==============================================================================================================
# READ BINARY
#==============================================================================================================


//-------------------------------------------------------
// Purpose:
//-------------------------------------------------------
function rb_integer($int_bytes)
{
	return	ord($int_bytes[0]) | ord($int_bytes[1]) << 8 | ord($int_bytes[2]) << 16 | ord($int_bytes[3]) << 24;
}


//-------------------------------------------------------
// Purpose:
//-------------------------------------------------------
function rb_float($buf_float)
{
}


//-------------------------------------------------------
// Purpose:
//-------------------------------------------------------
function rb_double($buf_double)
{
}

?>