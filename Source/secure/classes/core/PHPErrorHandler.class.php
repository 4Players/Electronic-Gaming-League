<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -


# -[ class ] -
class PHPErrorHandler
{
	# -[ variables ]-
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	/**
	* PHPErrorHandler::PHPErrorHandler
	*
	*/
	function PHPErrorHandler ()
	{		
		$this->Enable();
	}


	/**
	* PHPErrorHandler::Enable
	*
	*/
	function Enable()
	{
		$old_error_handler = set_error_handler( array( &$this, "PHPErrorHandler_CALLBACK"));
		DEBUG( MSGTYPE_INFO, __FILE__, __LINE__, "PHPErrorHandle enabled" );
	}
	
	
	/**
	* PHPErrorHandler::Enable
	*
	* @param integer 	type
	* @param string 	error-message
	* @param integer 	occured error-file
	* @param integer 	occured error-line
	*/	
	function PHPErrorHandler_CALLBACK( $errno, $errstr, $errfile, $errline  )
	{
		switch ($errno) 
		{
			# -----------------------
			# FATAL-ERROR
			# -----------------------
			case FATAL:
			{
				//echo "<b>FATAL</b> [$errno] $errstr<br />\n";
				//echo "  Fatal error in line $errline of file $errfile";
				//echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
				//echo "Aborting...<br />\n";
				
				DEBUG( MSGTYPE_ERROR, $errfile, $errline, "PHP: {FATAL-ERROR using " . PHP_VERSION . "(" . PHP_OS . ")} {$errstr}" );
				exit(1);
			}break;
			# -----------------------
			# ERROR
			# -----------------------
		  	case ERROR:
		  	{
				//echo "<b>ERROR</b> [$errno] $errstr<br />\n";
				DEBUG( MSGTYPE_ERROR, $errfile, $errline, "PHP:  {$errstr}" );
		  	}break;
			# -----------------------
			# FATAL-ERROR
			# -----------------------
			case WARNING:
			{
				//echo "<b>WARNING</b> [$errno] $errstr<br />\n";
				DEBUG( MSGTYPE_WARNING, $errfile, $errline, "PHP: {$errstr}" );
			}break;
			# -----------------------
			# DEFAULT
			# -----------------------
			default:
			{
				//echo "Unkown error type: $errline [$errno] $errstr<br />\n";
				DEBUG( MSGTYPE_WARNING, $errfile, $errline, "PHP: {UNKNOWN-ERROR} {$errstr}" );
		  	}break;
		}//switch
	}
};

?>