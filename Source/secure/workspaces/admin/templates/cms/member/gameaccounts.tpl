<h2>GameAccounts `{$member_data->nick_name|strip_tags|stripslashes}`</h2>
<table>
<tr>
	<td>{include file="buttons/bt_universal.tpl" caption="Zentrale" link="`$url_file`page=cms.member.central&member_id=`$member_data->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Profil" link="`$url_file`page=cms.member.profile&member_id=`$member_data->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="GameAccounts" link="`$url_file`page=cms.member.gameaccounts&member_id=`$member_data->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="History" link="`$url_file`page=cms.member.history&member_id=`$member_data->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Adminrechte" link="`$url_file`page=cms.admin.central&member_id=`$member_data->id`"}</td>
</tr>
<tr>
	<td>{include file="buttons/bt_universal.tpl" caption="Löschen" link="`$url_file`page=cms.member.delete&member_id=`$member_data->id`"}</td>
</tr>
</table>
<hr size="1"/>


{include file="etc/message.tpl"}

{if $success}

{else}

<form action="{$url_file}page={$url_page}&member_id={$member_data->id}&a=change" method="POST">
<table border="0" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}" width="100%">
 <tr>
 	<td width="250"><b>Type:</b></td>
 	<td><b>Wert:</b></td>
 </tr>
{section name=gc loop=$game_accounts}
 <tr bgcolor="{#clr_content#}">
		<td><b>{$game_accounts[gc]->name}:</b></td>
		<td><input name="gameacc_{$smarty.section.gc.index}" class="egl_text" type="text" value="{$game_accounts[gc]->value}"/><input name="gameacc_{$smarty.section.gc.index}_id" type="hidden" value="{$game_accounts[gc]->gameacc_id}"/></td>
		<td align="center">[ <A title="Account löschen?" href="{$url_file}page={$url_page}&member_id={$member_data->id}&gameacc_id={$game_accounts[gc]->gameacc_id}&a=delete"><b>Delete</b></a> ] </td>
 </tr>
{/section}
 <tr bgcolor="{#clr_content#}">
	<td colspan="3" align="left"><input type="image" src="images/buttons/new/bt_send.gif"/></td>
 </tr>
</table>
</form>
{/if}