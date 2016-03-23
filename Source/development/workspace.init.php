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

define( "EGL_ROOT",				realpath(dirname(__FILE__).EGL_DIRSEP."..".EGL_DIRSEP).EGL_DIRSEP );


define( "EGL_PUBLIC",			EGL_ROOT.'public'.EGL_DIRSEP );
define( "EGL_SECURE",			EGL_ROOT.'secure'.EGL_DIRSEP );
define( "EGL_LIBS",				EGL_SECURE.'libs'.EGL_DIRSEP );


define( "SECURITY_MODULE",		 1 );		# security modul
define( "E_NULL",				-3 );
define( "SMARTY_DIR", 			EGL_SECURE.'libs'.EGL_DIRSEP.'Smarty'.EGL_DIRSEP );		# define path to Smarty-Template-Engine
define( "WORKSPACE_DIR", 		EGL_SECURE.'workspaces'.EGL_DIRSEP );			# 
//define( "DOCUMENT_DIR", 		EGL_SECURE.'documents'.EGL_DIRSEP );			# 
define( "MODULE_DIR",			EGL_SECURE.'modules'.EGL_DIRSEP );				# define path to cmod dir


#================================
# Global includes
#================================
# [configs]
require( EGL_SECURE."classes/RuntimeEngine.class.php" );

/*

	. . . class

*/

?>