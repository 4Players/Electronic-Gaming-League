<?php
# ================================ Copyright © 2005-2006 iNetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-

	
# -[ objectlist ] -




# -[ class ] -
class BufferStream
{
	# -[ variables ]-
	var 	$buffer	= null;
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function BufferStream ()
	{
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: write integer into buffer (add)
	//-------------------------------------------------------------------------------
	function writeInt($integer)
	{
		// create binary / inverted integer buffer [32bits/4bytes]
		$this->buffer .= wb_integer( $integer );
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: write float var into buffer (add)
	//-------------------------------------------------------------------------------
	function writeFloat($float)
	{
		$this->buffer .= wb_float( $integer );
	}

	//-------------------------------------------------------------------------------
	// Purpose: write double var into buffer (add)
	//-------------------------------------------------------------------------------
	function writeDouble($double)
	{
		$this->buffer .= wb_double( $integer );
	}

	//-------------------------------------------------------------------------------
	// Purpose: write char[0] of string into buffer (add)
	//-------------------------------------------------------------------------------
	function writeChar($char)
	{
		$this->buffer .= $char[0];
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: write string into buffer (add)
	//-------------------------------------------------------------------------------
	function writeString($str)
	{
		$this->buffer .= $str;
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: write bytes into bufffer (add)
	//-------------------------------------------------------------------------------
	function writeBytes($bytes)
	{
		$this->buffer .= $bytes;
	}
	
	
	function GetBuffer() { return $this->buffer; }
	function ClearBuffer() { return $this->buffer=''; }
};

?>