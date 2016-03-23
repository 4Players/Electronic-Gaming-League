<table width="650" align="center" border="0">
 <tr>
 	<td colspan="3">
 		<table border="0" cellpadding="5" align="left">
 		<tr>
 			<!--# SIGN-IN #-->
 			{if $ladder->participant_type == $smarty.const.PARTTYPE_MEMBER}
 				<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR link="javascript:document.location='`$url_file`page=`$CURRENT_MODULE_ID`:member.enter&ladder_id=`$ladder->id`';" caption=$LNG_MODULE.c9018 }</td>
 			{else}
 				<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR link="javascript:document.location='`$url_file`page=team.teamselect&page_forward=`$CURRENT_MODULE_ID`:team.enter&params=ladder_id=`$ladder->id`';" caption=$LNG_MODULE.c9018 }</td>
 			{/if}
 			<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR link="javascript:document.location='`$url_file`page=`$CURRENT_MODULE_ID`:rules&ladder_id=`$ladder->id`';" caption=$LNG_MODULE.c9021 }</td>
 			<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR link="javascript:document.location='`$url_file`page=`$CURRENT_MODULE_ID`:overview&ladder_id=`$ladder->id`';" caption=$LNG_MODULE.c9001 }</td>
 		</tr>
 		</table>
 	</td>
 </tr>
 <tr>
 	<td colspan="3">{include file="devs/hr2.tpl" width="100%"}</td>
 </tr>
 <tr>
 	<td colspan="3">
	<h2>{$LNG_MODULE.c9021}</h2> <br/>
	
	{if strlen($ladder->rules_text) > 0}
		<table width="100%" bgcolor="#C0C0C0" cellpadding="5" cellspacing="1" height="200">
		 <tr>
		 	<td valign="top" bgcolor="#FFFFFF"><font face="Courier New">{$ladder->rules_text|nl2br}</font></td>
		 </tr>
		</table>
	{else}
		<table width="100%" bgcolor="#C0C0C0" cellpadding="5" cellspacing="1" height="200">
		 <tr>
		 	<td align="center" valign="center" bgcolor="#FFFFFF"><font face="Courier New"><i>{$LNG_MODULE.c9022}</i></font></td>
		 </tr>
		</table>
	{/if}
		
 	</td>
 </tr>
</table>

