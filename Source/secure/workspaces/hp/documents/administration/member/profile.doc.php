<?php
	global $gl_oVars;
	
	$iMemberId	= (int)$_GET['member_id'];
	

	$cCountry = new Country( $gl_oVars->cDBInterface );
	$oMemberData = $gl_oVars->cMember->GetMemberDataById( $iMemberId );
	
	
	
	if( $oMemberData )
	{
		$gl_oVars->cTpl->assign( 'member_data', $oMemberData );

	
		# containing all errors
		$aErrors = array();
	
		# ---------------------------------------------------------------
		# deactivate => activation-code
		# ---------------------------------------------------------------
		if( $_GET['a'] == 'activate' )
		{
			$member_obj = array( 	'activation_time'	=> EGL_TIME,
									//'activated'			=> 1,
								);
			$gl_oVars->cDBInterface->Query( $gl_oVars->cDBInterface->CreateUpdateQuery( $GLOBALS['g_egltb_members'], $member_obj ).' WHERE id='.$iMemberId );
			
			// forward
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLPage.'&member_id='.$iMemberId );
		}
		# ---------------------------------------------------------------
		# activate => activation-code
		# ---------------------------------------------------------------
		if( $_GET['a'] == 'deactivate' )
		{
			$member_obj = array( 	'activation_time'	=> 0,
									//'activated'			=> 0,
								);
			$qre = $gl_oVars->cDBInterface->Query( $gl_oVars->cDBInterface->CreateUpdateQuery( $GLOBALS['g_egltb_members'], $member_obj ).' WHERE id='.$iMemberId );
			
			
			// forward
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLPage.'&member_id='.$iMemberId );
		}
		# ---------------------------------------------------------------
		# action => save
		# ---------------------------------------------------------------
		if( $_GET['a'] == 'change_profile' )
		{
			# convert memberobbject to array object containing the member data
			$aMemberData = ConvertObjectToArray( $oMemberData );
			
			$update_obj = array();
			$public_key	= NULL;		
			$str_public_key	= "";
			$pubkey_cnt = 0;
		
			# get all inputs
			while( list($var_name, $var_value) = each($_POST) ) 
			{
				# is that a mysql field ? => right ?
				if( Isset( $aMemberData[$var_name] ) )
				{
					# only save => different
					if( $aMemberData[$var_name] != $var_value )
					{
						if( $var_value != '{NO CHANGES}' )
						{
							#-----------------------------------------
							# data currently exists ?
							#-----------------------------------------
							if( isset($_POST['no_doubleitem_'.$var_name]) )
							{
								$search_obj = NULL;
								
								$sql_query = "SELECT COUNT(*) AS num_results FROM ".$GLOBALS['g_egltb_members']." WHERE $var_name='".$gl_oVars->cDBInterface->EscapeString($var_value)."' GROUP BY id";
								$res = $gl_oVars->cDBInterface->FetchObject($gl_oVars->cDBInterface->Query( $sql_query ));
								
								if( $res->num_results == 0 ) $update_obj[$var_name]=$var_value;
								else
								{
									$gl_oVars->cTpl->assign( 'clr_no_doubleitem_'.$var_name, '#A80000' ); 
									$aErrors[sizeof($aErrors)] = "Currently in use";
								}//if
							}//if
							else $update_obj[$var_name]=$var_value;
						}//if
					}//if
				}//if
				
							
				
				# public key filter => reading
				if( substr($var_name, 0, strlen('pubkey_') ) == 'pubkey_' )
				{
					$field_name = substr( $var_name, strlen('pubkey_'), strlen($var_name)-strlen('pubkey_') );
					$str_public_key .= $field_name . ',';
					$pubkey_cnt++;
				}
				
			}//while
	
			# kill last comma 'field1,filed2,' <-
			if( strlen($str_public_key) > 0 )
			{
				 $str_public_key = substr( $str_public_key, 0, strlen($str_public_key)-1);
				 $update_obj['profil_public_key'] = $str_public_key;
			}
			else
			{	
				# set empry key
				$update_obj['profil_public_key'] = "";
			}
			
			# ---------------------------
			# run mysql update
			# ---------------------------
			$update_query = $gl_oVars->cDBInterface->CreateUpdateQuery( $GLOBALS['g_egltb_members'], $update_obj )
							. " WHERE id=" . $aMemberData['id'];
	
	
			# execute query
			$qre = $gl_oVars->cDBInterface->Query( $update_query );
			
			# query failed ?
			if( !$qre )
			{
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
				$gl_oVars->cTpl->assign( 'msg_text', 	'Mysql-Error:' . $gl_oVars->cDBInterface->GetLastError() );
			}
			else
			{
			
	
				# errors avaiable ?
				if( sizeof($aErrors) )
				{
					$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
					$gl_oVars->cTpl->assign( 'msg_text', 	'Es sind folgende Fehler aufgetreten');
					$gl_oVars->cTpl->assign( 'msg_errors', 	$aErrors);
				}
				else
				{
					$gl_oVars->cTpl->assign( 'success', 	true );
					$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
					$gl_oVars->cTpl->assign( 'msg_text', 	'Sie haben Ihre Einstellungen erfolgreich geändernt!');
				}//if
				
			}//if query failed
			
			# 
		}//if $_GET'a' == change_profil
		
	
		
		
		# finally set template array
		
		# save profil data into tpl vars
		#$gl_oVars->cTpl->assign( 'member', $aMemberData );
		$gl_oVars->cTpl->assign( 'countries', $cCountry->GetCountries() );
		
		
		# set checked pubkeys
		$aPubKeys = db_read_array_string( $oMemberData->profil_public_key );
		for( $ipk=0; $ipk < sizeof($aPubKeys); $ipk++ )
		{
			# set template pubkey as checked
			$gl_oVars->cTpl->assign( 'check_pubkey_'.$aPubKeys[$ipk].'', 'checked' );
		}//for
		
	}//if $omemberdata
?>