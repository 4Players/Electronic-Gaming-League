<table border="0" width="100%" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}">
 <tr bgcolor="{#clr_content#}">
  {if isset($_get.cat_id)}
  	<td width="50%" align="center"><A href="{$url_file}page={$CURRENT_MODULE_ID}:categories&cat_id={$_get.cat_id}"><b>Kategorie Übersicht</b></a> </td>
 {else}
  	<td width="50%" align="center"><b>Kategorie Übersicht</b></a> </td>
 {/if}
 
  {if isset($_get.cat_id)}
 		<td width="50%" align="center"><A href="{$url_file}page={$CURRENT_MODULE_ID}:create&cat_id={$_get.cat_id}"><b>Neue Umfragen</b></a></td>
  {else}
 		<td width="50%" align="center"><A href="{$url_file}page={$CURRENT_MODULE_ID}:create&cat_id={$pollcategories->oProperties->id}"><b>Neue Umfragen</b></a></td>
  {/if}
  </tr>
</table>
<br>
{include file="tb/page.open.tpl"}
	{include file="$module_file"}
{include file="tb/page.close.tpl"}