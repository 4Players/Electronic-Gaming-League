<?php
	global $gl_oVars;

	
	$aCMods = $gl_oVars->cModuleManager->GetActivatedModules();

	$aEntryList	= array();
	for( $i=0; $i < sizeof($aCMods); $i++ )
	{
		$aEntryList[$i] = module_sendmessage( $aCMods[$i]->ID, 'entry_list',  $__DATA__, $gl_oVars->oMemberData->id, PARTTYPE_MEMBER );
	}

	
	// provide templatesystem with data
	$gl_oVars->cTpl->assign( 'entrylist',	$aEntryList);
	$gl_oVars->cTpl->assign( 'modules',		$aCMods);
	
?>