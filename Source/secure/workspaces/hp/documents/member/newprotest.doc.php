<?php
	global $gl_oVars;

	$cProtests = new Protests( $gl_oVars->cDBInterface );
	$cMatch	= new Match( $gl_oVars->cDBInterface );
	
	if( $_GET['a'] == 'go' ){
		$error = false;
		
		$iMatchId	= (int)$_POST['match_id'];
		if( strlen($_POST['match_id']) > 0) {
			if( !$cMatch->GetMatch($iMatchId)){
				$gl_oVars->cTpl->assign( 'msg_type', 'error' );
				$gl_oVars->cTpl->assign( 'msg_text', $gl_oVars->aLngBuffer['basic']['c8203'] );
				
				$error = true;
			}
		}
		else{
			$iMatchId = EGL_NO_ID;
		}

		
		if( !$error )
		{
					
			$obj = array( 	'match_id'			=> $iMatchId,
							'member_id'			=> $gl_oVars->iMemberId,
							'subject'			=> $_POST['subject'],
							'text'				=> $_POST['text'],
							'created'			=> EGL_TIME,
							'administrated'		=> 0,
						);
			if( $cProtests->NewProtest( $obj ) ){
				PageNavigation::Location( $gl_oVars->sURLFile.'?page=member.protests' );
			}//if
			else
			{
				$gl_oVars->cTpl->assign( 'msg_type', 'error' );
				$gl_oVars->cTpl->assign( 'msg_text', $gl_oVars->aLngBuffer['basic']['c82034'] );
			}//if
		}//if
	}//if
	
	if( $_POST['match_id'] ) $gl_oVars->cTpl->assign( 'MATCH_ID', $_POST['match_id'] );
	if( $_GET['match_id'] ) $gl_oVars->cTpl->assign( 'MATCH_ID', $_GET['match_id'] );
	
?>