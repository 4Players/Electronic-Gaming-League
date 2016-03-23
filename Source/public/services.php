<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


require( "workspace.init.php" );
require( WORKSPACE_DIR."services".EGL_DIRSEP."ServicesRuntime.class.php" );


/* define Runtime */
$cEGL = new ServicesRuntime( "EGL.Beta2006.Services" );

/* Offline Mode enabled ? */
if( !$cEGL->IsOfflineMode() )
{
	
	# Running Online Mode
	if( $cEGL->Init( 'services' ) )							# load hp
	{
		$cEGL->Run( 'main.tpl' );			# run
	}
}
else
{
	# Running Offline Mode
	if( $cEGL->Init( 'offline' ) )
	{							# load hp
		$cEGL->Run( 'design.tpl' );			# run
	}
}
$cEGL->Release();		# release
?>