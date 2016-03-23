<?php

global $gl_oVars;



$cNews = new CNews( $gl_oVars->cDBInterface );
$aNews = $cNews->GetNews( 0, 20 );



$gl_oVars->cTpl->assign( 'news', $aNews );

?>