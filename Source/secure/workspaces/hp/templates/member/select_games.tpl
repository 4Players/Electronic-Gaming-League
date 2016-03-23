<h2>{$LNG_BASIC.c4600}</h2>

	<table border="0" align="center" width="100%" bgcolor="{#clr_content_border#}" cellpadding="4" cellspacing="1">
	<tr>
		<td colspan="2" ><b>{$LNG_BASIC.c4601}:</b></td>
	</tr>
	{section name=sgame loop=$selected_games}
		{if $smarty.section.sgame.index%2==0 }<tr bgcolor="{#clr_content#}">{/if}
		<td width="50%">	
	
			<table border="0">
			 <tr>
			 	<td>
			 		<table border="0" cellpadding="0" cellspacing="1" bgcolor="{#clr_content_border#}">
			 		 <tr><td>
			 		{if $selected_games[sgame]->logo_small_file != 'non' }
			 			<img src="{$path_games}small/{$selected_games[sgame]->logo_small_file}" width="45" height="60">
		 			{else}
			 			<img src="images/logo.na.jpg" width="45" height="60">
		 			{/if}
		 			 </td></tr>
		 			</table>
			 		
			 	</td>
			 	<td>
			 		<B>{$selected_games[sgame]->name}</b> <br/>
			 		<i>{$selected_games[sgame]->token}</i> <br/>
			 		<br/>
			 		[ 	<b><A href="{$url_file}page={$url_page}&clan_id={$clan.id}&team_id={$team.id}&game_id={$selected_games[sgame]->id}&a=remove">{$LNG_BASIC.c4602}</a> | 
			 			<A href="{$url_file}page=gameview.summary&game_id={$selected_games[sgame]->id}">{$LNG_BASIC.c4603}</a></b> ]
			 	</td>
			  </tr>
			 </table>
			 
		</td>
		{if $smarty.section.sgame.index%2==1 }</tr>{/if}
	{/section}
	{if !$selected_games[0]->id }
	<tr bgcolor="{#clr_content#}"><td colspan="2"><i>{$LNG_BASIC.c1026}</i></td></tr>
	{/if}
	</table>

<br/>
{include file="devs/hr_black.tpl" width="100%"}
<br/>

<form name="f" action="{$url_file}page={$url_page}&a=add" method="POST">
<table border="0" cellpadding="5">
 <tr>	
 	<td><b>{$LNG_BASIC.c4604}:</b></td>
 	<td>
		{if !$unselected_games[0]->id }
			<i>{$LNG_BASIC.c1212}</i>	
		{else}
	 		<select class="egl_select" name="game_id">
	 		{section name=game loop=$unselected_games}
	 			<option value="{$unselected_games[game]->id}">{$unselected_games[game]->name}</option>
		 	{/section}
		{/if}
 	</select>
	</td>
 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1210 link="javascript:document.f.submit();"}</td>
 </tr>
</table>
</form>
