<?php
# ================================ Copyright  2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================

require( "workspace.init.php" );
require( WORKSPACE_DIR."hp/HpRuntime.class.php" );

/* define Runtime */
$cEGL = new HpRuntime( "EGL.Beta2.HP" );

/* Offline Mode enabled ? */
if( !$cEGL->IsOfflineMode() )
{
	
	# Running Online Mode
	if( $cEGL->Init( 'hp' ) )							# load hp
	{
		$cEGL->Run( 'designs/eglbeta2.tpl' );			# run
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