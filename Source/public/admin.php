<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


#================================
# Global defines
#================================

require( "workspace.init.php" );
require( WORKSPACE_DIR."admin/AdminRuntime.class.php" );

$cEGL = new AdminRuntime();

# Running Online Mode
if( $cEGL->Init( 'admin' ) )
{
	$cEGL->Run( 'frame/noframe.tpl' );			# run
}
$cEGL->Release();								# release 


?>