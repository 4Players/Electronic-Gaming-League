<?php


//------------------------------------------------------------------------------
// Purpose:
//  Output:
//------------------------------------------------------------------------------
function smarty_function_rndname($params, &$smarty)
{
	# set standard settings
	return CreateRandomPassword(5);
}


?>