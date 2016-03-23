<table border="0" width="100%" cellpadding="0" cellspacing="0">
 <tr><td valign="top">
	
	<table><tr><td><img src="images/cupicon_gold_small.gif" width="50"/></td><td><font style="font-size:20px;">{$cup->name|strip_tags|stripslashes}</font><br/><b>{$LNG_MODULE.c1350}</b></td></tr></table>
 	<br/>
	
	{if strlen($cup->rules_text) > 0}
		<table width="100%" bgcolor="#C0C0C0" cellpadding="5" cellspacing="1" height="200">
		 <tr>
		 	<td valign="top" bgcolor="#FFFFFF"><font face="Courier New">{$cup->rules_text|strip_tags|stripslashes|nl2br}</font></td>
		 </tr>
		</table>
	{else}
		<table width="100%" bgcolor="#C0C0C0" cellpadding="5" cellspacing="1" height="200">
		 <tr>
		 	<td align="center" valign="center" bgcolor="#FFFFFF"><font face="Courier New"><i>{$LNG_MODULE.c1351}</i></font></td>
		 </tr>
		</table>
	{/if}
		
 </td>
 <td width="100" align="center" valign="top">
 
	{include file="`$page_dir`/menu_right.tpl"} 
 	
 </td></tr>
</table>
