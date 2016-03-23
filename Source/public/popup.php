<?php
# ================================ Copyright  2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


require( "workspace.init.php" );
require( WORKSPACE_DIR."popup/PopupRuntime.class.php" );



/* define Runtime */
$cEGL = new PopupRuntime( "EGL.Beta2006.POPUP" );

/* Offline Mode enabled ? */
if( !$cEGL->IsOfflineMode() )
{
	
	# Running Online Mode
	if( $cEGL->Init( 'popup' ) )							# load hp
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