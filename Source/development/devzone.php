<?php
# ================================ Copyright � 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


require( "workspace.init.php" );
require( WORKSPACE_DIR."devzone/DevzoneRuntime.class.php" );


/* define Runtime */
$cEGL = new DevzoneRuntime( "EGL.Beta2006.DevZone" );

/* Offline Mode enabled ? */
if( !$cEGL->IsOfflineMode() )
{
	
	# Running Online Mode
	if( $cEGL->Init( 'devzone' ) )							# load hp
	{
		$cEGL->Run( 'designs/main.tpl' );			# run
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