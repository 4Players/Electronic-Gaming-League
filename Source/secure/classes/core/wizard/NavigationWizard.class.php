<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -



# -[ class ] -
class NavigationWizard
{
	# -[ variables ]-
	var $aWizardSheets				= array();
	var $bAllowedSyncSheetNames		= false;
	
	
	
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function NavigationWizard ()
	{
	}//
	
	/**
	* add new wizard-sheet to list
	*
	* $name	<integer> name of current sheet
	* $params <array> list of params, to current sheet
	* 
	* @return true
	*/
	function NewWizardSheet( $name, $params=array() ){
		$id = sizeof($this->aWizardSheets);
		$this->aWizardSheets[sizeof($this->aWizardSheets)] = array( 'name'		=> $name,
																	'id'		=> $id,
																	'params' 	=> $params );
		return true;
	}
	
	
	/**
	* AddParamsToWizardSheet()
	*
	*/
	function AddParamsToWizardSheet( $id ){
	}
	
	
	/**
	* FirstSheet()
	*
	*/	
	function FirstSheet(){
		if( sizeof($this->aWizardSheets) > 0 ) return $this->aWizardSheets[0];
	}
	
	
	/**
	* PrevSheetById()
	*
	*/
	function PrevSheetById( $id ){
		$sheet = $this->GetWizardSheetById( $id );
		if( $sheet ){
			if( $sheet['id'] > 0 ){
				return $this->GetWizardSheetById( $id-1 );
			}
		}
		return NULL;	
	}
	
	/**
	* PrevSheetByName()
	*
	*/
	function PrevSheetByName( $name ){
		$sheet = $this->GetWizardSheetByName( $name );
		if( $sheet ) return $this->PrevSheetById( $sheet['id'] );
		return NULL;
	}

	
	
	/**
	* NextSheetById()
	*
	*/
	function NextSheetById( $id ){
		$sheet = $this->GetWizardSheetById( $id );
		if( $sheet ){
			if( sizeof($this->aWizardSheets) > $sheet['id'] ){
				return $this->GetWizardSheetById( $id+1 );
			}
		}
		return NULL;	
	}
	
	/**
	* NextSheetByName()
	*
	*/
	function NextSheetByName( $name ){
		$sheet = $this->GetWizardSheetByName( $name );
		if( $sheet ) return $this->NextSheetById( $sheet['id'] );
		return NULL;
	}
	
	/**
	* GetWizardSheetByName()
	*
	*/
	function GetWizardSheetByName( $name ){
		for( $i=0; $i < sizeof($this->aWizardSheets); $i++ ){
			if( $this->aWizardSheets[$i]['name'] == $name )
				return $this->aWizardSheets[$i];
		}
		return NULL;
	}
	
	/**
	* GetWizardSheetById()
	*
	*/
	function GetWizardSheetById( $id ){
		for( $i=0; $i < sizeof($this->aWizardSheets); $i++ ){
			if( $this->aWizardSheets[$i]['id'] == $id )
				return $this->aWizardSheets[$i];
		}
		return NULL;
	}
};

?>