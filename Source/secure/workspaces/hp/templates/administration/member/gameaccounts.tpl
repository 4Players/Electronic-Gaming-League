<h2>{$LNG_BASIC.c8072} `{$member_data->nick_name|strip_tags|stripslashes}`</h2>
{include file="administration/member/header_menu.tpl"}
{include file="devs/hr2.tpl" width="100%"}

{include file="devs/message.tpl"}

{if $success}

{else}
	
	<form name="f" action="{$url_file}page={$url_page}&member_id={$member_data->id}&a=change" method="POST">
	<table border="0" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}" width="100%">
	 <tr>
	 	<td width="50%"><b>Type:</b></td>
	 	<td><b>Wert:</b></td>
	 </tr>
	{section name=gc loop=$game_accounts}
	 <tr bgcolor="{#clr_content#}">
			<td><b>{$game_accounts[gc]->name}:</b></td>
			<td><input name="gameacc_{$smarty.section.gc.index}" class="egl_text" type="text" value="{$game_accounts[gc]->value}"/><input name="gameacc_{$smarty.section.gc.index}_id" type="hidden" value="{$game_accounts[gc]->gameacc_id}"/></td>
			<td align="center">[ <A href="{$url_file}page={$url_page}&member_id={$member_data->id}&gameacc_id={$game_accounts[gc]->gameacc_id}&a=delete"/><b>Delete</b></a> ] </td>
	 </tr>
	{/section}
	 <tr bgcolor="{#clr_content#}">
		<td colspan="3" align="left">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="abschicken" 		link="javascript:document.f.submit();"}</td>
	 </tr>
	</table>
	</form>
{/if}