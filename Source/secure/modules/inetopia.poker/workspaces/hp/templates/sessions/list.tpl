<h2>Pokerveranstaltungen</h2>
<br/>


{section name=session loop=$poker_sessions}
<fieldset>
	<legend>
		<label for="checkbox_htmlword_data"><b>{$poker_sessions[session]->name}</b></label>

	</legend>
	
	<table width="100%">
	 <tr>
	 	<td>
	 	{if $poker_sessions[session]->organiser_id}
		 	&Ouml;ffenliche Veranstaltung von <A href="{$url_file}page={$CURRENT_MODULE_ID}:organiser.info&organiser_id={$poker_sessions[session]->organiser_id}">{$poker_sessions[session]->organiser_name}</a><br/>
	 	{else}
	 		Private Veranstaltung von <A href="{$url_file}page=member.info&member_id={$poker_sessions[session]->member_id}">{$poker_sessions[session]->member_nickname}</a> <br/>
	 	{/if}
	 	
	 	Termin am {date timestamp=$poker_sessions[session]->date}, {$poker_sessions[session]->tables} Tische, {$poker_sessions[session]->max_participants} Teilnehmer <br/>
	 	<A href="">teilnehmen</a> | <A href="{$url_file}page={$CURRENT_MODULE_ID}:sessions.info&session_id={$poker_sessions[session]->session_id}">details</a>
	 	
	 	</td>
	 </tr>
	 <tr><td> <hr/></td></tr>
	</table>
</fieldset>
	{/section}
