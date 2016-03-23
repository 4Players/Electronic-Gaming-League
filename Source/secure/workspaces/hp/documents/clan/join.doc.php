<?php
	global $gl_oVars;
	
	# define clan object 
	$cClan 		= & new Clan( $gl_oVars->cDBInterface );
	
	#---------------------------------
	# if = go ?? 
	#---------------------------------
	/*if( strlen($_POST['join_name'])>0 )
	if( strlen($_POST['join_psd'])>0 )*/
	
	if( $_GET['a'] == 'search' )
	{
		$iClanId 	= (int)$_POST['join_id'];
		$sClanName 	= $_POST['join_name'];
		
		
		$aClanList	= array();
		
		// try searching clan accounts
		if( $iClanId > 0 ){
			$oClan = $cClan->GetClanById( $iClanId );
			if( $oClan ){
				$aClanList[0] = $oClan;
			}
		}
		elseif( strlen($sClanName) > 0 ){
			$aClanList = $cClan->GetClansByName( $sClanName );
		}
		$gl_oVars->cTpl->assign( 'clanlist', $aClanList );		
	}
	# --------------------------------------------------------------
	# try joining clan
	# --------------------------------------------------------------
	else if( $_GET['a'] == 'go' )
	{
		$oClanData	= NULL;
		
		# try to catch clan data
		$oClanData = $cClan->GetClanById( (int)$_POST['clan_id'] );
		
		
		# found ?
		if( $oClanData )
		{
			$bJoined = false;
			$aClanAccounts = $gl_oVars->cMember->GetClanAccounts();
			for( $i=0; $i < sizeof($aClanAccounts); $i++ )
				if( $aClanAccounts[$i]->id == $oClanData->id )
				{
					$bJoined = true;
					break;
				}
					
			# currently in ?
			if( $bJoined )
			{
				$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
				//$gl_oVars->cTpl->assign( 'msg_title', 	'Fehler' );
				$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4734'] );
			}
			else
			{
			
				# team - permission - tree
				$cpt = new PermissionTree();
				$cpt->SetPermissionFile( EGLFILE_PERMISSIONTREE );
				$cpt->CreateTree('clan');
			
				# read last 
				$join_permission = $cpt->GetLast();
				
				# def. create object 
				$join_obj = NULL;
				$join_obj->member_id 	= $gl_oVars->oMemberData->id;
				$join_obj->clan_id	 	= $oClanData->id;
				$join_obj->permissions	= $join_permission->const;
				$join_obj->created		= EGL_TIME; 
				
				
				# -----------------------------------
				# check password
				# -----------------------------------
				if( md5($_POST['join_psd']) != $oClanData->join_password )
				{
					$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
					$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4733'] );
				}else # try to sign join	
					if( $cClan->SignJoin( $join_obj ) )
					{
						$gl_oVars->cTpl->assign( 'success', true );
						
						# SUCCESS
						$gl_oVars->cTpl->assign( 'msg_type', 	'success' );
						$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4735'] );
						
						
						PageNavigation::Location( $gl_oVars->sURLFile.'?page=clan.center&clan_id='.$oClanData->id );
					}
			}//
		}
		else
		{
			# clan search failed !!
			$gl_oVars->cTpl->assign( 'msg_type', 	'error' );
			$gl_oVars->cTpl->assign( 'msg_text', 	$gl_oVars->aLngBuffer['basic']['c4736'] );
		}// if clandata
	}// _get['a'] == 'go'

?>