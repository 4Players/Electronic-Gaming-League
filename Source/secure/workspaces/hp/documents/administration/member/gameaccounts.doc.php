<?php
	global $gl_oVars;
	
	
	# vars
	$iMemberId	= (int)$_GET['member_id'];
	$iGamaccId	= (int)$_GET['gameacc_id'];


	# declare classes/objects
	$cGameAccount	= new GameAccounts( $gl_oVars->cDBInterface );
	$oMember	= $gl_oVars->cMember->GetMemberDataById( $iMemberId );
	$aGameAccounts = $cGameAccount->GetGameAccountsOfMember( $oMember->id );
	
	if( $oMember )
	{
		if( $_GET['a'] == 'change' )
		{
			$bFailed = false;
			for( $i=0; $i < sizeof($aGameAccounts); $i++ )
			{
				$gameacc_value 	= $_POST['gameacc_'.$i];
				$gameacc_id 	= $_POST['gameacc_'.$i.'_id'];
				
				// get game account value
				if( !$cGameAccount->SetGameAccountData( array( "value" => $gameacc_value), $gameacc_id ))
				{
					$bFailed = true;
				}
			}//for
			
			$gl_oVars->cTpl->assign( "success", true );
			$gl_oVars->cTpl->assign( "msg_type", 	"success" );
			$gl_oVars->cTpl->assign( "msg_title", 	"Geändert" );
			$gl_oVars->cTpl->assign( "msg_text", 	"Die GameAccount wurden geändert." );

		} //if
		else if( $_GET['a'] == 'delete' )
		{
			$cGameAccount->DeleteAccount( $iGamaccId );
			
			$gl_oVars->cTpl->assign( "success", true );
			$gl_oVars->cTpl->assign( "msg_type", 	"success" );
			$gl_oVars->cTpl->assign( "msg_title", 	"Gelöscht" );
			$gl_oVars->cTpl->assign( "msg_text", 	"Der GameAccount wurde gelöscht." );
		}//if
		else
		{
			$gl_oVars->cTpl->assign( 'member_data', $oMember );
			$gl_oVars->cTpl->assign( 'game_accounts', $aGameAccounts );
		}//if
	}//if
?>