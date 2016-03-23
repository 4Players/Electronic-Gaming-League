<?php
	global $gl_oVars;
	
	$cPremiumCode = new PremiumCore( $gl_oVars->cDBInterface );
	
	/*
		ACHTUNG:
			falls kein premium mehr => alle expired melden!!
	*/	
	
	$premium_code = $_POST['code'];
	
	if( $_GET['a'] == 'activate' ){
		$oCode = $cPremiumCode->GetPremiumCode( $premium_code, PARTTYPE_MEMBER );
		if( $oCode ){
			
			if( $oCode->expired || $oCode->activated )
			{
				// code expired
				$gl_oVars->cTpl->assign( 'msg_type',	'error' );
				$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1200'] );
			}
			else
			{
				
				$change_obj = array( 	'part_id'			=> $gl_oVars->iMemberId,		// wichtig, wenn ein anderes mitglied diesen code benutzt
										'activated'			=> 1,
										'activation_time'	=> EGL_TIME,
									);
				$cPremiumCode->UpdateCode( $oCode->id, $change_obj );
				
				$gl_oVars->cTpl->assign( 'msg_type',	'success' );
				$gl_oVars->cTpl->assign( 'msg_text',	$gl_oVars->aLngBuffer['module']['c1201'] );
				
				$gl_oVars->cTpl->assign( 'SUCCESS',		true );
			}
		}//if
	}
	
?>