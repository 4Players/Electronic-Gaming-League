<?php
# ================================ Copyright  2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


require( "workspace.init.php" );
require( WORKSPACE_DIR."managedcrons/ManagedCronsRuntime.class.php" );



/* define Runtime */
$cEGL = new ManagedCronsRuntime( "EGL.Beta2.ManagedCrons" );

/* Offline Mode enabled ? */
if( !$cEGL->IsOfflineMode() )
{
	
	# Running Online Mode
	if( $cEGL->Init( 'managedcrons' ) )
	{
		$cEGL->Run( 'design.tpl' );			# run
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