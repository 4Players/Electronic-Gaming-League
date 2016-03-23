{literal}
<style type="text/css">
TABLE 
{BACKGROUND-REPEAT: repeat;FONT-SIZE: 11px; FONT-FAMILY: Arial, Helvetica, sans-serif;;}

TD 
{ FONT-SIZE: 13px;  FONT-FAMILY: Arial, Helvetica, sans-serif;COLOR: #000000;}
</style>
{/literal}
{if $UNKNOWN_CALCO}
<h2>DIESEN PUNKTE-RECHNER GIBT ES NICHT</h2>
{else}
<h2>{$CALCO|strtoupper}</h2>
<form action="{$url_file}page={$url_page}&calculator={$smarty.get.calculator}&a=go" method="POST">
<table cellpadding="5" cellspacing="1">
 <tr bgcolor="#F0F0F0">
	<td></td>
	<td><b>Spieler/Team A</b></td>
	<td><b>Spieler/Team B</b></td>
 </tr>
 <tr bgcolor="#E5E5E5">
	<td><b>ELO-Punkte:</b></td>
	{if isset($smarty.post.elo_points_player_a)}
		<td><input type="text" value="{$smarty.post.elo_points_player_a}" size="5" name="elo_points_player_a"/></td>
	{else}
		<td><input type="text" value="1000" size="5" name="elo_points_player_a"/></td>
	{/if}
	{if isset($smarty.post.elo_points_player_b)}
		<td><input type="text" value="{$smarty.post.elo_points_player_b}" size="5" name="elo_points_player_b"/></td>
	{else}
	<td><input type="text" value="1000" size="5" name="elo_points_player_b"/></td>
	{/if}
 </tr>
 <tr bgcolor="#E5E5E5">
	<td><b>Match Punkte:</b></td>
	<td><input type="text" value="{$smarty.post.match_points_player_a|tointeger}" size="5" name="match_points_player_a"/></td>
	<td><input type="text" value="{$smarty.post.match_points_player_b|tointeger}" size="5" name="match_points_player_b"/></td>
 </tr>
 <tr bgcolor="#F0F0F0">
	<td colspan="3" align="center"><input type="submit" value="berechnen"/></td> 
 </tr>
 <tr bgcolor="#E5E5E5">
	<td><b>Neue Punkte:</b></td>
	{if $newpoints_player_a > 0} <td><font color="#00A800"><b>{$newpoints_player_a|tointeger}</b></font></td>{/if}
	{if $newpoints_player_a < 0} <td><font color="#A80000"><b>{$newpoints_player_a|tointeger}</b></font></td>{/if}
	{if $newpoints_player_a == 0} <td><b>{$newpoints_player_a|tointeger}</b></td>{/if}
	
	{if $newpoints_player_b > 0} <td><font color="#00A800"><b>{$newpoints_player_b|tointeger}</b></font></td>{/if}
	{if $newpoints_player_b < 0} <td><font color="#A80000"><b>{$newpoints_player_b|tointeger}</b></font></td>{/if}
	{if $newpoints_player_b == 0} <td><b>{$newpoints_player_b|tointeger}</b></td>{/if}

 </tr>
 <tr bgcolor="#E5E5E5">
	<td><b>Gesamtpunkte:</b></td>
	<td><b>{$points_player_a|tointeger}</b></td>
	<td><b>{$points_player_b|tointeger}</b></td>
 </tr>
</table>
</form>
{/if}