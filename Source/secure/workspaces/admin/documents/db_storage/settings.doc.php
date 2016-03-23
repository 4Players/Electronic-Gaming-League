<?php
	global $gl_oVars;
	
	

	
	//==========================================================
	// Change data
	//==========================================================
	if( $_GET['a'] == "change" )
	{
		$cFile = new File();
		if( $cFile->Open( EGL_SECURE.'configs'.EGL_DIRSEP.'db_settings.cfg.php', 'w' ))
		{
			$cFile->Write( "<?php\n" );
			$cFile->Write( "class db_connecting_data\n" );
			$cFile->Write( "{\n" );
			$cFile->Write( "	var \$dbbib	= \"".strip_tags($_POST['db_bib'])."\";\n" );
			$cFile->Write( "	var \$server = \"".strip_tags($_POST['db_server'])."\";\n" );
			$cFile->Write( "	var \$database = \"".strip_tags($_POST['db_database'])."\";\n" );
			$cFile->Write( "	var \$username = \"".strip_tags($_POST['db_username'])."\";\n" );
			$cFile->Write( "	var \$password = \"".strip_tags($_POST['db_password'])."\";\n" );
			$cFile->Write( "}\n" );
			$cFile->Write( "?>" );
			$cFile->Close();
			
			$gl_oVars->cTpl->assign( "success", true );
			$gl_oVars->cTpl->assign( "msg_type", 	"success" );
			$gl_oVars->cTpl->assign( "msg_title", 	"Einstellungen geändert" );
			$gl_oVars->cTpl->assign( "msg_text", 	"Die Datenbank Einstellungen wurde erfolgreich gespeichert." );
		}//if
		
	}
	//==========================================================
	// 
	//==========================================================
	else
	{
		
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
		
		
		// define object
		$connecting_data	= new db_connecting_data;
		
		// create db object
		$db = array( 'server'	=> $connecting_data->server,
					 'username'	=> $connecting_data->username,
					 'password'	=> $connecting_data->password,
					 'database'	=> $connecting_data->database,
					 'dbbib'	=> $connecting_data->dbbib );
					 
	
		$gl_oVars->cTpl->assign( 'db_lasterror', $gl_oVars->cDBInterface->GetLastError() );
		$gl_oVars->cTpl->assign( 'db_bibs', $aDBBibs );
		$gl_oVars->cTpl->assign( 'db', $db );
	}
	
?>