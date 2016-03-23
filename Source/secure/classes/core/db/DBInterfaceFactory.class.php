<?php
# ================================ Copyright � 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -




# -[ class ] -
class DBInterfaceFactory
{
	# -[ variables ]-
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function DBInterfaceFactory ( $connection_class )
	{
		// try loading connecting class, if not avaialble
		if( !class_exists($connection_class) )
			if( file_exists(EGL_SECURE.'classes'.EGL_DIRSEP.'dbcon'.EGL_DIRSEP.$connection_class.'.class.php') )
				egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'dbcon'.EGL_DIRSEP.$connection_class.'.class.php');

		# load		
		if( class_exists($connection_class) )
		{
			 #*************
			 # PHP4 Output 'get_parent_class' string lowercase
			 # PHP5 Output 'get_parent_class' correct string in own case style
			 #
			 #*************
			if( strtoupper(get_parent_class($connection_class)) == 'DBCONNECTION' )
			{
				$obj = NULL;
				if( declare_class( $obj, $connection_class ) ) return $obj;
			}
		}
		else
		{
			DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "Couldn't load DB-Connection Library {$connection_class}" );
			DEBUG( MSGTYPE_INFO, __FILE__, __LINE__, "Kernel is loading `UnknownSQLCon` to emulate solid mode" );
		
			$connection_class = "UnknownSQLCon";
			//if( declare_class( $obj, $connection_class ) ) return $obj;
			return new DBConnection();
		}
		return NULL;
	}
	
};

?>