<h2> Umfrage: {$poll->question} </h2>


{if $voting_already_voted}
	<font color="#A8000000"><b>Sie können für jede Umfrage nur eine Stimme abgeben</b></font>
{elseif $not_loggedin}
	<font color="#A8000000"><b>Die Abstimmung ist nur eingeloggten Mitglieder gestattet.</b></font> zum <A href="{$url_file}page=login">Login</a> oder zur <A href="{$url_file}page=signin">Anmeldung</a>.
{elseif $vote_success}
	<b>Ihre Abstimmung war erfolgreich. Vielen Dank!</b>
{/if}


{if $poll_expired} <font color="#A8000000"><b>Umfrage ist zu Ende!</b></font><br><br>{/if}