<?php
	global $gl_oVars;
	
	$cFile = new File();
	
	if( isset($_GET['file']))
	{
		$buildfile = FIX_URL_SEP( EGL_SECURE ."debug/output/".$_GET['file'] );
		$cFile->Open( $buildfile, "r" );
	}
	/*if( isset($_GET['offhanded_file']))
	{
		$buildfile = EGL_SECURE ."debug/output/".$buildfile . $_GET['offhanded_file'];
		$cFile->Open( $buildfile, "r" );
	}*/

	$gl_oVars->cTpl->assign( 'buildfile_content', $cFile->Read() );
	$gl_oVars->cTpl->assign( 'buildfile', $_GET['file'] );
	$gl_oVars->cTpl->assign( 'buildfile_root', "[...]".substr( $buildfile, strlen($buildfile)-100, 100) );
	$gl_oVars->cTpl->assign( 'buildfile_access', @fileatime($buildfile) );
	$gl_oVars->cTpl->assign( 'buildfile_access', @fileatime($buildfile) );
	$cFile->Close();	
	
?>