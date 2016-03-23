<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ object list ] -


# [obj]
class pt_item_t
{
	var $id		= -1;
	var $name	= "unknown";
	var $const	= "unknown";
	var $items	= array();
};

# [obj]
class pt_tree_node_t
{
	var $id		= -1;
	var $nodes	= NULL;
	var $leaves	= array();
};



# [obj]
class pt_tree_leaf_t
{
	var $id;
	var $const;
};


/*
	# structure tree
	cp	1_0 = Leader
	cp	1_0_0_0 = chekcer1
	cp	1_0_0_1 = checker2
	cp	1_0_1 	= master1
	cp	1_0_2	= master2
	cp
	cp	2_0 = Co-Leader
	cp	3_0 = Member
	cp	3_0_0 = Tes-t1
	cp	3_0_1 = Test2
	cp	3_1 = Trail
	cp	3_2 = Eherenmitglied
	cp	2_1 = other
*/


function _InTree( $array, $array_cnt )
{
}


# -[ class ] -
class PermissionTree
{
	# -[ variables ]-
	var $root_tree		= NULL;
	var $itemlist		= NULL;
	
	var $aPTStructure 	= array();
	var $bInit			= false;
	var $sFilename		= 'unknown';
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	//-------------------------------------------------------------------------------
	function PermissionTree ()
	{
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------	
	function SetPermissionFile( $sFilename )
	{
		$this->sFilename = $sFilename; 
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------	
	function LoadPermissionFile()
	{
		# try loading page_access file
		if( file_exists( $this->sFilename ) )
		{
			$this->aPTStructure = parse_ini_file( $this->sFilename );
			$this->bInit = true;
			return true;
		}//if		
		return false;				
	}

	
	//-------------------------------------------------------------------------------
	// Purpose: creates a tree basicly to cfg_array
	//-------------------------------------------------------------------------------
	function CreateTree( $prefix )
	{
		if( !$this->bInit ) 
			if( !$this->LoadPermissionFile() ) return false;
		$cfg_array = &$this->aPTStructure;
		
		
		#$prefix = "cp";
		$aItemList = array();	# global array 
		
		$base_node = & new pt_tree_node_t;
		
		$counter = 0;
		while( list($var_name, $var_value) = each($cfg_array) )
		{
			$parse_varname = "na";
			
			# correct prefix ? 
			if( strtolower( substr( $var_name, 0, strlen($prefix.'.const') ) ) == strtolower( $prefix.'.const' ) )
			{
				# read the tree way of var like: cp<->[0_0_1]
				$parse_varname = substr( $var_name, strlen($prefix.'.const'), strlen($var_name)- strlen($prefix.'.const'));
			}
			else continue;
			
			#echo "test";
			
			# constant var def of tree item
			/*
			if(  strtolower( substr( $var_name, strlen($var_name)-3, 3 ) ) == 'var' )
				continue;*/
			
			# parse varname to db format xx,yy,zz,**
			$parsed_varname = str_replace( "_", ",", $parse_varname );

			$pItem = & $aItemList[sizeof($aItemList)];
			$pItem = new pt_item_t;
			$pItem->id = ++$counter;
			$pItem->const = $cfg_array[$prefix.'.const'.$parse_varname];
			$pItem->name  = $cfg_array[$prefix.'.name'.$parse_varname];
			$pItem->items = array();
			$pItem->items = db_read_array_string( $parsed_varname );
			#$pItem->item_str = $parsed_varname;
			
			
			#echo nl2br( print_r($pItem, 1) );			
		}//while
		
		# save to class (global)
		$this->itemlist = $aItemList;
		
		# create root tree (start)
		$this->root_tree = new pt_tree_node_t;
		
		#---------------------------------------
		#create tree
		#---------------------------------------
		for( $iI=0; $iI < sizeof($aItemList); $iI++ )
		{
			$pItem = &$aItemList[$iI];
			
			$counter=0;
			$this->_insert( $pItem->items, $counter, $this->root_tree, $pItem );
		}
		return true;
	}//createtree
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: insert a item to root tree
	//-------------------------------------------------------------------------------
	function _insert( 	&$array,
						&$p_array_pos,	# array  
						&$pnode,
						&$item )
	{
		# last node reached ?
		if( $p_array_pos == sizeof($array)-1 )
		{
			$pLeaf = &$pnode->leaves[$array[$p_array_pos]];
			$pLeaf->id 		= sizeof($pnode->leaves);
			$pLeaf->const 	= $item->const;
			$pLeaf->name 	= $item->name;
			$pLeaf->way 	= $item->items;
			
			#echo "<br>".$pLeaf->const."/".$array[$p_array_pos] . " : size ".sizeof($pnode->leaves);
			#echo "L".$array[$p_array_pos]."|".$pLeaf->const . " => ". $item->item_str;
			#echo "<br>";
			return -1;
		}else
		{
			#echo $array[$p_array_pos]."|";
			
			$p_array_pos++;
			
			# create array
			if( $pnode->nodes == NULL ) $pnode->nodes = array();
			
			#  try => insert into next node
			if( $this->_insert( $array, $p_array_pos, $pnode->nodes[ $array[$p_array_pos-1] ], $item ) == -1 )
				return 0;
		}
	}//_insert
	
	function &GetRootTree(){ return $this->root_tree; }
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------
	function GetConstNameArray()
	{
		$aArray = array();
		for( $i=0; $i < sizeof($this->itemlist); $i++ )
		{
			$aArray[$i]->name = $this->itemlist[$i]->name;
			$aArray[$i]->const = $this->itemlist[$i]->const;
		}
		return $aArray;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//  Output: 0-> 
	//-------------------------------------------------------------------------------
	function Check(	$const,		# permission [1]
					$const2 )	# permission [2]
	{
		# -----------------------
		# check for available
		# -----------------------
		$pt_item_const 	= NULL;
		$pt_item_const2 = NULL;

		$this->GetLeaf( $const, $this->root_tree, $pt_item_const );
		$this->GetLeaf( $const2, $this->root_tree, $pt_item_const2 );
		
		if( !$pt_item_const || !$pt_item_const2 ) return -2;

		
		# -----------------------
		# get levels
		# -----------------------
		$const_level 	= 0;
		$const2_level	= 0;
		
		# get treenode level
		$this->GetNodeLevel( $const, $this->root_tree, $const_level );
		$this->GetNodeLevel( $const2, $this->root_tree, $const2_level );

		
		# return data
		if( $const_level == $const2_level ) return 0;
		if( $const_level < $const2_level ) return 1;
		if( $const_level > $const2_level ) return -1;
 		
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: searches an item of the root tree, recursiv
	//  Output: item
	//-------------------------------------------------------------------------------
	function GetLeaf( $const, $node, &$pout )
	{
		# search const in current node
		for( $l=0; $l < sizeof($node->leaves); $l++ )
			if( $node->leaves[$l]->const == $const )
				return ($pout = $node->leaves[$l]);

		# search const in sub nodes
		for( $s=0; $s < sizeof($node->nodes); $s++ )
			return $this->GetLeaf( $const, $node->nodes[$s], $pout );
	}//GetLeaf
	
	
	//-------------------------------------------------------------------------------
	// Purpose: searches an item of the root tree, recursiv => return node level
	//  Output: int
	//-------------------------------------------------------------------------------
	function GetNodeLevel( $const, $node, &$pout )
	{
		# search const in current node
		for( $l=0; $l < sizeof($node->leaves); $l++ )
			if( $node->leaves[$l]->const == $const )
				return ($pout);

		# search const in sub nodes
		for( $s=0; $s < sizeof($node->nodes); $s++ )
		{
			$pout++;
			return $this->GetNodeLevel( $const, $node->nodes[$s], $pout );
		}//for
	}//GetNodeLevel
	
	
	/*
	function GetNode( $node, $level, &$pout  )
	{
	}*/
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------	
	function GetLastNode( &$pnode, &$pOut )
	{
		if( sizeof($pnode->nodes) == 0 )
		{
			return($pOut=$pnode->leaves[sizeof($pnode->leaves)-1]);
		}
			
		# search const in sub nodes
		$this->GetLastNode( $pnode->nodes[sizeof($pnode->nodes)-1], $pOut );
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	//  Output: leave data
	//-------------------------------------------------------------------------------
	function GetLast()
	{
		$data = NULL;
		$this->GetLastNode( $this->root_tree, $data );
		return $data;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	//-------------------------------------------------------------------------------	
	function GetFirst()
	{
		$data = NULL;
		return $this->root_tree->leaves[0];
	}
};


?>