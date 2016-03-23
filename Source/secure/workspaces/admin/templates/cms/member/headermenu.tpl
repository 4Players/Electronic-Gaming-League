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
	<td>{include file="buttons/bt_universal.tpl" caption="Ligabetriebe" link="`$url_file`page=cms.member.leagues&member_id=`$member_data->id`"}</td>
</tr>
</table>
