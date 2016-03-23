<?php
# =========================================
# login.tpl 
# =========================================
	global $gl_oVars;

	
	# --------------------------------
	# login ?
	# --------------------------------
	
	# currently logged in ?
	if( $gl_oVars->bLoggedIn )
	{
		$gl_oVars->cTpl->assign( 'msg_type', 	'warning'  );
		//$gl_oVars->cTpl->assign( 'msg_title', 	'Warnung' );
		$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c1064']  );
	}
	else	# => Try Login
	if( $_GET['a'] == 'go' )
	{
		# try login
		$login_try = & new login_try_t;
	
		/********************************
		* Member-ID Login?
		********************************/
		if( is_integer( (int)$_POST['login_id']) && (int)$_POST['login_id'] != 0  ){
			$login_try = $gl_oVars->cLogin->TryLogin( $_POST['login_id'], $_POST['login_psd'] );
		}
		/********************************
		* E-Mail Login?
		********************************/
		else {
			$login_try = $gl_oVars->cLogin->TryLogin( $_POST['login_id'], $_POST['login_psd'], true );
		}
		
		switch( $login_try->result )
		{
			# LOGIN FAILED
			case LOGIN_TRY_FAILED:
				{
					$gl_oVars->cTpl->assign( 'msg_type', 	'error'  );
					$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c1060']  );
					
				
				}break;
			case LOGIN_TRY_SUCCESSED:
				{
					# set login success vars
					$g_bLoggedIn = true;
					
					# load member daten
					$gl_oVars->cMember->SetId( $_SESSION['login']['id'] );
					$gl_oVars->cMember->FillBaseBuffers(/*clan structure ?*/);
					
					$gl_oVars->cTpl->assign( 'login_success', 1 );
					
					# load template data
					$gl_oVars->cTpl->assign( 'name', 	$login_try->nickname );
				
					$gl_oVars->cTpl->assign( 'msg_type',   	'success'  );
					$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c1061'] );
					
					// forwarding to center
					PageNavigation::Location( $gl_oVars->sURLFile.'?page=member.center' );
					
				}break;
			case LOGIN_MEMBER_NOT_ACTIVATED:
				{
					$gl_oVars->cTpl->assign( 'msg_type', 	'error'  );
					//$gl_oVars->cTpl->assign( 'msg_title', 	"Login Fehlgeschlagen"  );
					$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c1062']  );
				}break;
			case LOGIN_MEMBER_LOCKED:
				{
					$gl_oVars->cTpl->assign( 'msg_type', 	'error'  );
					//$gl_oVars->cTpl->assign( 'msg_title', 	"Login Fehlgeschlagen"  );
					$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c1063']   );
				}break;
		}//switch
		
	} // if get=go ?	
?>