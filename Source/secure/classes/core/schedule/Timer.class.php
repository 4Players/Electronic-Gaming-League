<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


# -[ defines ]-



# -[ class ] -
class Timer
{
	# -[ variables ]-
	var	$iLastTimestamp	= 0;
	var $iTimediff		= 0;
	var $bRunning		= false;
	
	# -[ functions ]-
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	//-------------------------------------------------------------------------------
	function Timer ()
	{
	}	
	
	//-------------------------------------------------------------------------------
	// Purpose: start timer
	//-------------------------------------------------------------------------------
	function Start()
	{
		$this->iLastTimestamp 	= microtime();
		$this->bRunning 		= TRUE;
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: stop timer and save timediff
	//-------------------------------------------------------------------------------
	function Stop()
	{
		$this->iTimediff = microtime() - $this->iLastTimestamp;
		
		# check for 0 first timestamp
		if( $this->iTimediff  < 0 ) $this->iTimediff = abs( $this->iTimediff );
		$this->bRunning = FALSE;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: if timer stoped return timediff, if not return current timeleft
	//-------------------------------------------------------------------------------
	function GetTimediff()
	{
		/* timediff */
		if( $this->bRunning )
		{
			$this->iTimediff = microtime() - $this->iLastTimestamp;
			if( $this->iTimediff  < 0 ) 
			$this->iTimediff = 1-(-$this->iTimediff);
			return $this->iTimediff;
		
		}
		else return $this->iTimediff;
	}//function GetTimediff
	
};
?>