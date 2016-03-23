<table><tr>
<td>{include file="buttons/bt_universal.tpl" caption="Zentrale" 	link="`$url_file`page=cms.team.central&team_id=`$team->id`"}</td>
<td>{include file="buttons/bt_universal.tpl" caption="Profil" 		link="`$url_file`page=cms.team.profile&team_id=`$team->id`"}</td>
<td>{include file="buttons/bt_universal.tpl" caption="Mitglieder" 	link="`$url_file`page=cms.team.permissions&team_id=`$team->id`"}</td>
<td>{include file="buttons/bt_universal.tpl" caption="Löschen" 		link="`$url_file`page=cms.team.delete&team_id=`$team->id`"}</td>
</tr>
<tr>
	<td>{include file="buttons/bt_universal.tpl" caption="Ligabetriebe" link="`$url_file`page=cms.team.leagues&team_id=`$team->id`"}</td>
</tr>
</table>