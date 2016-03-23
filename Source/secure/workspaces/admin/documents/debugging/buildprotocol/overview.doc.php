<?php
	global $gl_oVars;
	
	
	
	# =======================================================================
	# Read standard output files
	# =======================================================================
	$myDirOutput = new MyDirectory();
	$myDirOutput->Open( EGL_SECURE . "debug/output/");
	
	// fetch filearray
	$aFileList = $myDirOutput->GetFiles();
	$myDirOutput->Close();
	
	// read data from files
	$aBuildFiles = array();
	for( $i=0; $i < sizeof($aFileList); $i++ )
	{
		$aBuildFiles[$i]['file'] = $aFileList[$i];
		$aBuildFiles[$i]['access'] = fileatime( EGL_SECURE . "debug/output/". $aFileList[$i]);
	}
	
	# =======================================================================
	# Read offhanded output files
	# =======================================================================
	
	$myDir = new MyDirectory();
	$myDir->Open( EGL_SECURE . "debug/output/offhanded/");
	// fetch filearray
	$aFileList = $myDir->GetFiles();
	$myDir->Close();
	
	
	
	function BuildProtocol_SortFileArrayBy_ATIME( $a, $b )
	{
		if( $a['access'] == $b['access'] ) return 0;
		return ($a['access'] < $b['access']) ? 1 : -1;
	}

	
	// read data from files
	$aOffHandedBuildFiles = array();
	for( $i=0; $i < sizeof($aFileList); $i++ )
	{
		$aOffHandedBuildFiles[$i]['file'] = $aFileList[$i];
		$aOffHandedBuildFiles[$i]['access'] = fileatime( EGL_SECURE . "debug/output/offhanded/". $aFileList[$i]);
	}
	
	usort( $aBuildFiles, "BuildProtocol_SortFileArrayBy_ATIME" );
	usort( $aOffHandedBuildFiles, "BuildProtocol_SortFileArrayBy_ATIME" );
	
	
	$gl_oVars->cTpl->assign( 'buildfiles', $aBuildFiles );
	$gl_oVars->cTpl->assign( 'offhanded_buildfiles', $aOffHandedBuildFiles );
	
?>