<h2>Ladder `{$ladder->name|strip_tags|stripslashes}` Regelwerk</h2>
{include file="`$page_dir`/admin/laddermenu.tpl"}
<hr size="1"/>
{include file="etc/message.tpl"}

{if $success}
{else}
<form name="f" action="{$url_file}page={$url_page}&ladder_id={$ladder->id}&a=change" method="POST">
<table width="100%">
 <tr>
 	<td>
 		<textarea class="rules_text" name="rules_text" style="width:100%;" rows="50">{$ladder->rules_text|stripslashes}</textarea>
 	</td> 
 </tr>
 <tr>
 	<td>
 	{include file="buttons/bt_universal.tpl" link="javascript:document.f.submit();" caption="abschicken"}
 	</td> 
 </tr>
</table>
</form>

{/if}