<?php
	global $gl_oVars;
	

	# update online-list
	$gl_oVars->cLogin->UpdateOnlineList( true/*optimize onlinelist table */ );

	# declare onlinelist class
	$cOnlineList = new OnlineList( $gl_oVars->cDBInterface );
	
	$aOnlineMembers = $cOnlineList->ReadOnlineList();

	
	$gl_oVars->cTpl->assign( "online_members", $aOnlineMembers );
?>