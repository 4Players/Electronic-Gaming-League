<h2>{$game->name}</h2>
{include file="devs/hr_black.tpl" width="100%"}
<table border="0" cellpadding="0" cellspacing="0" width="95%" align="center">
 <tr>
 	<td width="70%" valign="top">
 		
 	
 		<table border="0" width="100%">
		 <tr>
 		 	<td width="30%"> <b>Kürzel: </b> </td>
 		 	<td> <b>{$game->token} </b> </td>
 		 </tr>
		 <tr>
 		 	<td width="30%"> <b>Homepage: </b> </td>
 		 	<td> <b> {hp url=$game->hp} </b> </td>
 		 </tr>
		 <tr>
 		 	<td colspan="2"> <br><br> <b>Beschreibung:</b> </td>
 		 </tr>
 		 <tr>
 		 	<td colspan="2"> 
		 		 {if $game->logo_small_file != 'non'}
		 		 	<img align="right" src="{$path_games}small/{$game->logo_small_file}" width="150" height="200">
		 		 {else}
		 		 	<img align="right" src="images/logo.na.jpg" width="150" height="200">
		 		 {/if}
	 		 	{$game->description|nl2br} </td>
 		 </tr>
 		</table>
 	
</td>
 </tr>
</table>