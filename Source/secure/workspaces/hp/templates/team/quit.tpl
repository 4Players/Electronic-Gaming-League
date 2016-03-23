<h2>{$LNG_BASIC.c5520}</h2>
{include file="devs/message.tpl"}

{if !$success}
<form name="f" action="{$url_file}page={$url_page}&a=go" method="POST">
<table cellpadding="10">
<tr>
	<td><select class="egl_select" name="team_id" style="width:250px;">
		{section name=team loop=$teams}
			<option value="{$teams[team]->id}">{$teams[team]->name|strip_tags|stripslashes}</option>
		{/section}
		</select>
	</td>
	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1216 link="javascript:document.f.submit();"}</td>
</tr>
</table>
</form>
{/if}