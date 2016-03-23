<?php
	global $gl_oVars;



	if( $_GET['a'] == 'admin' )
	{
		# get om Messages / outcoming / incoming
		
		if( $_GET['show'] == 'input' )$gl_oVars->cMember->FillMessageBuffer( true, false );
		if( $_GET['show'] == 'output' )$gl_oVars->cMember->FillMessageBuffer( false, true );
		
		$cPM = new PM( $gl_oVars->cDBInterface );
		
		# read 
		$pm_messages = & new pm_messages_t;
		$pm_messages = $gl_oVars->cMember->GetMessages( $_GET['show'] );
		
		

		#-----------------------------------------------------------
		# INPUT
		#-----------------------------------------------------------
		if( $_GET['show'] == 'input' )
		{
			for( $i=0; $i < sizeof($pm_messages->aInput); $i++ )
			{
				if( $_POST['sel_pm_'.$i] )
				{
					for( $s=0; $s < sizeof($pm_messages->aInput); $s++ )
						if( $_POST['sel_pm_'.$i] == $pm_messages->aInput[$i]->id )
							break;
					if( $s != sizeof($pm_messages->aInput) )
					{
						$cPM->DeleteMessage( $_POST['sel_pm_'.$i] );
					}//if
				}
			}//for
		}//if input
		
		
		#-----------------------------------------------------------
		# OUTPUT
		#-----------------------------------------------------------
		if( $_GET['show'] == 'output' )
		{
			for( $i=0; $i < sizeof($pm_messages->aOutput); $i++ )
			{
				if( $_POST['sel_pm_'.$i] )
				{
					for( $s=0; $s < sizeof($pm_messages->aOutput); $s++ )
						if( $_POST['sel_pm_'.$i] == $pm_messages->aOutput[$i]->id )
							break;
					if( $s != sizeof($pm_messages->aOutput) )
					{
						$cPM->DeleteMessage( $_POST['sel_pm_'.$i] );
					}//if
				}
			}//for
		}//if input		
		
	}//if


	
	# ------------------------------
	# Input - get buffer
	# ------------------------------
	if( $_GET['show'] == 'input' || !Isset( $_GET['show'] ) )
	{

		# get om Messages / outcoming / incoming
		$gl_oVars->cMember->FillMessageBuffer( true );

		# read 
		$pm_messages = & new pm_messages_t;
		$pm_messages = $gl_oVars->cMember->GetMessages( 'input' );
		

		# check whether the buffer is filled
		if( sizeof($pm_messages->aInput) > 0 )
		{
			$gl_oVars->cTpl->assign( 'pm_input', $pm_messages->aInput );
		}
		
		#  set input
		$gl_oVars->cTpl->assign( 'pm_show_input', 1 );
	}
	
	# ------------------------------
	# Output - get buffer
	# ------------------------------
	else if( $_GET['show'] == 'output' )
	{
		# get om Messages / outcoming / incoming
		$gl_oVars->cMember->FillMessageBuffer( false, true );

		# read 
		$pm_messages = & new pm_messages_t;
		$pm_messages = $gl_oVars->cMember->GetMessages( 'output' );

		# check whether the buffer is filled
		if( sizeof($pm_messages->aOutput) > 0 )
		{
			$gl_oVars->cTpl->assign( 'pm_output',  $pm_messages->aOutput );
		}
		
		#  set output
		$gl_oVars->cTpl->assign( 'pm_show_output', 1 );
	}
	
	
	
	
	


?>
