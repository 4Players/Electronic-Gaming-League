<table border="0" width="100%" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}">
 <tr bgcolor="{#clr_content#}">
 	<!--#<td width="25%" align="center"><A href="{$url_file}page={$CURRENT_MODULE_ID}:overview"><b>Übersicht</b></a></td>#-->
 	<td width="33%" align="center"><A href="{$url_file}page={$CURRENT_MODULE_ID}:categories&cat_id={$_get.cat_id}"><b>Kategorien</b></a></td>
 	<td width="33%" align="center"><A href="{$url_file}page={$CURRENT_MODULE_ID}:archive&cat_id={$_get.cat_id}"><b>Archiv</b></a></td>
 	<td width="33%" align="center"><A href="{$url_file}page={$CURRENT_MODULE_ID}:settings&cat_id={$_get.cat_id}"><b>Einstellungen</b></a></td>
 </tr>
</table>

<br>
{include file="tb/page.open.tpl"}
	{include file="$module_file"}
{include file="tb/page.close.tpl"}