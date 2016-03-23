<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


require( "workspace.init.php" );
require( WORKSPACE_DIR."setupwizard/Setupwizard.runtime.class.php" );



/* define Runtime */
$cEGL = new SetupwizardRuntime( "EGL.Beta2006.SETUPWIZARD" );

/* Offline Mode enabled ? */
if( !$cEGL->IsOfflineMode() )
{
	
	# Running Online Mode
	if( $cEGL->Init( 'setupwizard' ) )							# load hp
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