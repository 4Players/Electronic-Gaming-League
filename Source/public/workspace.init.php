<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================





#================================
# Global defines
#================================


# [base]
define( "EGL_DIRSEP",			DIRECTORY_SEPARATOR );

define( "EGL_ROOT",				realpath(dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR );


define( "EGL_PUBLIC",			EGL_ROOT.'public'.DIRECTORY_SEPARATOR );
define( "EGL_SECURE",			EGL_ROOT.'secure'.DIRECTORY_SEPARATOR );
define( "EGL_LIBS",				EGL_SECURE.'libs'.DIRECTORY_SEPARATOR );


define( "SECURITY_MODULE",		 1 );		# security modul
define( "E_NULL",				-3 );
define( "SMARTY_DIR", 			EGL_SECURE.'libs'.DIRECTORY_SEPARATOR.'Smarty'.DIRECTORY_SEPARATOR );		# define path to Smarty-Template-Engine
define( "WORKSPACE_DIR", 		EGL_SECURE.'workspaces'.DIRECTORY_SEPARATOR );								# 
define( "MODULE_DIR",			EGL_SECURE.'modules'.DIRECTORY_SEPARATOR );									# define path to cmod dir


#================================
# Global includes
#================================
# [configs]
require( EGL_SECURE.'classes'.DIRECTORY_SEPARATOR.'RuntimeEngine.class.php' );

/*

	. . . class

*/

?>