<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -




# -[ class ] -
class DBConfigs
{
	# -[ variables ]-
	var $pDBInterfaceCon	= NULL;

	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function DBConfigs ( &$pDBCOn )
	{
		return $this->pDBInterfaceCon = &$pDBCOn;
	}

	
	/**
	* fetch list of all configs, saved
	*
	* @return <array>  ArrayList['key'] 
	**/
	function FetchConfigArray()
	{
		$sql_query	= 	" SELECT * ".
						" FROM `".DBTB::GetTB( 'GLOBAL', 'EGL_CONFIGS' )."` AS egl_configs ".
						"";
		$aDBConfigList = $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );

		# save to local list
		$aConfigs = array();
		for( $i=0; $i < sizeof($aDBConfigList); $i++ ){
			$aConfigs[$aDBConfigList[$i]->key] = $aDBConfigList[$i]->value;
		}//for
		return $aConfigs;
	}
	
	
	/**
	* fetch list of all configs, saved
	*
	* @return string  'key'->value
	**/
	function GetConfig( $key )
	{
		$sql_query	= 	" SELECT * ".
						" FROM `".DBTB::GetTB( 'GLOBAL', 'EGL_CONFIGS' )."` AS egl_configs ".
						" WHERE `key`=\"".$this->pDBInterfaceCon->EscapeString($key)."\" ".
						" LIMIT 0,1";
		$oConfig = $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
		if( !$oConfig ) return '';
		return $oConfig->value;
	}
	
	
	/**
	* check, key exists?
	*
	* @return anz. exists items
	**/
	function KeyExists( $key ){
		$sql_query	= 	" SELECT COUNT(*) AS num_items ".
						" FROM `".DBTB::GetTB( 'GLOBAL', 'EGL_CONFIGS' )."` AS egl_configs ".
						" WHERE `key`=\"".$this->pDBInterfaceCon->EscapeString($key)."\" ";
		$oConfig = $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
		return (int)$oConfig->num_items;
	}
		
	
	/**
	 * SetConfig
	 * 
	 * 
	 */
	function SetConfig( $key, $value ){
		$sql_query  = 	" UPDATE `".DBTB::GetTB( 'GLOBAL', 'EGL_CONFIGS' )."` AS egl_configs ".
						" SET `value`=\"".$this->pDBInterfaceCon->EscapeString( $value )."\" ".
						" WHERE `key`=\"".$this->pDBInterfaceCon->EscapeString( $key )."\"" ;
		$this->pDBInterfaceCon->Query( $sql_query );
		if( $this->pDBInterfaceCon->AffectedRowCount() > 0 ){
			return 1;
		}else{
			// key noch nicht vorhanden?
			// muss da sein: problem: wenn der key vorhanden ist und $value = old-value => kein update -> affected_rows=0
			if( !$this->KeyExists( $key )) {
				$obj = array( 	'key' 		=> $key,
								'value' 	=> $value,
							);
				return $this->pDBInterfaceCon->Query( $this->pDBInterfaceCon->CreateInsertQuery( DBTB::GetTB( 'GLOBAL', 'EGL_CONFIGS' ), $obj ));
			}//if
			
		}//if
	}//if
		
};

?>