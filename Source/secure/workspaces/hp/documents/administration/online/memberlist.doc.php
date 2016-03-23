<?php
	global $gl_oVars;
	

	# update online-list
	$gl_oVars->cLogin->UpdateOnlineList( true/*optimize onlinelist table */ );

	# declare onlinelist class
	$cOnlineList = new OnlineList( $gl_oVars->cDBInterface );
	$aOnlineMembers = $cOnlineList->ReadOnlineList();
	
	
	$num_onlineuser = sizeof($aOnlineMembers);
	$num_invisisble_onlineuser = 0;
	
	for( $i=0; $i < sizeof($aOnlineMembers); $i++ ){
		if( $aOnlineMembers[$i]->invisible ) $num_invisisble_onlineuser++;
	}

	
	$gl_oVars->cTpl->assign( 'online_members', $aOnlineMembers );
	
	$gl_oVars->cTpl->assign( 'num_onlineuser', $num_onlineuser );
	$gl_oVars->cTpl->assign( 'num_invisisble_onlineuser', $num_invisisble_onlineuser );
?>