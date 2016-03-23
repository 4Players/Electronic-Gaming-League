<?php
# ================================ Copyright  2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose: Callback-Check for PageAccess Manageer
# ================================================================================================================

function callback( $oVars, $params )
{
	global $gl_oVars;
	/**
	 * $params
	 * 		=> data		: permission-list
	 */	
	if( isset($_GET['forum_id']))
 	{
		if( isset($params['current_permission']) > 0 ){
			if( (int)$params['current_permission']->data == $_GET['forum_id'] ){
				return 1;
			}
		}//if
	}
	else if( isset($_GET['topic_id'] ))
	{
		$cForums = new EGLForums( $gl_oVars->cDBInterface );
		$oTopic = $cForums->FetchTopic( $_GET['topic_id'] );
		if( $oTopic && strlen($params['current_permission']) > 0 ){
			if( (int)$params['current_permission']->data == $oTopic->forum_id ){
				return 1;
			}
		}//if
	}
	else if( isset($_GET['post_id'] ))
	{
		$cForums = new EGLForums( $gl_oVars->cDBInterface );
		$oPost = $cForums->FetchPost( $_GET['post_id'] );
		if( $oPost && isset($params['current_permission']) ){
			if( (int)$params['current_permission']->data == $oPost->forum_id ){
				return 1;
			}
		}//if
	}//if
	return 0;
}//function
?>