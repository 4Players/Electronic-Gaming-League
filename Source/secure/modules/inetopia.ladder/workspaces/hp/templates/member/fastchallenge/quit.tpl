<h2>{$LNG_MODULE.c9854}</h2>
{include file="devs/message.tpl"}

{if !$hide_form}
<form name="f" action="{$url_file}page={$url_page}&ladder_id={$smarty.get.ladder_id}&a=quit" method="POST">
<table cellpadding="10"><tr>
	<td>{$LNG_MODULE.c9855}</td>
	<td>{include file="buttons/bt_universal.tpl" link="javascript:document.f.submit();" caption=$LNG_MODULE.c9858 color=$GLOBAL_COLOR}</td>
</tr></table>
</form>
{/if}