<h2>Aktuelle gewählte Umfrage</h2>
{include file="devs/hr2.tpl" width="100%"}
{if isset($curr_poll)}

	{if $curr_poll->stopped}
		<div align="center"><table><tr><td><font color="#A80000"><b>Umfrage gestoppt!</b></font></td></tr></table></div>
	{/if}
	
	{if strlen($curr_poll->text)}
		<table width="100%" cellpadding="10" align="center">
		 <tr><td align="center">
				<table border="0" width="100%" cellpadding="5" cellspacing="1">
				<tr bgcolor="{#clr_content_border#}">
					<td><b>Zugehöriger Text</b></td>
				 </tr>
				 <tr bgcolor="{#clr_content#}">
				 	<td>{$curr_poll->text|strip_tags|stripslashes}</td>
				 </tr>
				</table>
		 	</td></tr>
		</table>				
	{/if}
		{if !$curr_poll->stopped && $smarty.const.EGL_TIME > $curr_poll->start_time && $smarty.const.EGL_TIME < $curr_poll->end_time &&
		!$already_voted }
		{if $_get.a == "show_results"}
			{include file="`$page_dir`/results.tpl" poll=$curr_poll answers=$curr_poll_answers}
		{/if}
		<form name="fpoll" method="POST" action="{$url_file}page={$CURRENT_MODULE_ID}:vote&poll_id={$curr_poll->id}&game_id={$game->id}&a=voting">
		<table width="100%" cellpadding="10" align="center">
		 <tr>
		 	<td align="center">
		 		<table border="0" width="100%" cellpadding="5" cellspacing="1">
		 		 <tr bgcolor="{#clr_content_border#}">
		 		 	<td colspan="2"><b>Umfrage: &nbsp;{$curr_poll->question|strip_tags|stripslashes}</b></td>
		 		 </tr>
		 		 {section name=ans loop=$curr_poll_answers}
		 		 <tr bgcolor="{#clr_content#}">
		 		 	<td width="10"><input type="radio" name="poll_vote_{$curr_poll->id}" value="{$curr_poll_answers[ans]->id}"/></td>
		 		 	<td>{$curr_poll_answers[ans]->answer|strip_tags|stripslashes}</td>
		 		 </tr>
		 		 {/section}
		 		 <tr>
		 		 	<td align="center" colspan="2">
		 		 		<table><tr>
		 		 		<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Vote" link="javascript:document.fpoll.submit();"}</td>
				 		{if $curr_poll->stopped}
				 			<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Ergebnisse" link="`$url_file`page=`$url_page`&poll_id=`$curr_poll->id`&game_id=`$game->id`&&a=show_results"}</td>
			 		 	{else}
			 		 		{if $curr_poll->show_results}
			 		 			<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Ergebnisse" link="`$url_file`page=`$url_page`&poll_id=`$curr_poll->id`&game_id=`$game->id`&&a=show_results"}</td>
			 		 		{/if}
			 		 	{/if}
		 		 		</tr></table>
		 		 	</td>
		 		 </tr>
		 		</table>
		 		Insgesamt {$curr_poll->num_hits} Stimmen
		 	</td>
		 </tr>
		</table>
		</form>
	{else}
		{include file="`$page_dir`/results.tpl" poll=$curr_poll answers=$curr_poll_answers}
	{/if}
	
{else}
	Keine Umfragen vorhanden
{/if}

<br/><br/>
{if isset($game)}
<h2>Weitere Umfragen zum Spiel {$game->name}</h2>
{else}
<h2>Weitere Allgemeine Umfragen</h2>
{/if}
{include file="devs/hr2.tpl" width="100%"}
{if sizeof($polls) > 0}
<table width="100%">
 <tr>
   <td>
		<table border="0" cellpadding="0" cellspacing="10">
		{section name=p loop=$polls}
		 <tr>
		 	<td><A href="{$url_file}page={$url_page}{if isset($game)}&game_id={$game->id}{/if}&poll_id={$polls[p]->id}"><b>&sdot;</b> {$polls[p]->question}</a> ({date timestamp=$polls[p]->start_time}) {if $polls[p]->stopped}<font color="#A80000"><b>*Gestoppt*</b></font>{/if} </td>
		 </tr>
		{/section}
		</table>
   </td>
 </tr>
</table>
{else}
Keine Weiteren Umfragen vorhanden
{/if}

<br/><br/><br/>


<h2>Weitere Kategorien</h2>
{include file="devs/hr2.tpl" width="100%"}
<table width="100%" cellpadding="5">
<tr>
	<td></td>
	<td align="center"><A href="{$url_file}page={$url_page}">Allgemein</a></td>
	<td></td>
</tr>
{section name=game loop=$games step=3}
 <tr>
 	<td  align="center"><A href="{$url_file}page={$url_page}&game_id={$games[game]->id}">{$games[game]->name}</a></td>
 	{assign var="index" value=$smarty.section.game.index+1}
 	<td  align="center"><A href="{$url_file}page={$url_page}&game_id={$games[$index]->id}">{$games[$index]->name}</a></td>
 	{assign var="index" value=$smarty.section.game.index+2}
 	<td  align="center"><A href="{$url_file}page={$url_page}&game_id={$games[$index]->id}">{$games[$index]->name}</a></td>
 </tr>
{/section}
</table>