<?php
	global $gl_oVars;
	
		
	// fetch navigation routing
	$next_sheet = $gl_oVars->pcRuntimeEngine->cInstallWizard->NextSheetByName( $gl_oVars->sURLPage );
	$prev_sheet = $gl_oVars->pcRuntimeEngine->cInstallWizard->PrevSheetByName( $gl_oVars->sURLPage );

	
	# --------------------------------------------
	# SAVE INPUT TO TMPVARS	
	# --------------------------------------------	
	if( $_GET['a'] == 'next' )
	{
		$bJumpNext = false;
	
		/*
		// try to establish SQL connection
		$_POST['dbinterface'];
		$_POST['server'];
		$_POST['database'];
		$_POST['username'];
		$_POST['password'];*/
		

		
		$cDBConnection = new DBConnection();
		if( ($cDBConnection = DBInterfaceFactory::DBInterfaceFactory( $_POST['dbinterface'])) != NULL )
		{
			if( $cDBConnection->Connect( $_POST['server'], $_POST['username'], $_POST['password'], $_POST['database'] ) )
			{
				# save, do nothing
				# => CONNECTION RIGHT!
				$bJumpNext = true;
				
			}else
			{
				# set error as output
				$gl_oVars->cTpl->assign( "PAGE_ADVICE",  
										Templates::ParseContent( $gl_oVars->aLngBuffer['basic']['c2105'], $gl_oVars->cTpl, array( 'error_msg' => $cDBConnection->GetLastError() )) );
			}
		}else
		{
			# set unknown error as output
			$gl_oVars->cTpl->assign( "PAGE_ADVICE",  $gl_oVars->aLngBuffer['basic']['c2106'] );
		}
		
		
	
		# ---------------------------
		# routing to next page
		# ---------------------------
		if( $next_sheet && $bJumpNext ){
			

			$_SESSION[$gl_oVars->sURLPage]['db']['interface'] 	= $_POST['dbinterface'];
			$_SESSION[$gl_oVars->sURLPage]['db']['server'] 		= $_POST['server'];
			$_SESSION[$gl_oVars->sURLPage]['db']['database'] 	= $_POST['database'];
			$_SESSION[$gl_oVars->sURLPage]['db']['username'] 	= $_POST['username'];
			$_SESSION[$gl_oVars->sURLPage]['db']['password'] 	= $_POST['password'];
			
			
		
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$next_sheet['name'] );
		}
	}
	else
	{
		# set current advice 
		$gl_oVars->cTpl->assign( "PAGE_ADVICE", $gl_oVars->aLngBuffer['basic']['c2104'] );
	}
	
	
	
		
		/*****************************************************
		* search sql apis
		*****************************************************/
		$aDBBibs = array();
		$cMyDir = new MyDirectory();
		if( $cMyDir->Open( EGL_SECURE . 'classes'.EGL_DIRSEP.'dbcon'.EGL_DIRSEP ))
		{
			
			$aDBBibsList = $cMyDir->GetFiles( array( 'php' ) );
	
			for( $n=0; $n < sizeof($aDBBibsList); $n++ )
			{
				$class_name = substr( $aDBBibsList[$n], 0, strlen($aDBBibsList[$n])-strlen('.class.php'));
				if( correct_class_name($class_name) )
				{
					 $aDBBibs[sizeof($aDBBibs)]  = $class_name;
				}//if
			}//for
			$cMyDir->Close();
		}//if
		
		$gl_oVars->cTpl->assign( "URL_PREV", $gl_oVars->sURLFile.'?page='.$prev_sheet['name'] );
		
		$gl_oVars->cTpl->assign( 'dbinterfaces', $aDBBibs );
	
?>