<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================

require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'wizard'.EGL_DIRSEP.'NavigationWizard.class.php');


class InstallWizardRuntime extends RuntimeEngine 
{
	var $cInstallWizard = NULL;

	function FirstInits(){
		global $gl_oVars;
		$gl_oVars->bAutoloadModules = false;
		return 1;
	}
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------
	function InitPage()
	{
		global $gl_oVars;
		$gl_oVars->pcRuntimeEngine->cInstallWizard = new NavigationWizard();
		
		
		if( $_SESSION['mode'] == 'install' )
		{
			# define 
			$gl_oVars->pcRuntimeEngine->cInstallWizard->NewWizardSheet( 'systemcheck' );
			$gl_oVars->pcRuntimeEngine->cInstallWizard->NewWizardSheet( 'mode' );
			$gl_oVars->pcRuntimeEngine->cInstallWizard->NewWizardSheet( 'install.start' );
			$gl_oVars->pcRuntimeEngine->cInstallWizard->NewWizardSheet( 'install.security.db' );
			$gl_oVars->pcRuntimeEngine->cInstallWizard->NewWizardSheet( 'install.security.configsheet' );
			$gl_oVars->pcRuntimeEngine->cInstallWizard->NewWizardSheet( 'install.mailing' );
			$gl_oVars->pcRuntimeEngine->cInstallWizard->NewWizardSheet( 'install.modules' );
			$gl_oVars->pcRuntimeEngine->cInstallWizard->NewWizardSheet( 'install.finish' );

		}
		else if( $_SESSION['mode'] == 'configure' )
		{
			# define 
			$gl_oVars->pcRuntimeEngine->cInstallWizard->NewWizardSheet( 'mode' );
			$gl_oVars->pcRuntimeEngine->cInstallWizard->NewWizardSheet( 'configure.start' );

		}
		
	
		return 1;
	}	
}

?>