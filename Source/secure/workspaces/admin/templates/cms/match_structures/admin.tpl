<h2>Match Struktur bearbeiten</h2>
{include file="cms/match_structures/headermenu.tpl"}
<hr/>
{include file="etc/message.tpl"}
{if $success}

{else}
<form action="{$url_file}page={$url_page}&ms_id={$matchstructure->id}&a=change_structure" method="POST">
<table width="100%" cellpadding="20" >
 <tr><td>
	<table width="100%">
	 <tr><td>
		<br/><br/>
		<table width="100%" cellpadding="0" cellspacing="2" bgcolor="#C0C0C0">
		<tr><td bgcolor="#FFFFFF">
			<table border="0" cellpadding="5" cellspacing="1" width="100%" >
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Spiel:</b></td>
			 	<td><select class="egl_select" name="game_id" style="width:100%;">
					<option value="-1">Bitte wählen</option>
					{section name=game loop=$games}
						{if $games[game]->id == $matchstructure->game_id}
							<option selected value="{$games[game]->id}">{$games[game]->name}</option>
						{else}
							<option value="{$games[game]->id}">{$games[game]->name}</option>
						{/if}
			 		{/section}
			 		</select>
			 	</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Name:</b></td>
			 	<td><input style="width:100%;" type="text" class="egl_text" name="name" value="{$matchstructure->name}" onclick="javascript: if( this.value == 'Unbekannt' )this.value='';"/></td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Anz. Maps:</b></td>
			 	<td><input type="text" class="egl_text" name="num_maps" value="{$matchstructure->num_maps}"/></td>
			 </tr>
			 <!--#
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Anz. Runden pro Map:</b></td>
			 	<td><input type="text" class="egl_text" name="num_rounds" value="{$matchstructure->num_rounds}"/></td>
			 </tr>
			 #-->
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Maps:</b></td>
			 	<td>
			 		<table cellpadding="0" cellspacing="1">
			 		{section name=tmp loop=$ms_template}
			 		 <tr>
			 		 	<td><input type="text" name="map{$smarty.section.tmp.index}" class="egl_text" value="{$ms_template[tmp]->map_name}"/></td>
			 		 </tr>
			 		 {/section}
			 		 <tr>
			 		 	<td><input type="text" name="map{$smarty.section.tmp.index}" class="egl_text"/></td>
			 		 </tr>
			 		 <tr>
			 		 	<td><input type="text" name="map{$smarty.section.tmp.index+1}" class="egl_text"/></td>
			 		 </tr>
			 		</table> 	
			 	</td>
			 </tr>

			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Map-Collection:</b></td>
				<td>
					<select name="mapcollection_id" class="egl_select" style="width:100%;">
							<option value="-1">Keine Map-Collection ausgewählt</option>
							{section name=map loop=$MAP_COLLECTIONS}
								<option {if $matchstructure->mapcollection_id == $MAP_COLLECTIONS[map]->id}selected{/if} value="{$MAP_COLLECTIONS[map]->id}">{$MAP_COLLECTIONS[map]->name|strip_tags|stripslashes}</option>
							{/section}
					 </select>
				</td>	 
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Report-Type:</b></td>
				<td>
				{if $matchstructure->fixed == 1}
					<input type="checkbox" class="egl_cbeckbox" checked value="1" name="fixed"/>Match fixieren
				{else}
					<input type="checkbox" class="egl_cbeckbox" value="1" name="fixed"/>Match fixieren
				{/if}
				</td>
			 </tr> 			 
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Runden:</b></td>
			 	<td>
			 		<table cellpadding="0" cellspacing="1">
			 		 <tr>
			 		 	<td><b>Challenger</b></td>
			 		 	<td><img src="images/spacer.gif" width="20"/></td>
			 		 	<td><b>Opponent</b></td>
			 		 </tr>
			 		 {section name=rnd loop=$ms_template[0]->aRounds}
			 		 <tr>
			 		 	<td><input type="text" name="round{$smarty.section.rnd.index}_challenger" class="egl_text" value="{split_str str=$ms_template[0]->aRounds[rnd]->round_name char='#' item='0'}"/></td>
			 		 	<td></td>
			 		 	<td><input type="text" name="round{$smarty.section.rnd.index}_opponent" class="egl_text" value="{split_str str=$ms_template[0]->aRounds[rnd]->round_name char='#' item='1'}"/></td>
			 		 </tr>
			 		 {/section}
			 		 <tr>
			 		 	<td><input type="text" name="round{$smarty.section.rnd.index}_challenger"  class="egl_text"/></td>
			 		 	<td></td>
			 		 	<td><input type="text" name="round{$smarty.section.rnd.index}_opponent" class="egl_text"/></td>
			 		 </tr>
			 		 <tr>
			 		 	<td><input type="text" name="round{$smarty.section.rnd.index+1}_challenger"  class="egl_text"/></td>
			 		 	<td></td>
			 		 	<td><input type="text" name="round{$smarty.section.rnd.index+1}_opponent" class="egl_text"/></td>
			 		 </tr>
			 		</table>
			 	
			 	</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td></td> 
			 	<td><input type="image" src="images/buttons/new/bt_send.gif"/></td> 
			 </tr>
			</table>
		
		</td></tr>
	 </table>

	</td>
	<td width="200" valign="top" bgcolor="#FFFFFF">
			<table width="300">
			 <tr><td><b>Vorschau</b><br/><br/>{include file="cms/match_structures/match_preview.tpl"}</td></tr>
			</table>		
	</td></tr>
	</table>

 </td></tr>
</table>

{/if}