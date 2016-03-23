<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



//---------------------------------------------------------------------------------
//---------------------------------------------------------------------------------
function GetWeekday( $day, $month, $year )
{
	
	
	if( $month < 3 )
	{ 
		$year--;
		$month+=10;
	}
	else 
	{
		$month-=2;
	}
	
	
	$century = (int)($year / 100);
	$year = (int)($year % 100);
	
	$t = (((int)(((26*$month)-2)/10)) + $day + $year + (int)($year/4) + (int)($century/4) - 2*$century) % 7;
	if( $t < 0 ) $t+=7;
	return $t;
}




//---------------------------------------------------------------------------------
//---------------------------------------------------------------------------------
//---------------------------------------------------------------------------------
function GetDayName( $day_nr )
{
	switch($day_nr)
	{
		case 1: return "Montag";
		case 2: return "Dienstag";
		case 3: return "Mittwoch";
		case 4: return "Donnerstag";
		case 5: return "Freitag";
		case 6: return "Samstag";
		case 0: return "Sonntag";
	}
}




//---------------------------------------------------------------------------------
//---------------------------------------------------------------------------------
//---------------------------------------------------------------------------------
function GetMonthName( $month_nr )
{
	switch($month_nr)
	{
		case 1: return "Januar";
		case 2: return "Februar";
		case 3: return "März";
		case 4: return "April";
		case 5: return "Mai";
		case 6: return "Juni";
		case 7: return "Juli";
		case 8: return "August";
		case 9: return "September";
		case 10: return "Oktober";
		case 11: return "November";
		case 12: return "Dezember";
	}//switch
}




//---------------------------------------------------------------------------------
// Get time from date(string)
//---------------------------------------------------------------------------------
function ConstrueStrDate( $date, $time )
{
	list ($day, $month, $year) = explode('.', $date);
	list ($h, $m, $s) = explode(':', $time);
	return mktime( $h, $m, $s, $month, $day, $year );
}



//---------------------------------------------------------------------------------
//
//---------------------------------------------------------------------------------
function ComputeTimeIntervalFromSeconds( $sec )
{
	$days=0;
	$hours=0;
	$mins=0;
	$seconds=0;
	
	$last_seconds=$sec;

	# days	
	while( ($last_seconds/(24*60*60)) >= 1 )
	{
		$last_seconds-=24*60*60;
		$days++;
	}
	
	# hours
	while( ($last_seconds/(3600)) >= 1 )
	{
		$last_seconds-=3600;
		$hours++;
	}
	
	# minutes
	while( ($last_seconds/(60)) >= 1 )
	{
		$last_seconds-=60;
		$mins++;
	}
	
	$seconds=$last_seconds;
			
	return array( 	"days" => (int)$days,
					"hours" => (int)$hours,
					"mins" => (int)$mins,
					"seconds" => (int)$seconds );
					
}//if



?>