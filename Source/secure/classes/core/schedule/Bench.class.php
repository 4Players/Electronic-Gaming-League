<?php
# ================================ Copyright � 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


# -[ defines ] -



# -[ objectlist ] -




# -[ class ] -
class Bench
{
	var $start;
	var $stop;

	

	//-------------------------------------------------------------------------------
	// Purpose: constructor
	//-------------------------------------------------------------------------------	
    function Bench()
    {
      $this->start 	= 0;
      $this->stop 	= 0;
    }
    
    
    
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------
    function getMicrotime()
    {
        list($usec, $sec) = explode(" ",microtime());
        return ((float)$usec + (float)$sec);
    }
    
    
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------
    function start()
    {
       $this->start = $this->getMicrotime();
    }

	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------
    function stop()
    {
       $this->stop = $this->getMicrotime();
    }

	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------
    function diff()
    {
       $result = $this->stop - $this->start;
       return $result;
    }
    
    
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : 
	//-------------------------------------------------------------------------------
    function runTime()
    {
       $result = $this->getmicrotime() - $this->start;
       return $result;
    }
    
    
    
    
    
    
};
?>