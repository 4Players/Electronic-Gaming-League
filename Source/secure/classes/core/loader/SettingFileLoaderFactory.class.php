<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


# -[ defines ] -



# -[ objectlist ] -



/*
SAMPLE:
FunctionLoaderFactory::LoadFunction( 'c:\\testfunction.php', 'testfunction' );*/

# -[ class ] -
class SettingFileLoaderFactory
{

	//-------------------------------------------------------------------------------
	// Purpose: constructor
	//-------------------------------------------------------------------------------	
    function SettingFileLoaderFactory ()
    {
    }
    
    
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	//-------------------------------------------------------------------------------	
    function LoadFile( $setting_file )
    {
		if( file_exists( $setting_file))
		{
			include_once( $setting_file );
			return get_defined_vars();
		}else return array();
    }
    
};
    
?>