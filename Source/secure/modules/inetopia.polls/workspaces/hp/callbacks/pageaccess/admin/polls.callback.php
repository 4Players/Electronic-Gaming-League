<?php
function callback( $oVars, $params )
{
	if( !isset($_GET['cat_id']) )
	{
		return 1;
	}
	else
	{
		if( isset($params['current_permission']) > 0 ){
			if( (int)$params['current_permission']->data == $_GET['cat_id'] ){
				return 1;
			}
			else if( $params['current_permission']->data == 'all' ){
				return 1;
			}
		}//if
	}//if
}//function
?>