<?php
	global $gl_oVars;
	
	# ------------------------------------------------------------------------
	$iProtestId	= (int)$_GET['protest_id'];
	$_GET['comment']='write';

	
	$cMatch 	= NULL;
	$cProtests	= new Protests( $gl_oVars->cDBInterface );

	# fetch data
	$oProtest	= $cProtests->GetProtest($iProtestId);

	if( $oProtest )
	{
	
		#---------------------------------------------------------------
		// U P D A T E    ACCESS-TIME
		#---------------------------------------------------------------
		$ac_obj = array( 	'adminaccess_member_id'		=> $gl_oVars->oMemberData->id,
							'adminaccess_time' 			=> EGL_TIME,
						);
		if( $cProtests->SetProtestData( $ac_obj, $iProtestId) )
		{
			//PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLPage.'&protest_id='.$iProtestId );
		}//if setprotestdata
	
		if( $_GET['a'] == 'delete' ){
			if( $cProtests->RemoveProtest( $iProtestId ) )
			{
				PageNavigation::Location( $gl_oVars->sURLFile.'?page=overview' );
			}
		}//if
		
		$gl_oVars->cTpl->assign( 'protest',  $oProtest );
		#if( $oMatch )$gl_oVars->cTpl->assign( 'match',  $oMatch );
	}
?>