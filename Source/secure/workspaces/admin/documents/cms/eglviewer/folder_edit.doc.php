<?php
	global $gl_oVars;
	
	# url params
	$iCatId	 		= (int)$_GET['cat_id'];
	$iWorkCatId	 	= (int)$_GET['work_catid'];

	# object/classes
	$cCategory = new MyCategory( $gl_oVars->cDBInterface );
	
	
	# fetch data
	$oCat = $cCategory->GetCategoryById( $iWorkCatId );
	
	# ----------------------------------
	# update category
	# ----------------------------------
	if( $_GET['a'] == 'go' )
	{
	

		$obj_update = array( 	'name'		=> $_POST['name'],
								'cat_id'	=> $_POST['cat_id']
							);
		
	
		# try chaning data				
		if( $cCategory->SetCategoryData( $obj_update, $iWorkCatId ) )
		{
			PageNavigation::Location( $gl_oVars->sURLFile.'?page='.$gl_oVars->sURLPage.'&cat_id='.$iCatId.'&work_catid='.$iWorkCatId );
		}//if
		else
		{
		}
	}//if
	
	
	$oCatRoot = $cCategory->GenerateTree( -1, -1 );
	$gl_oVars->cTpl->assign( 'categoryroot', $oCatRoot );
	
	# fetch data
	$oCatRoot = $cCategory->GenerateTree( $iWorkCatId );
	$aPath = $cCategory->GetPath( $oCatRoot->oProperties->id );
	
	
	$gl_oVars->cTpl->assign( "CatRoot", $oCatRoot );
	$gl_oVars->cTpl->assign( "path", $aPath );
	$gl_oVars->cTpl->assign( 'cat', $oCat );
?>