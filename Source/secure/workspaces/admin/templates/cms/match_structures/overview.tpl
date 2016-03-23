<h2>Match Strukturen</h2>

{include file="cms/match_structures/headermenu.tpl"}
<hr size="1"/>

{literal}
<script language="javascript"> 
	function load_bgcolor(obj, color ) { obj.style.backgroundColor 	= color;}
</script>
{/literal}
<br/>

<table width="100%" cellpadding="0" cellspacing="2" bgcolor="#C0C0C0">
 <tr><td bgcolor="#FFFFFF">

 		<table border="0" cellpadding="7" cellspacing="1" width="100%">
		 <tr bgcolor="{#clr_content_border#}">
		 	<td  colspan="1" width="1%"><img src="images/spacer.gif" width="25"/></td>
		 	<!--#<td width="150"><b>Spiel</b></td>#-->
		 	<td><b>Name</b></td>
		 	<td><b>Struktur</b></td>
		 	<td><b>Calculator</b></td>
		 	<td width="1%"></td>
		 	<td width="1%"></td>
		 </tr>
		{section name=ms loop=$match_structures}
		 {assign var="prev_gameid" value=$smarty.section.ms.index-1}
		 {if $match_structures[ms]->game_id != $match_structures[$prev_gameid]->game_id}
			<tr background="images/admin/list_header_bg" style="background-repeat:repeat-y;" bgcolor="#EAE7E0">
				<td colspan="6"><b>{section name=game loop=$games}{if $games[game]->id == $match_structures[ms]->game_id}{$games[game]->name}{/if}{/section}</b></td>
			</tr>
		 {/if}
		 <tr onclick="javascript: document.location='{$url_file}page=cms.match_structures.admin&ms_id={$match_structures[ms]->id}';" bgcolor="{#clr_content#}" onmouseover="javascript:load_bgcolor(this, '#F9F9F9');" onmouseout="javascript:load_bgcolor(this, '{#clr_content#}');">
		  	
		  	<td>{section name=game loop=$games}
		  			{if $games[game]->id == $match_structures[ms]->game_id}
		  				{if $games[game]->logo_small_file != 'non'}
		  					<A title="{$games[game]->name}" href=""><img border="0" src="{$PATH_GAMES}small/{$games[game]->logo_small_file}" width="30" height="40"/></a>
		  				{else}
		  				{/if}
		  			{/if}
		  		{/section}
		  	</td>
		  	<!--#<td>{section name=game loop=$games}{if $games[game]->id == $match_structures[ms]->game_id}{$games[game]->name}{/if}{/section}</td>#-->
		  	<td>{$match_structures[ms]->name}</td>
		  	<td>{$match_structures[ms]->num_maps} Maps, {$match_structures[ms]->num_rounds} Runden</td>
		  	<td>Noch nicht implementiert</td>
		  	<td><A title="Struktur löschen" href="{$url_file}page=cms.match_structures.admin&ms_id={$match_structures[ms]->id}&a=delete"><img border=0 src="images/edit_remove_small.gif"/></td>
		  	<td><A title="Struktur bearbeiten" href="{$url_file}page=cms.match_structures.admin&ms_id={$match_structures[ms]->id}"><img border=0 src="images/edit_small.gif"/></td>
		 </tr>
		{/section}

		{if sizeof($match_structures) == 0}
			<tr bgcolor="{#clr_content#}">
				<td colspan="5">Keine MatchStruktur vorhanden</td>
			</tr>
		{/if}
		</table>
  </td></tr>
 </table>