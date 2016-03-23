<h2>Mitglied löschen `{$member_data->nick_name|strip_tags|stripslashes}`</h2>
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

{if !$success}
	<table border="0">
	{section name=mod loop=$response_messages}
	<tr><td><font style="font-size:14px;"><b>{$response_messages[mod].module_name}</b></font></td></tr>
		{section name=msg loop=$response_messages[mod].responses }
		<tr><td>{$response_messages[mod].responses[msg]}</td></tr>
		{sectionelse}
		<tr><td><i>KEINE NACHRICHTEN</i></td></tr>
		{/section}
	{/section}
	</table>
	
	<br/>
	<div>
		<table cellpadding="5">
		 <tr>
			<td><b>Jetzt bitte das Mitglied `{$member_data->nick_name|strip_tags|stripslashes}` löschen</b></td>
			<td>{include file="buttons/bt_universal.tpl" caption="weiter" link="javascript:document.location.href='`$url_file`page=`$url_page`&member_id=`$member_data->id`&a=delete';"}</td>
		 </tr>
		</table>
	</div>
{/if}