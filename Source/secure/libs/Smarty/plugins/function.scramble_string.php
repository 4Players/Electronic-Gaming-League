<?php
#####################################################################################
#
# 
#
#####################################################################################


	#---------------------------------------------------
	# Purpose:
	#  Output:
	#---------------------------------------------------
	function smarty_function_scramble_string($params, &$smarty)
	{
		$xor_i 			= rand( 5, 15 );
		$func_name		= chr(rand(65,90)).md5(chr(rand(65,90)).(string)microtime());
		$str_scramble	= $params['string'];
		$xor_encoded	= array();
		$encbufname		= chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90));
		
		for( $i=0; $i < strlen($str_scramble); $i++ ){
			 $xor_encoded[$i].= ord($str_scramble[$i])^$xor_i;
		}//for
	
		$sAdditionalVarDef = '';
		if( sizeof($xor_encoded) > 1 ){
			$sXOREncodedJSArray = '';
			for( $l=0; $l < sizeof($xor_encoded); $l++ ){
				$sXOREncodedJSArray .= $xor_encoded[$l].',';
			}//for
			if( strlen($sXOREncodedJSArray) > 0 ) $sXOREncodedJSArray=substr( $sXOREncodedJSArray, 0, strlen($sXOREncodedJSArray)-1 );
		}else{
			$sXOREncodedJSArray 	= '1';
			$sAdditionalVarDef 		= $encbufname.'[0]='.(int)$xor_encoded[0] .';';
		}//if
		
		$output .= 	' <script language=\'javascript\' type=\'text/javascript\'>'.
					' function '.$func_name.'(){'.
					' var enc='.$xor_i.';'.
					' var '.$encbufname.'=new Array('.$sXOREncodedJSArray.'); '.
					' '.$sAdditionalVarDef.' '.
					' for( var i=0; i < '.$encbufname.'.length; i++ ) '.
					' document.write( String.fromCharCode('.$encbufname.'[i]^enc) );'.
					' }'.
					' '.$func_name.'(); '.
					' </script>';
		return $output;
	}
?>