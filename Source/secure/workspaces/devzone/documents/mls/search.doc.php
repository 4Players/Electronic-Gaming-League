<?php
	global $gl_oVars;
	
	# url params
	$lng	= (string)$_POST['lng'];
	if( !strlen($lng)) $lng = 'de';
	
	
	# classes/objects
	$cLanguage = new Language();

	
	
	
	# list all language files
	$aModules = $gl_oVars->cModuleManager->GetModules();
	

	# buffer, containing all language files
	$aLanguageFiles	= array();
	//$lng_data 		= array();	
	
	
	#--------------------------------------
	# MODULE LANGUAGE-DATA
	#--------------------------------------

	// modules included ?	=> possible:  all, base, {MODULE_ID}
	for( $i=0; $i < sizeof($aModules); $i++ )
	{
		if( $_POST['platform'] == 'all' or 
			$_POST['platform'] == $aModules[$i]->ID )
		{
			// EGL_ROOT/secure/modules/{MODULE_NAME}/workspaces/{WORKSPACE}/language
			
			$mod_workspaces = EGL_SECURE.'modules'.EGL_DIRSEP.$aModules[$i]->sModulePath.EGL_DIRSEP.'workspaces'.EGL_DIRSEP;
			
			$cDir = new MyDirectory();
			if($cDir->Open( $mod_workspaces ) )
			{
				$aWorkspaces = $cDir->GetDirs();
				$cDir->Close();
			}
			
			
			//echo "<br>".$mod_lng;
			for( $d=0; $d < sizeof($aWorkspaces); $d++)
			{
				
				if( $_POST['workspace'] == 'all' or 
					$_POST['workspace']	== $aWorkspaces[$d] )
				{
					$mod_lng_file = $mod_workspaces.$aWorkspaces[$d].EGL_DIRSEP.'languages'.EGL_DIRSEP.$lng.'.lng';
					$mod_lng_path = $mod_workspaces.$aWorkspaces[$d].EGL_DIRSEP.'languages'.EGL_DIRSEP; //.$lng.'.lng';
					
					if( file_exists($mod_lng_file))
					{
						$aLanguageFiles[sizeof($aLanguageFiles)] = array(	'location' => 'module',
																			'workspace' => $aWorkspaces[$d],
																			'module_id' => $aModules[$i]->ID,
																			'module_name' =>$aModules[$i]->sName,
																			'file' => $mod_lng_file,
																			'path' => $mod_lng_path,
																			'lng_buffer' => array()
																		);
						$cLng = new Language();
						$cLng->SetLanguage( $lng );
						$cLng->ParseFile( $mod_lng_path, $aLanguageFiles[sizeof($aLanguageFiles)-1]['lng_buffer'] );
						// echo "<br/> <b>".$lng_file."</b>";
					}
					else 
					{
						// echo "<br/> <font color='red'><b>".$lng_file."</b></font>";
					}
				}//if
				
			}//for
		}//if
		
	}// for
	
	
	#--------------------------------------
	# BASE LANGUAGE-DATA
	#--------------------------------------
	$base_workspaces = EGL_SECURE.'workspaces'.EGL_DIRSEP;
	
	$cDir = new MyDirectory();
	if($cDir->Open( $base_workspaces ))
	{
		$aWorkspaces = $cDir->GetDirs();
		$cDir->Close();
	}
	
	if( $_POST['platform'] == 'all' or 
		$_POST['platform'] == 'base' )
	{

		for( $d=0; $d < sizeof($aWorkspaces); $d++ )
		{
			if( $_POST['workspace'] == 'all' or 
				$_POST['workspace']	== $aWorkspaces[$d] )
			{
				$base_lng_file = $base_workspaces.$aWorkspaces[$d].EGL_DIRSEP.'languages'.EGL_DIRSEP.$lng.'.lng';
				$base_lng_path = $base_workspaces.$aWorkspaces[$d].EGL_DIRSEP.'languages'.EGL_DIRSEP; //.$lng.'.lng';
				
				if( file_exists($base_lng_file))
				{	
					$aLanguageFiles[sizeof($aLanguageFiles)] = array(	'location' => 'basic',
																		'workspace' => $aWorkspaces[$d],
																		'module_id' => '--',
																		'module_name' => '--',
																		'file' => $base_lng_file,
																		'path' => $base_lng_path,
																		'lng_buffer' => array()
																	);
					$cLng = new Language();
					$cLng->SetLanguage( $lng );
					$cLng->ParseFile( $base_lng_path, $aLanguageFiles[sizeof($aLanguageFiles)-1]['lng_buffer'] );
					// echo "<br/> <b>".$lng_file."</b>";
				}
				else 
				{
					// echo "<br/> <font color='red'><b>".$lng_file."</b></font>";
				}
			}//if
		}//for	
	}//if


		
	if( $_POST['action'] == 'go')
	{
		# ---------------
		# start search
		# ---------------
		$search_key	= $_POST['search_key'];
		$aResults	= array();
		
		for( $f=0; $f < sizeof($aLanguageFiles); $f++ )
		{
			foreach ($aLanguageFiles[$f]['lng_buffer'] as $key => $value) 
			{
				if( strlen($search_key) > 0 )
				if( $_POST['search_type'] == 'keyword')
				{
					if( strchr( strtoupper($value), strtoupper($search_key)) )
					{
						//echo "test";
						$aResults[sizeof($aResults)]	= 
						array(
								'location' => $aLanguageFiles[$f]['location'],
								'module_id' => $aLanguageFiles[$f]['module_id'],
								'module_name' => $aLanguageFiles[$f]['module_name'],
								'workspace' => $aLanguageFiles[$f]['workspace'],
								'file' => '[..]'.substr( $aLanguageFiles[$f]['file'], strlen($aLanguageFiles[$f]['file'])-50, 50),
								'key' => $key,
								'value' => $value,
								'search_key' => $search_key,
							);
					}//if
	   				// echo "Schlüssel: $key; Wert: $value<br />\n";
				}
				elseif( $_POST['search_type'] == 'id' )
				{
					if( strchr( strtoupper($key),  strtoupper($search_key)) )
					{
						//echo "test";
						$aResults[sizeof($aResults)]	= 
						array(
								'location' => $aLanguageFiles[$f]['location'],
								'module_id' => $aLanguageFiles[$f]['module_id'],
								'module_name' => $aLanguageFiles[$f]['module_name'],
								'workspace' => $aLanguageFiles[$f]['workspace'],
								'file' => '[..]'.substr( $aLanguageFiles[$f]['file'], strlen($aLanguageFiles[$f]['file'])-50, 50),
								'key' => $key,
								'value' => $value,
								'search_key' => $search_key,
							);
					}//if
					
				}//if
   				
			}//foreach
		}//for
		
		$gl_oVars->cTpl->assign( 'RESULTS', $aResults );
	}//if
	
	
	
	
	$aSupportedLanguages = $cLanguage->GetSupportedLanguagesFromWorkspace( $gl_oVars->sWorkspace );
	$gl_oVars->cTpl->assign( 'languages', $aSupportedLanguages );
		

	$gl_oVars->cTpl->assign( "MODULES", $aModules );
	$gl_oVars->cTpl->assign( "WORKSPACES", $aWorkspaces );

?>