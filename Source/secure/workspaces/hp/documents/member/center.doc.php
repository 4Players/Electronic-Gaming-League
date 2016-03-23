<?php	
		global  $gl_oVars;
		
		$cClan	= new Clan( $gl_oVars->cDBInterface );
		
		
		#----------------------------------------------------------------------
		# fetch cmod links
		#----------------------------------------------------------------------
		
		//$aModules = array();
		$aModules = $gl_oVars->cModuleManager->GetActivatedModules();
		$aModLinks = array();
		# fetch each links
		for( $i=0; $i < sizeof($aModules); $i++ )
		{
			$aLinks = array();
			
			module_sendmessage( $aModules[$i]->ID, 'get_member_links', $aLinks/*OUTPUT*/, $gl_oVars->iMemberId );
			
			if( sizeof($aLinks) > 0 )
			{
				$pModLinks = & $aModLinks[sizeof($aModLinks)];
				$pModLinks = new module_tpl_links_t;
				$pModLinks->aLinks = $aLinks;
				$pModLinks->sCaption = $aModules[$i]->sName;
				
			}//if
		}//for

		# add to tpl
		$gl_oVars->cTpl->assign( 'member', 			$gl_oVars->oMemberData );
		$gl_oVars->cTpl->assign( 'module_links', 	$aModLinks );
		$gl_oVars->cTpl->assign( 'clan_invites', 	$cClan->GetNumRawMemberInvites($gl_oVars->oMemberData->id) );

?>