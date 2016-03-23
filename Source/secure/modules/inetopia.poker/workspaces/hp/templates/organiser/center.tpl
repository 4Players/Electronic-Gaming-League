<h2>Veranstalter Zentrum `{$organiser->name|strip_tags|stripslashes}`</h2>

<table width="100%">
 <tr><td valign="top">
	<A href="">Mitarbeiter</a> <br/>
	<A href="">Aufgabgenverteilung</a> <br/>
	<A href="">Pokersession Übersicht</a> <br/>
	<A href="">Neue Pokersession</a> <br/>
	<br/>
	<A href="">Rundmail</a> <br/>
	
 </td><td valign="top">
	<b>Letzte Veranstaltungen:</b> <br/>
	{section name=ls loop=$org_sessions}
		<A href="{$url_file}page=organiser.sessions.center&session_id={$org_sessions[ls]->id}">{$org_sessions[ls]->name}</a> <br/>
	{/section}
 </td></tr>
</table>
 