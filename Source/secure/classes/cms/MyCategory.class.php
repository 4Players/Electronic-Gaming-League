<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


class tree_node_t
{
	var $oSubProperties = NULL;
	var $oProperties 	= NULL;
	var $aNodes 		= array();
	var $aObjects		= array();
};


class tree_object_t
{
	var $sName		= 'unknown';
	var $iType		= 0;
};


class MyCategory
{
	# -[ variables ]-
	var $pDBInterfaceCon	= NULL;
	var $oRootNode 			= NULL;
	var $aDynCatList		= array();
	var $aCatList			= array();
	
	
	
	# -[ functions ]-

	//-------------------------------------------------------------------------------
	// Purpose: constructor
	//-------------------------------------------------------------------------------
	function MyCategory ( &$pDBCon )
	{
		$this->pDBInterfaceCon = &$pDBCon;
		$this->oRootNode = new tree_node_t;
		$this->oRootNode->oProperties->id = -1;
		$this->oRootNode->oProperties->name = "EGL_ROOT";
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function CreateCategory ( $name, $cat_id=-1 )
	{
		$obj = array( 	"name" => $name,	
						"cat_id" => $cat_id,
						"created" => EGL_TIME );
				
		$counter=1;
		while( true )
		{
			if( $this->CategoryExists($obj['name'], $obj['cat_id']) )
			{
				$obj['name'] = "{$name} {$counter}";
				$counter++;
			}else break;
			if( $counter > 100 ) 
			{
				return 0;
			}//if
		}
		
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBInterfaceCon->CreateInsertQuery( $GLOBALS['g_egltb_categories'], $obj );
		if( $this->pDBInterfaceCon->Query( $sql_query ) )
		{
			return $this->pDBInterfaceCon->InsertId();
		}
		return 0;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//-------------------------------------------------------------------------------
	function RenameCategory ( $newname, $id=-1 )
	{
		$obj = array( 	"name" 		=> $name,	
						"cat_id" 	=> $cat_id,
						"created" 	=> EGL_TIME );
				
		$counter=1;
		while( true )
		{
			if( $this->CategoryExists($obj['name'], $obj['cat_id']) )
			{
				$obj['name'] = "{$name} {$counter}";
				$counter++;
			}else break;
			if( $counter > 100 ) 
			{
				return 0;
			}//if
		}
		
		# creat insert query + execute => return true/false
		$sql_query = $this->pDBInterfaceCon->CreateUpdateQuery( $GLOBALS['g_egltb_categories'], $obj )." WHERE id=".(int)$cat_id."";
		return ($this->pDBInterfaceCon->Query( $sql_query ) );
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------
	function GetCategoryByName( $name )
	{
		$sql_query = " SELECT * ".
					 " FROM `".$GLOBALS['g_egltb_categories']."` ".
					 " WHERE name=\"".$this->pDBInterfaceCon->EscapeString($name)."\"";
					 
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ));
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------
	function GetCategoryById( $id )
	{
		$sql_query = " SELECT * ".
					 " FROM `".$GLOBALS['g_egltb_categories']."` ".
					 " WHERE id=".(int)$id." ";
					 
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ));
	}
	
	
	#------------------------------------------------------------------------------
	# Purpose: 
	#------------------------------------------------------------------------------
	function SetCategoryData( $data, $id )
	{
		$sql_query = 	$this->pDBInterfaceCon->CreateUpdateQuery(  $GLOBALS['g_egltb_categories'], $data ) . 
						" WHERE id=".(int)$id." ";
		# execute query
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
		

	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output :
	//-------------------------------------------------------------------------------
	function CategoryExists( $name, $id )
	{
		$sql_query = " SELECT * ".
					 " FROM `".$GLOBALS['g_egltb_categories']."` ".
					 " WHERE name=\"".$this->pDBInterfaceCon->EscapeString($name)."\" && cat_id=".(int)$id. " ";
					 
		return $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ));
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function ReadCategoriesFromDB()
	{
		$sql_query = " SELECT * FROM `{$GLOBALS['g_egltb_categories']}` AS cats ORDER BY name ";
		$this->aDynCatList = $this->aCatList = $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ));
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------	
	function DeleteCategory( $cat_id, $bSubCats )
	{
		$sql_query = " DELETE FROM `{$GLOBALS['g_egltb_categories']}` WHERE id=".(int)$cat_id." ";
		if( $this->pDBInterfaceCon->Query( $sql_query ) )
		{
			if( $bSubCats )
			{
				$sql_query = " SELECT * FROM `{$GLOBALS['g_egltb_categories']}` WHERE cat_id=".(int)$cat_id." ";
				$aSubCats = $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ));
				
				for( $i=0; $i < sizeof($aSubCats); $i++ )
				{
					$this->DeleteCategory( $aSubCats[$i]->id, true );
				}//for
				
			}//if
		}//if
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function GenerateTree( $cat_id, $level=2 )
	{
		if( sizeof($this->aDynCatList) == 0 )
		{
			$this->ReadCategoriesFromDB();
		}
		
					
		# generate tree
		$this->generate_tree( $this->oRootNode, $cat_id, $level );
		
		# get root node informations
		if( $cat_id != -1 )
		{
			$properties = $this->GetCatProperties( $cat_id );
			$sub_properties = $this->GetCatProperties( $properties->cat_id );
			$this->oRootNode->oSubProperties  = $sub_properties;
			$this->oRootNode->oProperties  = $properties;
		}
		return $this->oRootNode;
	}
	


	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function generate_tree( &$node, $cat_id, $level )
	{
		if( $level == -1 || $level > 0 )
		{
			$aNodeCats 		= $this->CutSubCatsFromCat( $cat_id );
			$node->aObjects = $this->GenerateObjectList( $cat_id );
			for( $n=0; $n < sizeof($aNodeCats); $n++ )
			{
				$pNode = &$node->aNodes[$n];
				$pNode = new tree_node_t;
				
				$pNode->oProperties = $aNodeCats[$n];
				if( $level == -1 )
					$this->generate_tree( $node->aNodes[$n], $aNodeCats[$n]->id, $level );
				else
					$this->generate_tree( $node->aNodes[$n], $aNodeCats[$n]->id, --$level );
			}//for
		}
	}//function

	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function CutSubCatsFromCat( $id )
	{
		$aCats = array();
		$aNewCatList = array();
		for( $i=0; $i < sizeof($this->aDynCatList); $i++ )
		{
			if( $this->aDynCatList[$i]->cat_id == $id )
			{
				$aCats[sizeof($aCats)] =  $this->aDynCatList[$i];
			}
			else
			{
				$aNewCatList[sizeof($aNewCatList)] =  $this->aDynCatList[$i];
			}
		}
		# save new list
		$this->aCatList = $aNewCatList;
		return $aCats;
	}//function

	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function finde_path( $cat_id, &$path )
	{
		if( $cat_id != -1 )
		{
			for( $i=0; $i < sizeof($this->aCatList); $i++ )
			{
				if( $this->aCatList[$i]->id == $cat_id )
				{
					$num_items = sizeof($path);
					$path[$num_items] = $this->GetCatProperties( $cat_id );
					return $this->finde_path( $path[$num_items]->cat_id, $path );
				}//if
			}//for
		}//if
		return 1;
	}
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function GetPath( $cat_id )
	{
		$path = array();
		$this->finde_path( $cat_id, $path );
		return array_reverse( $path );
	}
	
	
	
	/*
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function finde_sub_cats( $cat_id, &$path )
	{
		if( $cat_id != -1 )
		{
			for( $i=0; $i < sizeof($this->aCatList); $i++ )
			{
				if( $this->aCatList[$i]->id == $cat_id )
				{
					$num_items = sizeof($path);
					$path[$num_items] = $this->GetCatProperties( $cat_id );
					return $this->finde_path( $path[$num_items]->cat_id, $path );
				}//if
			}//for
		}//if
		return 1;
	}	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function GetSubCategories( $cat_id )
	{
		$path = array();
		$this->finde_sub_cats( $cat_id, $path );
		return array_reverse( $path );
	}*/
	
	
	
	
	/*
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function GetNode( $id )
	{
		return $this->node_search( $id, $this->oRootNode );
	}
	
	function node_search( $id, &$root )
	{
		for( $i=0; $i < sizeof($root->aNodes); $i++ )
		{
			if( $root->aNodes[$i]->oProperties->id == $id )
			{
				return $root->aNodes[$i];
			}else
			{
				echo $root->aNodes[$i];
			}
		}//root
		return NULL;
	}*/
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function GetCatProperties( $id )
	{
		for( $i=0; $i < sizeof( $this->aCatList ); $i++ )
		{
			if( $this->aCatList[$i]->id == $id ) return $this->aCatList[$i];
		}//for
	}//function
		
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function GenerateObjectList( $cat_id )
	{

		global $gl_oVars;
		$aModules 		= $gl_oVars->cModuleManager->GetActivatedModules();
		$aObjectlist	= array();

		for( $mod=0; $mod < sizeof($aModules); $mod++ )
		{
			// get objectlist from all modules
			$aModuleObjects = module_sendmessage( $aModules[$mod]->ID, 'category_objectlist', $__DATA__, $cat_id );
			
			if( is_array($aModuleObjects) && is_array($aObjectlist) )
			{
				// merge objectlists
				$aObjectlist = array_merge_recursive( $aObjectlist, $aModuleObjects );
			}//if
		}//for
		
		return $aObjectlist;
	}

}

?>