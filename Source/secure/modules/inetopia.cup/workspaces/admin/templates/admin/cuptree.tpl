<table cellpadding="5"><tr>
	<td><table cellpadding="1" cellspacing="0" bgcolor="#000000"><tr><td><img src="{$PATH_GAMES}small/{$game->logo_small_file}" width="30" height="40"/></td></tr></table> </td>
	<td><h2>Turnier `{$cup->name|strip_tags|stripslashes}` Turnierbaum</h2></td>
 </tr></table>
{include file="`$page_dir`/admin/cupmenu.tpl"}
<hr size="1"/>
{include file="etc/message.tpl"}
{if $success}
	
{else}
	{include file="`$page_dir`/admin/cuptree.display.tpl"}
{/if}

