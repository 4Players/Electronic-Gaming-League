<?php
	global $gl_oVars;

	# set members per page
	$members_per_page	= 30;
	
	
	$limit_start		= (int)$_GET['pos'];
	$limit_cnt			= $members_per_page;
	
	
	# fetch memberdata from
	$aMembers = $gl_oVars->cMember->GetLimitedMemberlist( $limit_start, $limit_cnt, ' members.created ', '  DESC ' );
	$numMembers = $gl_oVars->cMember->GetNumMembers();
	
	# fetch publickeys
	
	$memberlist_cnt=sizeof($aMembers);
	for( $iMember=0; $iMember < $memberlist_cnt; $iMember++)
	{
		# set checked pubkeys
		$aPubKeys = db_read_array_string( $aMembers[$iMember]->profil_public_key );
		
		$aMembers[$iMember]->publickeys = array();
		for( $ipk=0; $ipk < sizeof($aPubKeys); $ipk++ )
		{
			$aMembers[$iMember]->public_keys[$aPubKeys[$ipk]] = true;
		}//ifr
	}//for
	
	
	$num_pages	= ($numMembers/$members_per_page);
	if( !is_int($num_pages) ) $num_pages = ((int)$num_pages)+1;	
	if( $limit_start == 0 ) $curr_page=0;
	else $curr_page = (int)($limit_start/$members_per_page);
	

	$gl_oVars->cTpl->assign( 'members_per_page', $members_per_page );
	$gl_oVars->cTpl->assign( 'num_pages', $num_pages );
	$gl_oVars->cTpl->assign( 'curr_page', $curr_page );
	
	$gl_oVars->cTpl->assign( 'num_members', $numMembers );
	$gl_oVars->cTpl->assign( 'members', $aMembers );
?>