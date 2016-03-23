<?php
# ================================ Copyright © 2005-2006 iNetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



DBTB::RegisterTB( 'MODULE', 'PREMIUM_CODES',		'egl_premium_codes' );
DBTB::RegisterTB( 'MODULE', 'PREMIUM_PACKAGES',		'egl_premium_packages' );



# -[ defines ]-

	
# -[ objectlist ] -


# -[ class ] -
class PremiumCore
{
	# -[ variables ]-
	var $pDBInterface	= null;

	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function PremiumCore ( &$db )
	{
		$this->pDBInterface = &$db;
	}
	
	
	/**
	 * getActivatedCodes
	 * 
	 * 
	 */

	function getActivatedCodeSummary( $parttype, $part_id )
	{
		$sql_query = " SELECT SUM(packages.life_time) as access_time, packages.id, packages.name, packages.enabled_image, packages.disabled_image, MIN(activation_time) as first_activation ".
					 " FROM `".DBTB::GetTB('MODULE','PREMIUM_PACKAGES')."` as packages ".
					 " LEFT JOIN `".DBTB::GetTB('MODULE','PREMIUM_CODES')."` as codes ".
					 " ON packages.id=codes.package_id ".
					 " WHERE codes.part_id=".$part_id." && codes.activated=1 && codes.expired=0 && packages.parttype=".(int)$parttype."".	// expired -> save parameter
					 " GROUP BY codes.package_id ";
		return $this->pDBInterface->FetchArrayObject( $this->pDBInterface->Query( $sql_query ) );
	}
	
	
	/**
	 * getActivatedCodes
	 * 
	 * 
	 */
	
	function getActivatedCodeSummaryByPackageId( $parttype, $part_id, $package_id )
	{
		$sql_query = " SELECT SUM(packages.life_time) as access_time, packages.id, packages.name, MIN(activation_time) as first_activation ".
					 " FROM `".DBTB::GetTB('MODULE','PREMIUM_PACKAGES')."` as packages ".
					 " LEFT JOIN `".DBTB::GetTB('MODULE','PREMIUM_CODES')."` as codes ".
					 " ON packages.id=codes.package_id ".
					 " WHERE codes.part_id=".$part_id." && codes.package_id=".(int)$package_id." && codes.activated=1 && codes.expired=0 && packages.parttype=".(int)$parttype."".	// expired -> save parameter
					 " GROUP BY codes.package_id ";
		return $this->pDBInterface->FetchArrayObject( $this->pDBInterface->Query( $sql_query ) );
	}
	
	
		
	
	/**
	 * getActivatedCodes
	 * 
	 */
	 
	function getActivatedCodes( $parttype, $part_id )
	{
		$sql_query = " SELECT * ".
					 " FROM `".DBTB::GetTB('MODULE','PREMIUM_PACKAGES')."` as packages ".
					 " LEFT JOIN `".DBTB::GetTB('MODULE','PREMIUM_CODES')."` as codes ".
					 " ON packages.id=codes.package_id ".
					 " WHERE codes.part_id=".$part_id." && codes.activated=1 && packages.parttype=".(int)$parttype."".
					 "";
		return $this->pDBInterface->FetchArrayObject( $this->pDBInterface->Query( $sql_query ) );
	}
	
	
	/**
	 * updateActivatedCodes
	 */
	function updateActivatedCodes()
	{
		// members
		// teams
	}

	
	/**
	 * PremiumAccessCheck
	 */
	function GetPremiumPackageAccess( $package_id, $parrtype, $part_id ){
			$sql_query = " SELECT packages.enabled_image, packages.disabled_image, SUM(packages.life_time) as access_time, packages.id, packages.name, MIN(activation_time) as first_activation ".
						 " FROM `".DBTB::GetTB('MODULE','PREMIUM_PACKAGES')."` as packages ".
						 " LEFT JOIN `".DBTB::GetTB('MODULE','PREMIUM_CODES')."` as codes ".
						 " ON packages.id=codes.package_id ".
						 " WHERE codes.part_id=".(int)$part_id." && packages.parttype=".(int)$parrtype." && packages.id=".(int)$package_id." && codes.activated=1 && codes.expired=0 ".	// expired -> save parameter
						 " GROUP BY codes.package_id ";
		return $this->pDBInterface->FetchObject( $this->pDBInterface->Query( $sql_query ) );
	}	
	
	/**
	 * PremiumAccessCheck
	 */
	function GetPremiumAccess( $parrtype, $part_id ){
			$sql_query = 	" SELECT packages.enabled_image, packages.disabled_image, SUM(packages.life_time) as access_time, packages.id, packages.name, MIN(activation_time) as first_activation ".
						 	" FROM `".DBTB::GetTB('MODULE','PREMIUM_PACKAGES')."` as packages ".
						 	" LEFT JOIN `".DBTB::GetTB('MODULE','PREMIUM_CODES')."` as codes ".
						 	" ON packages.id=codes.package_id ".
						 	" WHERE codes.part_id=".(int)$part_id." && packages.parttype=".(int)$parrtype." && codes.activated=1 && codes.expired=0 ".
						 	" GROUP BY codes.package_id ";
		return $this->pDBInterface->FetchArrayObject( $this->pDBInterface->Query( $sql_query ) );
	}	

	
		/**
	 * GetPremiumCode
	 */
	function GetPremiumCode( $code, $parttype ){
		$sql_query = 	" SELECT package.*,codes.* ".
						" FROM `".DBTB::GetTB('MODULE','PREMIUM_CODES')."` AS codes ".
						" LEFT JOIN `".DBTB::GetTB('MODULE','PREMIUM_PACKAGES')."` AS package ".
						" on package.id=codes.package_id ".
						" WHERE codes.code='".$code."' && parttype=".(int)$parttype; 
		return $this->pDBInterface->FetchObject( $this->pDBInterface->Query( $sql_query ) );
	}
	
	
	/**
	 * delete all prem-accounts, finished
	 * 
	 */
	function RefreshPremiumAccounts(){
			$sql_query = 	" SELECT codes.package_id, codes.part_id, SUM(packages.life_time) as access_time, packages.id, packages.name, MIN(activation_time) as first_activation ".
						 	" FROM `".DBTB::GetTB('MODULE','PREMIUM_PACKAGES')."` as packages ".
						 	" LEFT JOIN `".DBTB::GetTB('MODULE','PREMIUM_CODES')."` as codes ".
						 	" ON packages.id=codes.package_id ".
						 	" WHERE codes.activated=1 && codes.expired=0 ". // codes.part_id=".(int)$part_id." && packages.parttype=".(int)$parrtype." && 
						 	" GROUP BY codes.package_id, codes.part_id ";
							
			// setze alle codes für ein paket von einem mitglied auf expired!!
			$sql3_query	= 	" UPDATE `".DBTB::GetTB('MODULE','PREMIUM_CODES')."` AS codes, ".
							" (".$sql_query.") AS p_summary ".
							" SET codes.expired=1 ".
							" WHERE (p_summary.first_activation+p_summary.access_time*60) < ".EGL_TIME." && codes.package_id=p_summary.package_id && codes.part_id=p_summary.part_id";
			
		return $this->pDBInterface->FetchArrayObject( $this->pDBInterface->Query( $sql3_query ) );
		
	}

	/**
	 * GetPremiumCodeById
	 */
	function GetPremiumCodeById( $code_id ){
		$sql_query = 	" SELECT * ".
						" FROM `".DBTB::GetTB('MODULE','PREMIUM_CODES')."` AS codes ".
						" WHERE id=".(int)$code_id; 
		return $this->pDBInterface->FetchObject( $this->pDBInterface->Query( $sql_query ) );
	}	
	
	/**
	 * PremiumAccessCheck
	 */
	function UpdateCode( $code_id, $object )
	{
		return $this->pDBInterface->Query( $this->pDBInterface->CreateUpdateQuery( DBTB::GetTB('MODULE','PREMIUM_CODES'), $object ) . " WHERE id=".(int)$code_id  );
	}

};

?>