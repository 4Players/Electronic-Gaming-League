<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -
/**
* all descriptions about update id, version, released, publisher, size
* update_description_t
*/
class update_description_t
{
	/**
	* update-id	36-char string
	* @var string
	*/
	var $id;
	
	
	/**
	* specification, security, renewal, upgrading, special
	* @var string
	*/
	var $specification;
	

	/**
	* release date, integer
	* @var integer
	*/	
	var $version;
	
	
	/**
	* release date, integer
	* @var integer
	*/
	var $released;
	
	
	/**
	* publisher-name 255 string
	* @var string
	*/
	var $publisher;
	
	
	/**
	* array() : value as integer, unit as string(kb/bytes/mb)
	* @var array
	*/
	var $size;			
	
	
	/**
	* update description text
	* @var string
	*/
	var $details;
	
	
	/**
	* update-id list of required updates, installed
	* @var array of update-ids
	*/
	var $required_updates;	
	
	
	
};

/**
* update_install_t
*/
class update_install_t
{
	var $items	= array();
};


/**
* update_install_item_t
*/
class update_install_item_t
{
	var $action_id	= -1;
	var $type		= 'UNKNOWN';
	var $params		= array();
};


/**
* update_instructions_t
*/
class update_instructions_t
{
	var $execs	= array();
};



/**
* update_errors_t
*/
class update_errors_t
{
};



/**
* update_errors_t
*/
class update_information
{
	var $description	= NULL;
	var $install		= NULL;
	var $instructions	= NULL;
	var $root			= '';
};


/**
* InstallFactory
*
* @author	Inetopia.
* @homepage	www.inetopia.de
* @email	support@inetopia.de
*/
class InstallFactory
{
	# -[ variables ]-
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================

	/**
	* constructor
	*
	*/
	function InstallFactory ()
	{
	}

	

	/**
	* 
	*
	*/
	function GetUpdates( $last_n=-1 )
	{
	}

	
	/**
	*  InstallFactory::GetLocalUpdates()
	*
	*/
	function GetLocalUpdates()
	{
		# define update root as single variable
		$UPDATE_ROOT = $this->GetUpdatesRoot();
		$aUpdates = array();
		

		$cUpdateRoot = new MyDirectory();	# define directory class/instance
		
		
		# try opening update root
		if( $cUpdateRoot->Open( $UPDATE_ROOT  ))
		{
			# read whole directory-list in update-root
			$aUpdatesRoots = $cUpdateRoot->GetDirs();

			# try to catch each update to local update-list, available
			for( $u=0; $u < sizeof($aUpdatesRoots); $u++ )
			{
				# declare important update files
				$sDescriptionFile	= $UPDATE_ROOT.$aUpdatesRoots[$u].EGL_DIRSEP.'description.xml';
				$sInstallFile		= $UPDATE_ROOT.$aUpdatesRoots[$u].EGL_DIRSEP.'install.xml';
				$sInstructionFile	= $UPDATE_ROOT.$aUpdatesRoots[$u].EGL_DIRSEP.'instructions.xml';
				
				
				# -------------------------------------------------------------
				# CHECK - Description/Install/Instruction files are available
				# -------------------------------------------------------------
				if( file_exists( $sDescriptionFile) &&
					file_exists( $sInstallFile) &&
					file_exists( $sInstructionFile) )
				{
					# setup basic information
					$pUpdate = & $aUpdates[sizeof($aUpdates)];
					$pUpdate = new update_information;
					$pUpdate->root = $UPDATE_ROOT.$aUpdatesRoots[$u].EGL_DIRSEP;
					
					# read buufer
					InstallFactory::XML_DescriptionFile_To_Object( $sDescriptionFile, $pUpdate->description );
					InstallFactory::XML_InstallFile_To_Object( $sDescriptionFile, $pUpdate->install);
					InstallFactory::XML_InstructionsFile_To_Object( $sDescriptionFile, $$pUpdate->instructions );
					
					// print "<textarea style='width:100%' rows='100'>".print_r($oRequiredUpdates, 1)."</textarea>";
					
				}//if
				else
				{
					
				}//else
				
				
			}//for
			
			return $aUpdates;
			
		}//if
		else
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, 'Couldn\'t open update-root `'. $UPDATE_ROOT.'` - process has been stopped' );
			return NULL;
		}//elseif
	}
	
	
	/**
	* try converting $xml_buffers to an description object class <update_description_t>
	* 
	* @param	array					XML-Buffer
	* @param	update_description_t	object
	* @return 	boolean					true/false
	*/
	function XML_DescriptionFile_To_Object( $xml_file, &$pDescription )
	{
		# classes & objects
		$cXMLReader = new XMLReader();	# xml object
		
		# parse description-file
		if( $cXMLReader->SetInputFile( $xml_file ) )
		{
			# try parsing input file
			$XML_DESCRIPTION = $cXMLReader->Parse();
	
			# reset resource
			$pDescription = new update_description_t();
	
			# get basse element <description>
			$oDesctription = $cXMLReader->GetElement( $XML_DESCRIPTION, 'DESCRIPTION' );
			$oHeader = $cXMLReader->GetElement( $oDesctription['child'], 'HEADER' );
			
			// Header available?
			if( $oHeader )
			{
				# attributes
				$pDescription->id			= $cXMLReader->GetElementContent( $oHeader['child'], 'ID' );
				$pDescription->version		= $cXMLReader->GetElementContent( $oHeader['child'], 'VERSION' );
				$pDescription->publisher	= $cXMLReader->GetElementContent( $oHeader['child'], 'PUBLISHER' );
				$pDescription->specification= $cXMLReader->GetElementContent( $oHeader['child'], 'SPECIFICATION' );
				$pDescription->details		= $cXMLReader->GetElementContent( $oHeader['child'], 'DETAILS' );
	
				# get size
				$oSize = $cXMLReader->getElement(  $oHeader['child'], 'SIZE' );
				$pDescription->size		= array( 'value' 	=> $oSize['content'],
												 'unit'		=> $oSize['attributes']['UNIT'] 
												);
														
				# required updates
				$oRequiredUpdates 	= $cXMLReader->GetElement(  $oDesctription['child'], 'REQUIRED_UPDATES' );
				for( $r=0; $r < sizeof($oRequiredUpdates['child']); $r++ )
					$pDescription->required_updates[sizeof($pDescription->required_updates)] = $oRequiredUpdates['child'][$r]['content'];
			}//if
		}//if
	}
	
	
	/**
	* try converting $xml_buffers to an install object class <update_install_t>
	* 
	* @param	array				XML-Buffer
	* @param	update_install_t	object
	* @return 	boolean				true/false
	*/	
	function XML_InstallFile_To_Object( $xml_file, &$pInstall )
	{
		# classes & objects
		$cXMLReader = new XMLReader();	# xml object
		
		# parse description-file
		if( $cXMLReader->SetInputFile( $xml_file ) )
		{
			# try parsing input file
			$XML_INSTALL = $cXMLReader->Parse();
	
			# reset resource
			$pInstall = new update_install_t();
	
			# get basse element <description>
			$oInstall = $cXMLReader->GetElement( $XML_INSTALL, 'INSTALL' );
			
			// Header available?
			if( $oInstall )
			{
				
				
				
				/*
				# attributes
				$pDescription->id			= $cXMLReader->GetElementContent( $oHeader['child'], 'ID' );
				$pDescription->version		= $cXMLReader->GetElementContent( $oHeader['child'], 'VERSION' );
				$pDescription->publisher	= $cXMLReader->GetElementContent( $oHeader['child'], 'PUBLISHER' );
				$pDescription->specification= $cXMLReader->GetElementContent( $oHeader['child'], 'SPECIFICATION' );
				$pDescription->details		= $cXMLReader->GetElementContent( $oHeader['child'], 'DETAILS' );
				
				*/
					
			}//if
		}//if
		
	}
	
	
	/**
	* try converting $xml_buffers to an instructions object class <update_instruction_t>
	* 
	* @param	array					XML-Buffer
	* @param	update_instruction_t	object
	* @return 	boolean					true/false
	*/	
	function XML_InstructionsFile_To_Object( $xml_file, &$pInstructions )
	{
	}
	
	
	
	
	/**
	*
	* @param 	integer		$update_id
	* @return 	
	*/
	function GetUpdateInformations( $update_id )
	{
		
	}

	
	/**
	* return current update root
	*
	*/
	function GetUpdatesRoot()
	{
		return EGL_SECURE.'updates'.EGL_DIRSEP;
	}

};

?>