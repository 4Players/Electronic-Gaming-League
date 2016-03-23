<?php
	global $gl_oVars;
	
	
	// objects
	$cLogin = new Login( $gl_oVars->cDBInterface );
	$cOnlineList = new OnlineList( $gl_oVars->cDBInterface );
	
	// update current online-list
	$cLogin->UpdateOnlineList();
	
	$aOnlineMembers = $cOnlineList->ReadOnlineList();
	
	
	$num_onlineuser = sizeof($aOnlineMembers);
	$num_invisible_onlineuser = 0;
	
	for( $i=0; $i < sizeof($aOnlineMembers); $i++ ){
		if( $aOnlineMembers[$i]->invisible ) $num_invisible_onlineuser++;
	}

	
	$gl_oVars->cTpl->assign( 'online_member', $aOnlineMembers );
	
	$gl_oVars->cTpl->assign( 'num_onlineuser', $num_onlineuser );
	$gl_oVars->cTpl->assign( 'num_invisible_onlineuser', $num_invisible_onlineuser );
?>