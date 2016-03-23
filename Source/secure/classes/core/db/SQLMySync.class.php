<?php
# ================================ Copyright © 2004-2007 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


# -[ defines ]-


# -[ class ] -
class SQLMySync
{
	var $pDBInterface = NULL;
	# -[ variables ]-
	
	# -[ functions ]-

	/**
	* Concstructor
	*
	**/
	function SQLMySync ( $pDBCon )
	{
		$this->pDBInterface = &$pDBCon;
	}


	/**
	* Dump single DB table
	* 
	* @param 	string	output-file
	* @return	bool	true/false 
	**/
	function CreateXMLOutputFile(  $output, $export_rows=false )
	{
		$aTableSync = array();
		
		$cFile = new File();
		$cFile->Open( $output, 'w' );
		
		$cFile->Write( "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>" );
		$cFile->Write( "\n<sql_sync_mask>" );
	
		$aTables = $this->pDBInterface->GetTableList();
		for( $i=0; $i < sizeof($aTables); $i++ ){
			
			$aTableSync[$i] = array();
			$aTableSync[$i]['name']		= $aTables[$i];
			$aTableSync[$i]['fields']	= array();;
			
			
			$cFile->Write( "\n	<table>" );
			$cFile->Write( "\n		<name>".$aTables[$i]."</name>" );
			$cFile->Write( "\n		<fields>" );
			
			$sql_query = 'SHOW INDEX FROM `'.$aTables[$i].'` ';
			$result = $this->pDBInterface->Query( $sql_query );
			$aFieldKeys = $this->pDBInterface->FetchArrayObject( $result );			
			
			$sql_query = " SHOW COLUMNS FROM `".$aTables[$i]."`";
			$aFields = $this->pDBInterface->FetchArrayObject( $this->pDBInterface->Query( $sql_query ) );
			for( $f=0; $f < sizeof($aFields); $f++ )
			{
				$aTableSync[$i]['fields'][$f]['name']		= $aFields[$f]->Field;
				$aTableSync[$i]['fields'][$f]['type']		= $aFields[$f]->Type;
				$aTableSync[$i]['fields'][$f]['null']		= $aFields[$f]->Null;
				$aTableSync[$i]['fields'][$f]['key']		= $aFields[$f]->Key;
				$aTableSync[$i]['fields'][$f]['default']	= $aFields[$f]->Default;
				$aTableSync[$i]['fields'][$f]['extra']		= $aFields[$f]->Extra;
				
				$cFile->Write( "\n			<field>" );
				$cFile->Write( "\n				<name>".$aFields[$f]->Field."</name>" );
				$cFile->Write( "\n				<type>".$aFields[$f]->Type."</type>" );
				$cFile->Write( "\n				<null>".$aFields[$f]->Null."</null>" );
				$cFile->Write( "\n				<key>".$aFields[$f]->Key."</key>" );
				$cFile->Write( "\n				<default>".$aFields[$f]->Default."</default>" );
				$cFile->Write( "\n				<extra>".$aFields[$f]->Extra."</extra>" );
				
				
				$cFile->Write( "\n				<keys>" );
				// list keys
				//-------------------------
				for( $key=0; $key < sizeof($aFieldKeys); $key++ )
				{
					if( $aFieldKeys[$key]->Column_name == $aFields[$f]->Field )
					{
						$num_keys = sizeof($aTableSync[$i]['fields'][$f]['keys']);

						$type = 'unknown';
						if( strtoupper($aFieldKeys[$key]->Key_name) == 'PRIMARY' ) $type = 'primary';
						else if( (int)$aFieldKeys[$key]->Non_unique == 0 ) $type = 'unique';
						else if( (int)$aFieldKeys[$key]->Non_unique == 1 ) $type = 'index';
							
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['field_name']	= $aFieldKeys[$key]->Column_name;
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['type'] 		= $type; // index,primary,unique
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['index_type'] 	= $aFieldKeys[$key]->Index_type;
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['key_name'] 	= $aFieldKeys[$key]->Key_name;
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['collation'] 	= $aFieldKeys[$key]->Collation;
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['cardinality'] = $aFieldKeys[$key]->Cardinality;
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['sub_part'] 	= $aFieldKeys[$key]->Sub_part;
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['packaged'] 	= $aFieldKeys[$key]->Packed;
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['null'] 		= $aFieldKeys[$key]->Null;

						$cFile->Write( "\n					<key>" );
						
						$cFile->Write( "\n						<field_name>".	$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['field_name']."</field_name>" );
						$cFile->Write( "\n						<type>".		$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['type']."</type>" );
						$cFile->Write( "\n						<index_type>".	$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['index_type']."</index_type>" );
						$cFile->Write( "\n						<key_name>".	$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['key_name']."</key_name>" );
						$cFile->Write( "\n						<collation>".	$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['collation']."</collation>" );
						$cFile->Write( "\n						<cardinality>".	$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['cardinality']."</cardinality>" );
						$cFile->Write( "\n						<sub_part>".	$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['sub_part']."</sub_part>" );
						$cFile->Write( "\n						<packaged>".	$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['packaged']."</packaged>" );
						$cFile->Write( "\n						<null>".		$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['null']."</null>" );
						
						$cFile->Write( "\n					</key>" );
					}//if
				}//for
				$cFile->Write( "\n				</keys>" );
				$cFile->Write( "\n			</field>" );
			}//for
			$cFile->Write( "\n		</fields>" );

			
			// ------------------------------------------------------------			
			// SAVE ROWS
			// ------------------------------------------------------------			
			if( $export_rows ){
				$cFile->Write( "\n		<rows>" );
					$sql_query = 'SELECT * FROM `'.$aTableSync[$i]['name'].'` ';
					$qre = $this->pDBInterface->Query( $sql_query );
					while( $row = $this->pDBInterface->FetchArray( $qre ) ){
					$cFile->Write( "\n			<row>" );
						for( $iF=0; $iF < sizeof($aTableSync[$i]['fields']); $iF++ ){
							$field_name = $aTableSync[$i]['fields'][$iF]['name'];
					$cFile->Write( "\n				<".$field_name.">".$row[$field_name]."</".$field_name.">" );
						}//for
					$cFile->Write( "\n			</row>" );
					}//while
				$cFile->Write( "\n		</rows>" );
			} 
			else{
				$cFile->Write( "\n		<rows></rows>" );
			}
			
			$cFile->Write( "\n	</table>" );
		}//for
		$cFile->Write( "\n</sql_sync_mask>" );
		$cFile->Close();
		
		return true;
	}
	
	
	

	/**
	* Dump single DB table
	* 
	* @param 	string	output-file
	* @return	bool	true/false 
	**/
	function ExportMask( $aTableSync, $export_rows=false, $params = array() )
	{
		$export = '';
		$export .= "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>" ;
		$export .= "\n<sql_sync_mask>" ;
	
		for( $i=0; $i < sizeof($aTableSync); $i++ ){
			
			//$aTableSync[$i] = array();
			//$aTableSync[$i]['name']		= $aTables[$i];
			//$aTableSync[$i]['fields']	= array();;
			
			
			$export .= "\n	<table>" ;
			$export .= "\n		<name>".$aTableSync[$i]['name']."</name>" ;
			$export .= "\n		<fields>" ;
			
			for( $f=0; $f < sizeof($aTableSync[$i]['fields']); $f++ )
			{
				//$aTableSync[$i]['fields'][$f]['name']		= $aFields[$f]->Field;
				//$aTableSync[$i]['fields'][$f]['type']		= $aFields[$f]->Type;
				//$aTableSync[$i]['fields'][$f]['null']		= $aFields[$f]->Null;
				//$aTableSync[$i]['fields'][$f]['key']		= $aFields[$f]->Key;
				//$aTableSync[$i]['fields'][$f]['default']	= $aFields[$f]->Default;
				//$aTableSync[$i]['fields'][$f]['extra']		= $aFields[$f]->Extra;
				
				$export .= "\n			<field>" ;
				$export .= "\n				<name>".$aTableSync[$i]['fields'][$f]['name']."</name>" ;
				$export .= "\n				<type>".$aTableSync[$i]['fields'][$f]['type']."</type>" ;
				$export .= "\n				<null>".$aTableSync[$i]['fields'][$f]['null']."</null>" ;
				$export .= "\n				<key>".$aTableSync[$i]['fields'][$f]['key']."</key>" ;
				$export .= "\n				<default>".$aTableSync[$i]['fields'][$f]['default']."</default>";
				$export .= "\n				<extra>".$aTableSync[$i]['fields'][$f]['extra']."</extra>" ;
				
				$export .= "\n				<keys>" ;
				// list keys
				//-------------------------
				for( $key=0; $key < sizeof($aTableSync[$i]['fields'][$f]['keys']); $key++ )
				{

						/*
						$type = 'unknown';
						if( strtoupper($aFieldKeys[$key]->Key_name) == 'PRIMARY' ) $type = 'primary';
						else if( (int)$aFieldKeys[$key]->Non_unique == 0 ) $type = 'unique';
						else if( (int)$aFieldKeys[$key]->Non_unique == 1 ) $type = 'index';
							
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['field_name']	= $aFieldKeys[$key]->Column_name;
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['type'] 		= $type; // index,primary,unique
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['index_type'] 	= $aFieldKeys[$key]->Index_type;
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['key_name'] 	= $aFieldKeys[$key]->Key_name;
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['collation'] 	= $aFieldKeys[$key]->Collation;
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['cardinality'] = $aFieldKeys[$key]->Cardinality;
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['sub_part'] 	= $aFieldKeys[$key]->Sub_part;
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['packaged'] 	= $aFieldKeys[$key]->Packed;
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['null'] 		= $aFieldKeys[$key]->Null;
						*/
						$export .= "\n					<key>" ;
						
						$export .= "\n						<field_name>".	$aTableSync[$i]['fields'][$f]['keys'][$key]['field_name']."</field_name>" ;
						$export .= "\n						<type>".		$aTableSync[$i]['fields'][$f]['keys'][$key]['type']."</type>" ;
						$export .= "\n						<index_type>".	$aTableSync[$i]['fields'][$f]['keys'][$key]['index_type']."</index_type>" ;
						$export .= "\n						<key_name>".	$aTableSync[$i]['fields'][$f]['keys'][$key]['key_name']."</key_name>" ;
						$export .= "\n						<collation>".	$aTableSync[$i]['fields'][$f]['keys'][$key]['collation']."</collation>" ;
						$export .= "\n						<cardinality>".	$aTableSync[$i]['fields'][$f]['keys'][$key]['cardinality']."</cardinality>" ;
						$export .= "\n						<sub_part>".	$aTableSync[$i]['fields'][$f]['keys'][$key]['sub_part']."</sub_part>" ;
						$export .= "\n						<packaged>".	$aTableSync[$i]['fields'][$f]['keys'][$key]['packaged']."</packaged>" ;
						$export .= "\n						<null>".		$aTableSync[$i]['fields'][$f]['keys'][$key]['null']."</null>" ;
						
						$export .= "\n					</key>" ;
						
				}//for
				
				$export .= "\n				</keys>" ;
				$export .= "\n			</field>" ;
				
			}//for
			$export .= "\n		</fields>" ;

			
			// ------------------------------------------------------------			
			// SAVE ROWS
			// ------------------------------------------------------------			
			if( $export_rows ){
				$export .= "\n		<rows>" ;
					$sql_query = 'SELECT * FROM `'.$aTableSync[$i]['name'].'` ';
					$qre = $this->pDBInterface->Query( $sql_query );
					while( $row = $this->pDBInterface->FetchArray( $qre ) ){
					$export .= "\n			<row>" ;
						for( $iF=0; $iF < sizeof($aTableSync[$i]['fields']); $iF++ ){
							$field_name = $aTableSync[$i]['fields'][$iF]['name'];
							if( strtoupper($aTableSync[$i]['fields'][$iF]['extra']) == 'AUTO_INCREMENT' && !$params['auto_increment']){
								//$export .= "\n				<".$field_name.">".$row[$field_name]."</".$field_name.">";
							}
							else{
								$export .= "\n				<".$field_name.">".htmlspecialchars( $row[$field_name] )."</".$field_name.">";
							}
						}//for
					$export .= "\n			</row>" ;
					}//while
				$export .= "\n		</rows>" ;
			} 
			else{
				$export .= "\n		<rows></rows>" ;
			}
									
			
			$export .= "\n	</table>" ;
			
		}//for
		$export .= "\n</sql_sync_mask>" ;
		
		return $export;
	}
	
	
	
	/**
	* CreateSyncMaskTree
	* 
	* @return	array	sync-mask
	**/
	function CreateLocalSyncMask(){
		$aTableSync = array();
		
		$aTables = $this->pDBInterface->GetTableList();
		for( $i=0; $i < sizeof($aTables); $i++ ){
			
			$aTableSync[$i] = array();
			$aTableSync[$i]['name']		= $aTables[$i];
			$aTableSync[$i]['fields']	= array();;

			$sql_query = 'SHOW INDEX FROM `'.$aTables[$i].'`';
			$result = $this->pDBInterface->Query( $sql_query );
			$aFieldKeys = $this->pDBInterface->FetchArrayObject( $result );

			
			$sql_query = " SHOW COLUMNS FROM`".$aTables[$i]."`";
			$result = $this->pDBInterface->Query( $sql_query );
			$aFields = $this->pDBInterface->FetchArrayObject( $result );
			for( $f=0; $f < sizeof($aFields); $f++ )
			{
				$aTableSync[$i]['fields'][$f]['name']		= $aFields[$f]->Field;
				$aTableSync[$i]['fields'][$f]['type']		= $aFields[$f]->Type;
				$aTableSync[$i]['fields'][$f]['null']		= $aFields[$f]->Null;
				$aTableSync[$i]['fields'][$f]['key']		= $aFields[$f]->Key;
				$aTableSync[$i]['fields'][$f]['default']	= $aFields[$f]->Default;
				$aTableSync[$i]['fields'][$f]['extra']		= $aFields[$f]->Extra;
				$aTableSync[$i]['fields'][$f]['keys']		= array();

				// mysql 5.0 assignement
				if( $aTableSync[$i]['fields'][$f]['null'] == '' )
					$aTableSync[$i]['fields'][$f]['null'] = 'NO';
				
				// fetch index
				for( $key=0; $key < sizeof($aFieldKeys); $key++ )
				{
					if( $aFieldKeys[$key]->Column_name == $aFields[$f]->Field )
					{
						$num_keys = sizeof($aTableSync[$i]['fields'][$f]['keys']);

						$type = 'unknown';
						if( strtoupper($aFieldKeys[$key]->Key_name) == 'PRIMARY' ) $type = 'primary';
						else if( (int)$aFieldKeys[$key]->Non_unique == 0 ) $type = 'unique';
						else if( (int)$aFieldKeys[$key]->Non_unique == 1 ) $type = 'index';
							
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['field_name']	= $aFieldKeys[$key]->Column_name;
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['type'] 		= $type; // index,primary,unique
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['index_type'] 	= $aFieldKeys[$key]->Index_type;
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['key_name'] 	= $aFieldKeys[$key]->Key_name;
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['collation'] 	= $aFieldKeys[$key]->Collation;
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['cardinality'] = $aFieldKeys[$key]->Cardinality;
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['sub_part'] 	= $aFieldKeys[$key]->Sub_part;
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['packaged'] 	= $aFieldKeys[$key]->Packed;
						$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['null'] 		= $aFieldKeys[$key]->Null;
						
						/*if( $aTableSync[$i]['fields'][$f]['keys'][$num_keys]['null'] =='' )
							$aTableSync[$i]['fields'][$f]['keys'][$num_keys]['null'] = 'NO';*/
						
					}//if
				}//for
				
				
			}//for
		}//for
		return $aTableSync;
	}
	
	/**
	 * CreateSyncMaskFromFile
	 * 
	 */
	function CreateSyncMaskFromFile( $file ){
		$aTableSync = array();
		if( !egl_url_exists($file)) return 'unknown file';
				
		$reader = new XMLReaderFactory();
		$reader->SetInputFile( $file );
		
		$tree = $reader->Parse(); // parse
		
		if( sizeof($tree) == 0 ) return 'no results';
		
		// for each table
		$tables = $tree[0]['child'];
		for( $t=0; $t < sizeof($tables); $t++ )
		{
			
			//echo "<br/>".$tree[0]['child'][0];
			//echo nl2br( print_r( $tables[$t], 1));
			
			$tb_name 	= $reader->GetElementContent( $tables[$t]['child'], "NAME" );
			$tb_child 	= $reader->GetElement( $tables[$t]['child'], "FIELDS" );
			$tb_fields 	= $tb_child['child'];
			
			// fill mask
			$aTableSync[$t] = array( 	'name'		=> $tb_name,
										'fields'	=> array(),
									);
			
			for( $f=0; $f < sizeof($tb_fields); $f++ )
			{
				$field_name 	= $reader->GetElementContent( $tb_fields[$f]['child'], "NAME" );
				$field_type 	= $reader->GetElementContent( $tb_fields[$f]['child'], "TYPE" );
				$field_null 	= $reader->GetElementContent( $tb_fields[$f]['child'], "NULL" );
				$field_key 		= $reader->GetElementContent( $tb_fields[$f]['child'], "KEY" );
				$field_default 	= $reader->GetElementContent( $tb_fields[$f]['child'], "DEFAULT" );
				$field_extra 	= $reader->GetElementContent( $tb_fields[$f]['child'], "EXTRA" );
				$field_keys 	= $reader->GetElement( $tb_fields[$f]['child'], "KEYS" );
				$field_keys		= $field_keys['child'];

				$key_description = array();
				for( $key=0; $key < sizeof($field_keys); $key++ )
				{
					$key_description[sizeof($key_description)] = array(
												'field_name' 	=> $reader->GetElementContent( $field_keys[$key]['child'], "FIELD_NAME" ),
												'type' 			=> $reader->GetElementContent( $field_keys[$key]['child'], "TYPE" ),
												'index_type' 	=> $reader->GetElementContent( $field_keys[$key]['child'], "INDEX_TYPE" ),
												'key_name' 		=> $reader->GetElementContent( $field_keys[$key]['child'], "KEY_NAME" ),
												'collation' 	=> $reader->GetElementContent( $field_keys[$key]['child'], "COLLATION" ),
												'cardinality' 	=> $reader->GetElementContent( $field_keys[$key]['child'], "CARDINALITY" ),
												'sub_part' 		=> $reader->GetElementContent( $field_keys[$key]['child'], "SUB_PART" ),
												'packaged' 		=> $reader->GetElementContent( $field_keys[$key]['child'], "PACKAGED" ),
												'null' 			=> $reader->GetElementContent( $field_keys[$key]['child'], "NULL" ),
											);
				}		
				//echo nl2br( print_r( $key_description, 1));
				//exit;
			
				$aTableSync[$t]['fields'][$f] = array(	'name'		=> $field_name,
														'type'		=> $field_type,
														'null'		=> $field_null,
														'key'		=> $field_key,
														'default'	=> $field_default,
														'extra'		=> $field_extra,
														'keys'		=> $key_description,
													);
				// mysql 5.0 assignement
				if( $aTableSync[$t]['fields'][$f]['null'] == '' ) $aTableSync[$t]['fields'][$f]['null'] = 'NO';
			}
		}//for

		return $aTableSync;
	}//function
	
	
	/**
	 * CompareSyncMask
	 */
	function CompareSyncMask( $local, $current ){
	}
	
	/**
	 * CompareSyncMask
	 */
	function UpdateDB( $local, $current ){
		$aSQLBuffer = array();
		
		if( !is_array($local) || !is_array($current) ) return false;
		
		for( $t=0; $t < sizeof($current); $t++ )
		{
			// search table in $local
			$loc_table = NULL;
			for( $_t2=0; $_t2 < sizeof($local); $_t2++ )
				if( $local[$_t2]['name'] == $current[$t]['name'] )
					$loc_table = $local[$_t2];
			
			if( isset($loc_table) )
			{
				// check table
				for( $f=0; $f < sizeof($current[$t]['fields']); $f++ )
				{
					// field exists / search field
					$loc_field = NULL;
					for( $_f2=0; $_f2 < sizeof($loc_table['fields']); $_f2++ ){
						if( $loc_table['fields'][$_f2]['name'] == $current[$t]['fields'][$f]['name'] ){
							$loc_field = $loc_table['fields'][$_f2];
							break;
						}//if
					}//for
					
					/*
					if( !isset($loc_field) )
					{
						echo nl2br( print_r( $loc_table['fields'], 1));
						exit;
					}*/
					
					
					
					if( isset($loc_field))
					{
						// check field
						$currfield 		= $current[$t]['fields'][$f];
						
						//echo nl2br( print_r( $loc_field, 1));
						//echo nl2br( print_r( $currfield, 1));
						
						// -----------------------------------------------
						// modified?
						// -----------------------------------------------
						if( $currfield['type'] 		!= $loc_field['type'] ||
							$currfield['null'] 		!= $loc_field['null'] ||
							$currfield['default'] 	!= $loc_field['default'] ||
							$currfield['extra'] 	!= $loc_field['extra'] ||
							!$this->__CompateFieldKeys( $currfield['keys'], $loc_field['keys'] )
							)
						{

							$NULL_SETTING = " ";
							$DEFAULT_SETTING = " DEFAULT '".$currfield['default']."'";

							if( strtoupper($currfield['null']) == 'YES' ) $NULL_SETTING = " NULL ";
							else $NULL_SETTING = " NOT NULL ";
								
								
							// -----------------------------------------------
							// TYPE
							// -----------------------------------------------
							if( strtoupper($currfield['type']) != strtoupper($loc_field['type']) )
							{
								$sql_changefield = 	" ALTER TABLE `".$current[$t]['name']."` CHANGE `".$currfield['name']."` `".
													$currfield['name']."` ".
													$currfield['type']." ".
													$NULL_SETTING.
													$DEFAULT_SETTING.
													" ; ";
								
													
								$aSQLBuffer[sizeof($aSQLBuffer)] = array( 	'query' 		=>  $sql_changefield,
																			'description'	=> 'Change field-type `'.$current[$t]['name'].':'.$currfield['name'].'` '.$loc_field['type'].' to '.$currfield['type'],
																		);
								//echo "<br/>".$sql_changefield;																		
							}//if
								
							
							// -----------------------------------------------
							// NOT NULL
							// -----------------------------------------------
							if( strtoupper($currfield['null']) != strtoupper($loc_field['null'])  )
							{
								$sql_changefield = 	" ALTER TABLE `".$current[$t]['name']."` CHANGE `".$currfield['name']."` `".
													$currfield['name']."` ".
													$currfield['type'].
													$NULL_SETTING.
													$DEFAULT_SETTING.
													" ; ";
								$aSQLBuffer[sizeof($aSQLBuffer)] = array( 	'query' 		=>  $sql_changefield,
																			'description'	=> 'Change NULL PARAM `'.$current[$t]['name'].':'.$currfield['name'].'` to `'.$to.'`',
																		);
																		
								//echo "<br/>".$sql_changefield;
							}
							// -----------------------------------------------
							// SET DEFAULT
							// -----------------------------------------------
							if( $currfield['default'] != $loc_field['default'] )
							{
								$sql_changefield = 	" ALTER TABLE `".$current[$t]['name']."` CHANGE `".$currfield['name']."` `".
													$currfield['name']."` ".
													$currfield['type'].
													$NULL_SETTING.
													$DEFAULT_SETTING.
													" ;";
								//echo "<br/>".$sql_changefield;
								
								$aSQLBuffer[sizeof($aSQLBuffer)] = array( 	'query' 		=>  $sql_changefield,
																			'description'	=> 'Change default-value `'.$current[$t]['name'].':'.$currfield['name'].'` '.$loc_field['default'].' to '.$currfield['default'],
																		);
								
							}//if
							

							
							// -----------------------------------------------
							// KEY
							// -----------------------------------------------
							if( !$this->__CompateFieldKeys( $currfield['keys'], $loc_field['keys']) )
							{
								//echo "<br/>".$current[$t]['name']."::".$currfield['name']." -> keys changed";
								
								
								// 2. Schritt: neue keys hinzufügen
								for( $key=0; $key < sizeof($currfield['keys']); $key++ )
								{
									// key found
									$bKeyAvailable = false;
									for( $_key=0; $_key < sizeof($loc_field['keys']); $_key++ )
										if( $currfield['keys'][$key]['type'] == $loc_field['keys'][$key]['type']
											//|| $currfield['keys'][$key]['key_name'] == $loc_field['keys'][$key]['key_name']
										   ) $bKeyAvailable = true;
											
									// add key
									if( !$bKeyAvailable )
									{
										// add index-type
										if( $currfield['keys'][$key]['type'] == 'primary' )
										{
											// suche primary und lösche diesen, falls vorhanden
											$bPrimaryKeyExists = false;
											$bAutoIncrementExists = false;
											for( $iFIELD=0; $iFIELD < sizeof($loc_table['fields']); $iFIELD++ ){
												for( $iKEY=0; $iKEY < sizeof($loc_table['fields'][$iFIELD]['keys']); $iKEY++ ){
													if( $loc_table['fields'][$iFIELD]['keys'][$iKEY]['type'] == 'primary' )
													{
														// auto increment available									
														if( strtoupper($loc_table['fields'][$iFIELD]['extra']) == 'AUTO_INCREMENT' )
														{
															$sql_changefield = ' ALTER TABLE `'.$loc_table['name'].'` CHANGE `'.$loc_table['fields'][$iFIELD]['name'].'` `'.$loc_table['fields'][$iFIELD]['name'].'` '.$loc_table['fields'][$iFIELD]['type'].' NOT NULL DEFAULT \'\' ;';
															$aSQLBuffer[sizeof($aSQLBuffer)] = array( 	'query' 		=>  $sql_changefield,
																										'description'	=> 'Remove AUTO-INCREMENT `'.$loc_table['name'].':'.$loc_table['fields'][$iFIELD]['name'].'` ',
																									);
														}//if
														
														
														// drop primary key
														$sql_changefield = ' ALTER TABLE `'.$loc_table['name'].'` DROP PRIMARY KEY ; ';
														$aSQLBuffer[sizeof($aSQLBuffer)] = array( 	'query' 		=>  $sql_changefield,
																									'description'	=> 'Drop Primary-Key `'.$loc_table['name'].':'.$loc_table['fields'][$iFIELD]['name'].'` ',
																								);
													}//if
													
												}//for
											}//for
											
											// set primary key
											// -----------------------
											$sql_changefield = ' ALTER TABLE `'.$current[$t]['name'].'` ADD PRIMARY KEY (`'.$currfield['name'].'`) ;';
											$aSQLBuffer[sizeof($aSQLBuffer)] = array( 	'query' 		=>  $sql_changefield,
																						'description'	=> 'Add PRIMARY-KEY to `'.$current[$t]['name'].':'.$currfield['name'].'` ',
																					);
																					

											// AUTO-INCREMENT
											if( strtoupper($currfield['extra']) == 'AUTO_INCREMENT' )
											{
												// set auto-increment
												// -----------------------
												$sql_changefield = ' ALTER TABLE `'.$current[$t]['name'].'` CHANGE `'.$currfield['name'].'` `'.$currfield['name'].'` '.$currfield['type'].' NOT NULL AUTO_INCREMENT ; ';
												$aSQLBuffer[sizeof($aSQLBuffer)] = array( 	'query' 		=>  $sql_changefield,
																							'description'	=> 'Change extras, AUTO-INCREMENT `'.$current[$t]['name'].':'.$currfield['name'].'` ',
																						);
											}// auto-increment
										}
										else if( $currfield['keys'][$key]['type'] == 'index' )
										{
											// set index key
											// -----------------------
											$sql_changefield = ' ALTER TABLE `'.$current[$t]['name'].'` ADD INDEX (`'.$currfield['name'].'`) ;';
											$aSQLBuffer[sizeof($aSQLBuffer)] = array( 	'query' 		=>  $sql_changefield,
																						'description'	=> 'Add INDEX to `'.$current[$t]['name'].':'.$currfield['name'].'` ',
																					);
										}
										else if( $currfield['keys'][$key]['type'] == 'unique' )
										{
											// set unique key
											// -----------------------
											$sql_changefield = ' ALTER TABLE `'.$current[$t]['name'].'` ADD UNIQUE (`'.$currfield['name'].'`) ;';
											$aSQLBuffer[sizeof($aSQLBuffer)] = array( 	'query' 		=>  $sql_changefield,
																						'description'	=> 'Add UNIQUE to `'.$current[$t]['name'].':'.$currfield['name'].'` ',
																					);
										}
									}//if
									
									
								}//for
								
								
								/*
								if( strtoupper($currfield['key']) == 'PRI' )
								{
									if( strtoupper($loc_field['key']) == 'PRI' )
										$sql_changefield = 'ALTER TABLE `'.$current[$t]['name'].'` DROP PRIMARY KEY';
									if( strtoupper($loc_field['key']) == 'UNIQUE' )
										$sql_changefield = 'ALTER TABLE `'.$current[$t]['name'].'` DROP INDEX `'.$currfield['name'].'` ';
									if( strtoupper($loc_field['key']) == 'INDEX' )
										$sql_changefield = 'ALTER TABLE `'.$current[$t]['name'].'` DROP INDEX `'.$currfield['name'].'` ';
									// -> execute SQL
									
									$sql_changefield = ' ALTER TABLE `'.$current[$t]['name'].'` ADD PRIMARY KEY (`'.$currfield['name'].'`) ';
									// -> execute SQL
									
									// ALTER TABLE `egl_admin_permissions` CHANGE `id` `id` INT( 11 ) NOT NULL AUTO_INCREMENT
									//echo "<br/>".$sql_changefield;
								}
								else if( strtoupper($currfield['key']) == 'INDEX' )
								{
									if( strtoupper($loc_field['key']) == 'PRI' )
										$sql_changefield = 'ALTER TABLE `'.$current[$t]['name'].'` DROP PRIMARY KEY';
									if( strtoupper($loc_field['key']) == 'UNIQUE' )
										$sql_changefield = 'ALTER TABLE `'.$current[$t]['name'].'` DROP INDEX `'.$currfield['name'].'` ';
									if( strtoupper($loc_field['key']) == 'INDEX' )
										$sql_changefield = 'ALTER TABLE `'.$current[$t]['name'].'` DROP INDEX `'.$currfield['name'].'` ';
									// -> execute SQL
									
									$sql_changefield = ' ALTER TABLE `'.$current[$t]['name'].'` ADD INDEX (`'.$currfield['name'].'`) ';
									// -> execute SQL
									
								}
								else if( strtoupper($currfield['key']) == 'UNIQUE' )
								{
									if( strtoupper($loc_field['key']) == 'PRI' )
										$sql_changefield = 'ALTER TABLE `'.$current[$t]['name'].'` DROP PRIMARY KEY';
									if( strtoupper($loc_field['key']) == 'UNIQUE' )
										$sql_changefield = 'ALTER TABLE `'.$current[$t]['name'].'` DROP INDEX `'.$currfield['name'].'` ';
									if( strtoupper($loc_field['key']) == 'INDEX' )
										$sql_changefield = 'ALTER TABLE `'.$current[$t]['name'].'` DROP INDEX `'.$currfield['name'].'` ';
									// -> execute SQL
									
									$sql_changefield = ' ALTER TABLE `'.$current[$t]['name'].'` ADD UNIQUE (`'.$currfield['name'].'`) ';
									// -> execute SQL
								}
								*/
							}//if
													
						}//if changed	
						
					}
					else
					{
						//echo nl2br( print_r( $current[$t]['fields'][$f], 1));
						//exit;
						
						// search for exists primary keys, auto_increment
						/*for( $iFIELD=0; $iFIELD < sizeof($newfield['keys']); $iFIELD++ ){
							[..]
						}*/
						
						// add new field
						$newfield 		= $current[$t]['fields'][$f];
						$null_def		= " NOT NULL ";
						$after_def 		= "";
						$auto_inc		= "";
						$auto_inc_key	= "";
						$default		= "";
						
						// AFTER / FIRST column
						if( $f > 0 ) {
							$pre_field = $current[$t]['fields'][$f-1];
							$after_def = " AFTER `".$pre_field['name']."`";
						}//if
						else{
							$after_def = " FIRST ";
						}
						// NOT NULL
						if( strtoupper($newfield['null']) == 'YES' )
							$null_def = " NULL ";
						
						// SET DEFAULT
						if( strlen($newfield['default']) > 0 ){
							$default = " DEFAULT '".$newfield['default']."' \n ";
						}//if
							
						// AUTO-INCREMENT
						if( strtoupper($newfield['extra']) == 'AUTO_INCREMENT' ){
							$auto_inc		= " AUTO_INCREMENT \n ";
							$auto_inc_key	= " ADD PRIMARY KEY (`".$newfield['name']."`) ";
						}
						
						$field_addkeys = '';
						for( $iKEY=0; $iKEY < sizeof($newfield['keys']); $iKEY++ ){
							

							if( $newfield['keys'][$iKEY]['type'] == 'primary' ){
								$field_addkeys .= " ADD PRIMARY KEY ( `".$newfield['name']."` ) ,\n";
							}//if
							if( $newfield['keys'][$iKEY]['type'] == 'index' ){
								$field_addkeys .= " ADD INDEX ( `".$newfield['name']."` ) ,\n";
							}//if
							if( $newfield['keys'][$iKEY]['type'] == 'unique' ){
								$field_addkeys .= " ADD UNIQUE ( `".$newfield['name']."` ) ,\n";
							}//if
							
						}//for
						$field_addkeys = substr($field_addkeys,0,strlen($field_addkeys)-2);	// 2, becuase ",\n" to delete ','
						if( strlen($field_addkeys) > 0 ){
							$field_addkeys = ','.$field_addkeys;
						}
						
						$sql_addfield = 	"ALTER TABLE `".$current[$t]['name']."` ADD `".
											$newfield['name']."` \n".
											$newfield['type']." \n".
											$null_def." \n".
											$default." ".
											$auto_inc." ".
											$after_def." ".
											$field_addkeys.
											' ;';
						//echo "<br/>".$sql_addfield;
						$aSQLBuffer[sizeof($aSQLBuffer)] = array( 	'query' 		=>  $sql_addfield,
																	'description'	=> 'Add new field `'.$current[$t]['name'].':'.$newfield['name'].'`',
																);
								
										
					}//else if
					
				}//for
								
				
			}
			else
			{
				// create table
				// $current[$t]['name']
				
				/*
				CREATE TABLE `eg_mytestsync` (
					`id` INT NOT NULL AUTO_INCREMENT,
					`name` VARCHAR( 255 ) NOT NULL ,
					PRIMARY KEY ( `id`),
					INDEX ( `name` )
					) ENGINE = innodb;
				*/
				
				$tbadd_query 	= " CREATE TABLE `".$current[$t]['name']."` ( ";
				$tbadd_keys	 	= "";
				for( $f=0; $f < sizeof($current[$t]['fields']); $f++ ){
					$null_def 	= " NOT NULL ";
					$auto_inc 	= "";
					$default 	= "";
					
					// NOT NULL
					if( strlen($current[$t]['fields'][$f]['default']) > 0 )
						$default = " default '".$current[$t]['fields'][$f]['default']."' ";
						
					// AUTO_INCREMENT
					if( strtoupper($current[$t]['fields'][$f]['extra']) == 'AUTO_INCREMENT' )
					{
						$auto_inc 	= "auto_increment";
						$default	= ""; // delete
					}
					
					// NOT NULL
					if( strtoupper($current[$t]['fields'][$f]['null']) == 'YES' )
						$null_def = " NULL ";
						
					// save keys
					for( $key=0; $key < sizeof($current[$t]['fields'][$f]['keys']); $key++ )
					{
						 if( $current[$t]['fields'][$f]['keys'][$key]['type'] == 'primary' ){
							 $tbadd_keys .= " PRIMARY KEY ( `".$current[$t]['fields'][$f]['name']."` ) ,\n";
						 }
						 if( $current[$t]['fields'][$f]['keys'][$key]['type'] == 'index' ){
							 $tbadd_keys .= " INDEX ( `".$current[$t]['fields'][$f]['name']."` ) ,\n";
						 }
						 if( $current[$t]['fields'][$f]['keys'][$key]['type'] == 'unique' ){
							 $tbadd_keys .= " UNIQUE ( `".$current[$t]['fields'][$f]['name']."` ) ,\n";
						 }
					}//for
						
					$tbadd_query .= "\n`".$current[$t]['fields'][$f]['name']."` ".$current[$t]['fields'][$f]['type']."  ".$null_def." ".$default." ".$auto_inc." ,";
				}
				
				$tbadd_keys = substr($tbadd_keys,0,strlen($tbadd_keys)-2);	// 2, becuase ",\n" to delete ','
				$tbadd_query .= $tbadd_keys . "\n) ENGINE = innodb;";
				
				//echo "<br/>".$tbadd_query;
				$aSQLBuffer[sizeof($aSQLBuffer)] = array( 	'query' 		=>  $tbadd_query,
															'description'	=> 'Create new table `'.$current[$t]['name'].'`',
														);
			}//if
		}//for
		
		return $aSQLBuffer;
	}

	/**
	 * __CompateFieldKeys
	 * 
	 */
	function __CompateFieldKeys( $keys1, $keys2 ){
		if( sizeof($keys1) != sizeof($keys2) ){
			return false;
		} 
		else {
			$bOK = true;
			for( $i=0; $i < sizeof($keys1); $i++ )
				if( $keys1[$i]['type'] != $keys1[$i]['type'] ||
					$keys1[$i]['cardinality'] != $keys1[$i]['cardinality']
					)
					$bOK = false;
			return $bOK;
		}//if
	}
};

?>