<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-




# -[ class ] -
class MapCollections
{
	# -[ variables ]-
	var $pDBInterface	= NULL;

	
	/**
	 * MapCollections
	 * 
	 */
	function MapCollections( &$pDBCon )
	{
		$this->pDBInterface = &$pDBCon;
	}

	
	/**
	 * GetCollections()
	 * 
	 */
	function GetCollections(){
		$sql_query = " SELECT COUNT(maps.collection_id) AS num_maps, collections.*,   ".
					 " games.name AS game_name, games.id AS game_id, games.logo_small_file AS game_logo ".
					 " FROM `".DBTB::GetTB('GLOBAL','EGL_MAPCOLLECTIONS')."` AS collections ".
					 " LEFT JOIN `".DBTB::GetTB('GLOBAL','EGL_GAMES')."` AS games ".
					 " ON games.id=collections.game_id ".
					 " LEFT JOIN `".DBTB::GetTB('GLOBAL','EGL_MAPS')."` AS maps ".
					 " ON maps.collection_id=collections.id ".
					 " GROUP BY collections.id ".
					 " ORDER BY collections.game_id ";
		return $this->pDBInterface->FetchArrayObject( $this->pDBInterface->Query( $sql_query ) );
	}
	
	
	
	/**
	 * GetCollectionMaps
	 */
	function GetCollectionMaps( $collection_id ){
		$sql_query = " SELECT * ".
					 " FROM `".DBTB::GetTB('GLOBAL','EGL_MAPS')."` AS maps  ".
					 " WHERE maps.collection_id=".(int)$collection_id." ".
					 " ORDER BY maps.map_name ";
		return $this->pDBInterface->FetchArrayObject( $this->pDBInterface->Query( $sql_query ) );	
	}
	
	
	
	/**
	 * GetCollectionById
	 */
	function GetCollectionById( $collection_id ){
		$sql_query = " SELECT * ".
					 " FROM `".DBTB::GetTB('GLOBAL','EGL_MAPCOLLECTIONS')."` AS collections  ".
					 " WHERE collections.id=".(int)$collection_id." ";
		return $this->pDBInterface->FetchObject( $this->pDBInterface->Query( $sql_query ) );	
	}
	
	/**
	 * SetCollectionData
	 */
	function SetCollectionData( $obj, $id )
	{
		# execute query
		return $this->pDBInterface->Query( $this->pDBInterface->CreateUpdateQuery(  DBTB::GetTB('GLOBAL','EGL_MAPCOLLECTIONS'), $obj ) . " WHERE id=".$id );
	}

	/**
	 * SetMapData
	 */
	function SetMapData( $obj, $id )
	{
		# execute query
		return $this->pDBInterface->Query( $this->pDBInterface->CreateUpdateQuery(  DBTB::GetTB('GLOBAL','EGL_MAPS'), $obj ) . " WHERE id=".$id );
	}
	
	/**
	 * NewMap
	 */
	function NewMap( $object )
	{
		$sql_query = $this->pDBInterface->CreateInsertQuery( DBTB::GetTB('GLOBAL','EGL_MAPS'), $object );
		return $this->pDBInterface->Query( $sql_query );
	}

	/**
	 * NewCollection
	 */
	function NewCollection( $object )
	{
		$sql_query = $this->pDBInterface->CreateInsertQuery( DBTB::GetTB('GLOBAL','EGL_MAPCOLLECTIONS'), $object );
		return $this->pDBInterface->Query( $sql_query );
	}	
	
	/**
	 * DeleteMap
	 */
	function DeleteMap( $id )
	{
		return $this->pDBInterface->Query( "DELETE FROM `". DBTB::GetTB('GLOBAL','EGL_MAPS')."` WHERE id=".(int)$id );
	}

	
	/**
	 * DeleteGameById
	 *
	 * @param unknown_type $game_id
	 * @return unknown
	 */
	function DeleteCollection( $collection_id )
	{
		$sql_query = "DELETE FROM `".DBTB::GetTB('GLOBAL','EGL_MAPCOLLECTIONS')."` WHERE id=".(int)$collection_id;
		return $this->pDBInterface->Query( $sql_query );
	}
	
	/**
	 * DeleteGameById
	 *
	 * @param unknown_type $game_id
	 * @return unknown
	 */
	function DeleteCollectionMaps( $collection_id )
	{
		$sql_query = "DELETE FROM `".DBTB::GetTB('GLOBAL','EGL_MAPS')."` WHERE collection_id=".(int)$collection_id;
		return $this->pDBInterface->Query( $sql_query );
	}	
			
};

?>