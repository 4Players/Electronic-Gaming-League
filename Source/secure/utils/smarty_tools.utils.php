<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================




//------------------------------------------------------------------------------
// Purpose:
//  Output:
//------------------------------------------------------------------------------
function print_percent( $params )
{
	if( (int)$params['value'] == 0 ) return 0;
	if( $params['max'] > 0 )
		return round( (100/$params['max'])*$params['value'], $params['round'] );
	else return 0;
}


/*
//------------------------------------------------------------------------------
// Purpose:
//  Output:
//------------------------------------------------------------------------------
function print_date($params)
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
}*/



//------------------------------------------------------------------------------
// Purpose:
//  Output:
//------------------------------------------------------------------------------
function print_forwarding($params)
{
	$url 	= "";
	$sec 	= 5; #sec
	 
	if(!empty($params['url']))  $url = $params['url'];
	if( Isset( $params['sec'] ) ) $sec =  (int)$params['sec'];
	
	/*forwarding_str*/ return "<meta http-equiv=\"refresh\" content=\"$sec; URL=$url\">";
}



//------------------------------------------------------------------------------
// Purpose:
//  Output:
//------------------------------------------------------------------------------
function print_irc_con($params)
{
	if( Isset( $params['url'] ) &&
		strlen($params['url']) > 0 )
	{
		$new_url = str_replace( '@', ',', $params['url'] );
		$parts = db_read_array_string($new_url);

		$link_name = "irc://".$parts[0];
		if( Isset( $params['name'] ) && strlen($params['name']) > 0 ) $link_name=$params['name'];
		
		return "<A href=\"irc://".$parts[0]."\" target=\"_blank\"> $link_name </a> : <i> ".$parts[1]."</i> ";
	}else return "<i>Non</i>";
}



//------------------------------------------------------------------------------
// Purpose:
//  Output:
//------------------------------------------------------------------------------
function print_hp($params)
{
	if( Isset( $params['url'] ) &&
		strlen($params['url']) > 0 )
	{
		$new_url = str_replace( 'http://', '', $params['url'] );
		$link_name = "http://".$new_url;
		if( Isset( $params['name'] ) && strlen($params['name']) > 0 ) $link_name=$params['name'];
		
		if( strlen($new_url) > 3 )
			return "<A target=\"_blank\" href=\"http://".$new_url."\">$link_name</a> ";
		else return "<i>Non</i>";
	}else return "<i>Non</i>";
}



#---------------------------------------------------------------------
# Purpose:
#  Output:
#---------------------------------------------------------------------
function print_cut_str($params)
{
	
	$str = CutStrToSize( $params['text'], $params['num'] );
	if( strlen($str) < strlen($params['text']) )$str.='..';
	return $str;
}




#---------------------------------------------------------------------
# Purpose:
#  Output:
#---------------------------------------------------------------------
function print_pow( $params )
{
	return pow( (int)$params['base'], (int)$params['exponent'] );
}



#---------------------------------------------------------------------
# Purpose:
#  Output:
#---------------------------------------------------------------------
function print_url_params($params)
{
	$str_url = '';
	while( list($var,$value) = each($_GET))
		$str_url .= $var.'='.$value.'&';
	return substr( $str_url, 0, strlen($str_url)-1);
}


#---------------------------------------------------------------------
# Purpose:
#  Output:
#---------------------------------------------------------------------
function print_int($params)
{
	return (int)$params['value'];
}


#---------------------------------------------------------------------
# Purpose:
#  Output:
#---------------------------------------------------------------------
function print_filesize($params)
{
	$file = $params['file'];
	if( !file_exists($file) ) return "0";
	return round( filesize($file)/1024, 1 );
}

#---------------------------------------------------------------------
# Purpose:
#  Output:
#---------------------------------------------------------------------
function print_age( $params )
{
	$date_str = $params['date'];
	if( !strlen($date_str) ) return 0;
	
	
	list ($day, $month, $year) = explode('.', $date_str); 
	   
	
	$age = date('Y') - $year;
	// falls man in diesem Jahr noch nicht Geburtstag hatte wieder ein Jahr abziehen
	if(mktime(0,0,0,$month,$day+1) > time()) {
	  $age--;
	}
	
	return $age;
}



function print_weekday( $params )
{
	return GetDayName( $params['day'] );
}

function print_month( $params )
{
	return GetMonthName( $params['month'] );
}



#---------------------------------------------------------------------
# Purpose:
#  Output:
#---------------------------------------------------------------------
function print_module_getid($params)
{
	return module_getid($params['cname']);
}


function print_texts( $params )
{
	global $gl_oVars;
	
	$file = FIX_URL_SEP( EGL_SECURE . 'templates/texts/'.$params['language'].'/'.$params['file'] );
	return ( $gl_oVars->cTpl->fetch( $file ));
}


function print_benchtime( $params )
{
	global $gl_oVars;
	return round( $gl_oVars->cBench->runTime(), 3);
}


#---------------------------------------------------------------------
# Purpose:
#  Output:
#---------------------------------------------------------------------
function print_match_status($params)
{
	$status = "Unknown";
	if( $params['status'] == MATCH_CLOSED ) $status = "Closed";
	if( $params['status'] == MATCH_RUNNING ) $status = "Running";
	if( $params['status'] == MATCH_REPORTED ) $status = "Report-Check";
	return $status;
}


#---------------------------------------------------------------------
# Purpose:
#  Output:
#---------------------------------------------------------------------
function print_file_extension($params)
{
	$ext = get_file_extension( $params['file'], -1);
	if( file_exists( EGL_PUBLIC.'images'.EGL_DIRSEP.'file_format'.EGL_DIRSEP.$ext.'.gif' ))
		return $ext;
	else return 'unknown';
}



function print_split_str($params)
{
	$aArray = db_read_array_string( $params['str'], $params['char'] );
	return $aArray[$params['item']];
}



function print_session($params)
{
	$_SESSION[$params['var']] = $params['value'];
}


function print_random_string( $params )
{
	return CreateRandomPassword( $params['length']);
}




##################################################################################################################
##################################################################################################################
#				F I L T E R S
##################################################################################################################
##################################################################################################################

	
#---------------------------------------------------------------------
# Purpose:
#  Output:
#---------------------------------------------------------------------
function remove_tabs($tpl_source, &$smarty)
{
	return str_replace( '	', '', $tpl_source );
}
     

#---------------------------------------------------------------------
# Purpose:
#  Output:
#---------------------------------------------------------------------
function remove_dw_comments($tpl_source, &$smarty)
{
	return preg_replace("/<!--#.*-->/U","",$tpl_source);
}



#---------------------------------------------------------------------
# Purpose:
#  Output:
#---------------------------------------------------------------------
function remove_double_breaks( $tpl_source, &$smarty )
{
	return str_replace( "\n\n", "", $tpl_source );
}






##################################################################################################################
##################################################################################################################
#				F U N C T I O N  S
##################################################################################################################
##################################################################################################################

?>