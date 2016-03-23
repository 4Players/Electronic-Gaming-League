<h2>{$LNG_BASIC.c5550}</h2>
{include file="devs/message.tpl"}

{if !$success}
<form name="f" action="{$url_file}page={$url_page}&a=go" method="POST">
<table cellpadding="2">
<tr>
	<td><select class="egl_select" name="clan_id" style="width:250px;">
		{section name=clan loop=$clans}
			<option value="{$clans[clan]->id}">{$clans[clan]->name|strip_tags|stripslashes}</option>
		{/section}
		</select>
	</td>
	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1216 link="javascript:document.f.submit();"}</td>
</tr>
</table>
</form>
{/if}