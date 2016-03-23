<?php
# ================================ Copyright © 2005-2006 iNetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-


	
# -[ class ] -
class OutputStream
{
	# -[ variables ]-
	var $oSocket	= null;

	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function OutputStream ( &$oSocket )
	{
		/*
			normalerweise muss die klasse auf csocket überprüft werden.
			bislang noch keine funktion gefunden
		*/
		if( get_parent_class($oSocket) == 'socket' )
		{
			$this->oSocket = &$oSocket;
		}//if
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output : 
	//-------------------------------------------------------------------------------
	function writeInt( $integer )
	{
		// send converted integer		
		// create binary/inverted integer buffer
		$buf = wb_integer($integer);
		return $this->oSocket->SendBuffer( $buf, strlen($buf));
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output : 
	//-------------------------------------------------------------------------------
	function writeFloat()
	{
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output : 
	//-------------------------------------------------------------------------------
	function writeString( $str )
	{
		return $this->oSocket->SendBuffer( $str, strlen($str));
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output : 
	//-------------------------------------------------------------------------------
	function writeBytes( $buf )
	{
		return $this->oSocket->SendBuffer( $buf, strlen($buf));
	}
		
	
	//-------------------------------------------------------------------------------
	// Purpose:	
	//   PARAM: type of <inout_package_t>
	// Output : 
	//-------------------------------------------------------------------------------
	function writeIOPackage( $object ) // <inout_package_t>
	{
		# right overgiven package?
		if( get_class($object) == 'inout_package_t' )
		{
			// write header package informations
			$this->writeInt( $object->id );	
			$this->writeInt( $object->type );
			$this->writeInt( $object->length );
			
			// write buffer
			if( (int)$object->length > 0 )
			{
				$this->writeBytes( $object->buf );
			}//if
			return 1;
		}
		else return 0;
	}
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//   PARAM: type of <unknown class/object>
	// Output : 
	//-------------------------------------------------------------------------------
	/*function writePackage( $object )
	{
	}*/
};



?>