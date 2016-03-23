<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


function egl_url_exists($url){
	$f = @fopen( $url, 'r' );
	if( $f ){
		@fclose($f);
		return true;
	}//if
	return false;
}


function domain_check($url,$timeout=2){
	$fp = @fsockopen( $url , 80);
	if (!$fp) {
		return 'error';
	} else {
		@stream_set_timeout($fp, $timeout);
		$html = '';
		/*while (!feof($fp)){
			$html.=@fread($fp, (1*(1024*1024))); 
		}*/
		$info = stream_get_meta_data($fp);
		fclose($fp);
	
		if ($info['timed_out']) {
			return 'timed_out';
		} else {
			return 'ok';
		}
		return 'unknown';
	}
	return 'unknown';
}

	
	
/**
 * __check_version
 * 
 * @param $avail version, available
 * @param $request version, requested
 * @return true/false
 */
function __check_version( $avail, $request ){
	$aRequiredVersion = explode( '.', $request );
	$aAvailableVersion = explode( '.', $avail );
			
	$check_failed = false;
	for( $i=0; $i < sizeof($aRequiredVersion); $i++ )
	{
		$v_avail = 0;
		$v_request = 0;
		if( isset($aAvailableVersion[$i]) ) $v_avail = $aAvailableVersion[$i];
		if( isset($aRequiredVersion[$i]) ) $v_request = $aRequiredVersion[$i];
				
				
		if( $v_avail >= $v_request ){
				
		}else{
			$check_failed=true;
			break;
		}
	}//for
		
	if( $check_failed ){
		return false;
	}	
	return true;
}


/**
* correct_class_name()
*
*/
function correct_class_name( $class_name )
{
	if( strchr($class_name, '.') ||
		strchr($class_name, ',') ||
		strchr($class_name, '-') ||
		strchr($class_name, '*') ||
		strchr($class_name, '`') ||
		strchr($class_name, '?') ||
		strchr($class_name, '=') ||
		strchr($class_name, '(') ||
		strchr($class_name, ')') ||
		strchr($class_name, '{') ||
		strchr($class_name, '}') ||
		strchr($class_name, '%') ||
		strchr($class_name, '$') ||
		strchr($class_name, '§') ||
		strchr($class_name, '"') ||
		strchr($class_name, '!') ||
		strchr($class_name, '[') ||
		strchr($class_name, ']') ||
		strchr($class_name, '&') ||
		strchr($class_name, '/') ||
		strchr($class_name, '\\') ||
		strchr($class_name, '<') ||
		strchr($class_name, '>')
		)return false;
	else return true;
}
	
	
function FIX_URL_SEP( $str )
{
	return str_replace( EGL_DIRSEP.EGL_DIRSEP, EGL_DIRSEP,  str_replace( '/', EGL_DIRSEP, str_replace( '\\', EGL_DIRSEP, $str ) ));
}



function EGL_REAL_LOCATION( $page )
{
	return str_replace( '.', EGL_DIRSEP, $page );
}


  
function Check_eMail( $email_str )
{
	$email = eregi("^[a-z0-9]+([-_\.]?[a-z0-9])+@[a-z0-9]+([-_\.]?[a-z0-9])+\.[a-z]{2,4}", $email_str);
	return $email;
}

//---------------------------------------------------------------------------------
//---------------------------------------------------------------------------------
//---------------------------------------------------------------------------------

function db_create_array_string( $array, $char=',' )
{
	$str="";
	for( $i=0; $i < sizeof($array); $i++ )
	{
		if( $i > 0 ) $str .= $char;
		$str.= $array[$i];
	}//for
	return $str;
}

//---------------------------------------------------------------------------------
//---------------------------------------------------------------------------------
//---------------------------------------------------------------------------------

function db_read_array_string( $str, $char="," )
{
	$array 		= array();
	$num		= 0;
	$_startpos	= 0;
	$_endpos	= -1;
	
		//-------------------------------------------------
	for( $i=0; $i < strlen($str); $i++ )
	{
		if( $str[$i] == $char )
		{
			$_endpos = $i;
			$share_str = substr( $str, $_startpos, ($_endpos-$_startpos) );
			if( strlen($share_str) > 0 )
			{
				$array[$num] = $share_str;
				$num++;
				$_startpos = $i+1;	
			}
		}
		//-------------------------------------------------
		if( $i==strlen($str)-1)
		{
			$share_str = substr( $str, $_startpos, strlen($str)-$_startpos );
			if( strlen($share_str) > 0 )
			{
				$array[$num] = substr( $str, $_startpos, strlen($str)-$_startpos );
				$num++;
			}
		}
	}//for
	return $array;
}



//---------------------------------------------------------------------------------
//---------------------------------------------------------------------------------
//---------------------------------------------------------------------------------
function CutStrToSize( $str, $num )
{
	if( $num == -1 ) return $str;
	return substr( $str, 0, $num );
	/*
	$new = "";
	for( $i=0; $i < strlen($str); $i++ )
	{
		if( $i+1 >= $num )
			break;
		$new .= $str[$i];
	}
	/*
	if( $i < strlen($str) )
		$new .= "..";*/
	return $new;
}




//---------------------------------------------------------------------------------
//---------------------------------------------------------------------------------
//---------------------------------------------------------------------------------
function GetFileExtension($str) 
{
	$i = strrpos($str,".");
	if (!$i) { return ""; }

	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
    return $ext;
}


function get_file_extension($filename, $style = -1)
{
	$dots    = explode('.', $filename);
	$c_dots    = count($dots) - 1;
	if($c_dots > 0)
	{
		switch($style)
		{
			case -1: $ext = strtolower($dots[$c_dots]); break;
			case  1: $ext = strtoupper($dots[$c_dots]); break;
			case  0: $ext = $dots[$c_dots]; break;
			default: $ext = $dots[$c_dots];
		}
		return $ext;
	}
	else
		return "";
    } 


//---------------------------------------------------------------------------------
//---------------------------------------------------------------------------------
//---------------------------------------------------------------------------------
function GetFilename($str) 
{
	$i = strrpos($str, DIRECTORY_SEPARATOR );
	if (!$i) { return ""; }

	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
    return $ext;
}

//---------------------------------------------------------------------------------
//---------------------------------------------------------------------------------
//---------------------------------------------------------------------------------
function GetLastNodeDirname( $dir )
{
	$aDirs = array();
	$aDirs = explode('\\', $dir );
	return $aDirs[sizeof($aDirs)-1];
}


//---------------------------------------------------------------------------------
//---------------------------------------------------------------------------------
//---------------------------------------------------------------------------------
function GetFileBase($str) 
{
	$i = strrpos($str, "." );
	if (!$i) { return ""; }

	$l = $i;
	$ext = substr($str,0,$l);
    return $ext;
}



function RealInteger( $str )
{
	if( $str[0] == '0' ) return substr( $str, 1, strlen($str)-1);
	return $str;
}



function note_in_string( $string )
{
	if (preg_match("/[^a-zA-Z0-9_]/",$string)) 
		return true;
	else 
    	return false;
}


function parseParameterString( $str, $diff_char=';', $assign_char='=' )
{
	$params = explode( $diff_char, $str );
	$out_params = array();
	$num_params = sizeof($params);
	for( $i=0; $i < $num_params; $i++ )
	{
		$pos = strpos( $params[$i], $assign_char );
		$key = trim( substr( $params[$i], 0, $pos ), ' ' );
		$value = trim( substr( $params[$i], $pos+1, strlen($params[$i])-$pos ), ' ');
		
		if( strlen($key) == 0 || strlen($value) == 0 )
			continue;
		$out_params[$key] = $value;
	}//for
	return $out_params;
}


?>