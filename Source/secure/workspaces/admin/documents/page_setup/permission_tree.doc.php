<?php


	global $gl_oVars;


	$cpt = new PermissionTree();
	$cpt->SetPermissionFile( EGLFILE_PERMISSIONTREE );
	$cpt->CreateTree( 'clan');		# read clan permission-tree

	$gl_oVars->cTpl->assign( 'clan', $cpt->GetRootTree() );		#cpl => Clan Permission List

	$tpt = new PermissionTree();
	$tpt->SetPermissionFile( EGLFILE_PERMISSIONTREE );
	$tpt->CreateTree( 'team');		# read clan permission-tree

	$gl_oVars->cTpl->assign( 'team', $tpt->GetRootTree() );		#cpl => Clan Permission List

	
	
	$apt = new PermissionTree();
	$apt->SetPermissionFile( EGLFILE_PERMISSIONTREE );
	$apt->CreateTree( 'admin');		# read clan permission-tree

	$gl_oVars->cTpl->assign( 'admin', $apt->GetRootTree() );		#cpl => Clan Permission List

	
	
?>