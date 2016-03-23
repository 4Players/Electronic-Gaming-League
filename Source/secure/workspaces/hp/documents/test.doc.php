<?php

sleep( 5 );
global $gl_oVars;
$cDBConfigs = new DBConfigs( $gl_oVars->cDBInterface );
$t = (int)$cDBConfigs->GetConfig( 'test' );
$cDBConfigs->SetConfig( 'test', $t+1 );


?>