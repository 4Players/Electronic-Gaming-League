<?php

function smarty_modifier_smilies($string)
{
	$string = str_replace( ":)", 			"<img src='images/smilies/smile.gif'/>", 		$string );
	$string = str_replace( ";)", 			"<img src='images/smilies/wink.gif'/>", 		$string );
	$string = str_replace( ":D", 			"<img src='images/smilies/bigsmile.gif'/>", 	$string );
	$string = str_replace( ":rolleyes:",	"<img src='images/smilies/rolleyes.gif'/>", 	$string );
	$string = str_replace( ":thumb:", 		"<img src='images/smilies/thumb.gif'/>",		$string );
	$string = str_replace( ":angry:", 		"<img src='images/smilies/mad.gif'/>", 			$string );
	$string = str_replace( ":cool:", 		"<img src='images/smilies/cool.gif'/>", 		$string );
	$string = str_replace( ":what:", 		"<img src='images/smilies/s_what.gif'/>", 		$string );
	$string = str_replace( ":lol:", 		"<img src='images/smilies/s_lol.gif'/>", 		$string );
	return $string;
}
?>