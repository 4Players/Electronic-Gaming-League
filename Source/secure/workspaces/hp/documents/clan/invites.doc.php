<?php
	global $gl_oVars;

	
	# declare classes & objects
	$cClan 	= new Clan( $gl_oVars->cDBInterface );
	$aClanInvites = $cClan->GetClanInvites( (int)$_GET['clan_id']) ;

	
	
	if( $_GET['a'] == 'delete' )
	{
		$iInviteId = (int)$_GET['invite_id'];
		
		for( $i=0; $i < sizeof($aClanInvites); $i++ )
		{
			if( $aClanInvites[$i]->invite_id == $iInviteId )
				break;
		}//for

		# access	
		if( $i == sizeof( $aClanInvites))
		{
			// Sie haben keine Berechtigung diese Einladung zu bearbeiten.
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );			
			$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4631'] );			
		}//if
		else
		{
			if(  $aClanInvites[$i]->processed )
			{
				// Diese Einladung kann nicht mehr verändert werden
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );			
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4632'] );			
			}
			else
			{
				$cClan->DeleteInvite( $iInviteId );
				
				$gl_oVars->cTpl->assign( 'success', 	true );			
				$gl_oVars->cTpl->assign( 'msg_type', 	'success' );			
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4633'] );			
				
			}//if
		}//if
		
	}//if
	
	################################################################################################
	
	$gl_oVars->cTpl->assign( 'clan_invites', $aClanInvites );

?>