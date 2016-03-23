<?php
	global $gl_oVars;

	$cCountry = new Country( $gl_oVars->cDBInterface );
	
	# containing all errors
	$aErrors = array();
	
	# action => save
	if( $_GET['a'] == 'change_profile' )
	{
		# convert memberobbject to array object containing the member data
		$aMemberData = ConvertObjectToArray( $gl_oVars->oMemberData );
		
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
					$update_obj[$var_name]=$var_value;
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
			//$gl_oVars->cTpl->assign( 'msg_title', 	'Es ist ein Fehler aufgetreten' );
			$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4330'] );
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Unknown DB-Error - " . $gl_oVars->cDBInterface->GetLastError() );
		}
		else
		{
			# update vars in member class
			#$g_cMember->UpdateProfil( $update_obj );
			# => UNSICHER !!! unsecure
			
			# reload $aMemberData / $oMemberData
			#$aMemberData =  ConvertObjectToArray( $g_oMemberData );
			#$oMemberData =  $g_cMember->GetData();
			
		
			#echo $aMemberData['id'];
			
			$gl_oVars->cTpl->assign( 'success', 	true );
			$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
			//$gl_oVars->cTpl->assign( 'msg_title', 	'Daten erfolgreich geändern' );
			$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4331'] );
			
			PageNavigation::Location( $gl_oVars->sURLFile."?page=".$gl_oVars->sURLPage );
		}//if
		
		# 
	}//if
	

	
	
	# finally set template array
	
	# save profil data into tpl vars
	#$gl_oVars->cTpl->assign( 'member', $aMemberData );
	$gl_oVars->cTpl->assign( 'countries', $cCountry->GetCountries() );
	
	
	# set checked pubkeys
	$aPubKeys = db_read_array_string( $gl_oVars->oMemberData->profil_public_key );
	for( $ipk=0; $ipk < sizeof($aPubKeys); $ipk++ )
	{
		# set template pubkey as checked
		$gl_oVars->cTpl->assign( 'check_pubkey_'.$aPubKeys[$ipk].'', 'checked' );
	}//for
	

	$gl_oVars->cTpl->assign( 'member_details', $gl_oVars->oMemberData );
?>