<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-
define( "UPDATEERROR_UPDATE_NOT_FOUND",		2 );


# -[ objectlist ] -


# -[ class ] -
class UpdateProtocol
{
	# -[ variables ]-
	/**
	* save updated files?
	* @var boolean
	*/
	var	$bSave_updatedfiles	= false;

	/**
	* update information
	* @var update_information_t
	*/
	var $UpdateInformation = NULL;
	
	
	/**
	* update-id
	* @var string
	*/
	var $UpdateId = '';
	
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================

	/**
	* UpdateManager constructor
	* 
	*/
	function UpdateProtocol ()
	{
	}

	/**
	* Update::Init
	*/
	function Init( $update_id )
	{
		$this->UpdateId = $update_id;
		$this->UpdateInformation = $this->GetUpdate( $this->UpdateId );
		return false;	
	}
	
	/**
	* UpdateProtocol::Install 
	*
	*/
	function Install()
	{
		echo nl2br( print_r( $this->UpdateInformation, 1));
		
	}
	
	
	/**
	* UpdateProtocol::Uninstall 
	*
	*/
	function Uninstall()
	{
	}
	
	
	/**
	* UpdateProtocol::GetUpdate 
	*
	*/
	function GetUpdate( $update_id )
	{
		$cInstallFactory = new InstallFactory();
		$aLocalUpdates = $cInstallFactory->GetLocalUpdates();
		
		for( $u=0; $u < sizeof($aLocalUpdates); $u++ )
		{
			if( $aLocalUpdates[$u]->description->id == $update_id )
			{
				return $aLocalUpdates[$u];
			}
		}
		return NULL;
	}
	
	
	/**
	* UpdateProtocol::SaveUpdatedFiles 
	*
	*/
	function SaveUpdatedFiles( $bool )
	{
		$this->bSave_updatedfiles = $bool;
		return true;
	}
	
	
	
	/**
	* UpdateProtocol::GetStorageRoot
	*
	*/	
	function GetStorageRoot(){
		return EGL_SECURE.'data'.EGL_DIRSEP.'updates'.EGL_DIRSEP.'storage'.EGL_DIRSEP;
	}
		
};

?>