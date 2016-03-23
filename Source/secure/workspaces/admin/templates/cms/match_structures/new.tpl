<h2>Match-Struktur hinzufügen</h2>
{include file="cms/match_structures/headermenu.tpl"}
<hr/>{include file="etc/message.tpl"}

{if $success}

{else}
<form action="{$url_file}page={$url_page}&a=add_structure" method="POST">
<table width="100%" cellpadding="20" >
 <tr><td>
	<table width="100%" cellpadding="0" cellspacing="2" bgcolor="#C0C0C0">
	<tr><td bgcolor="#FFFFFF">
	
		<table border="0" cellpadding="5" cellspacing="1" width="100%" >
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Spiel:</b></td>
		 	<td><select class="egl_select" name="game_id">
				{section name=game loop=$games}
		 			<option value="{$games[game]->id}">{$games[game]->name|strip_tags|stripslashes}</option>
		 		{/section}
		 		</select>
		 	</td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Name:</b></td>
		 	<td><input type="text" class="egl_text" name="name" size="35" value="Unbekannt" onclick="javascript: if( this.value == 'Unbekannt' )this.value='';"/></td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Anz. Maps:</b></td>
		 	<td><input type="text" class="egl_text" name="num_maps" value="2"/></td>
		 </tr>
		 <!--
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Anz. Runden pro Map:</b></td>
		 	<td><input type="text" class="egl_text" name="num_rounds" value="1"/></td>
		 </tr>
		 -->
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Maps:</b></td>
		 	<td>
		 		<table cellpadding="0" cellspacing="0">
		 		 <tr>
		 		 	<td><input type="text" name="map1" class="egl_text"/></td>
		 		 </tr>
		 		 <tr>
		 		 	<td><input type="text" name="map2" class="egl_text"/></td>
		 		 </tr>
		 		 <tr>
		 		 	<td><input type="text" name="map3" class="egl_text"/></td>
		 		 </tr>
		 		 <tr>
		 		 	<td><input type="text" name="map4" class="egl_text"/></td>
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
				<input type="checkbox" class="egl_cbeckbox" name="fixed"/>Match fixieren
			</td>
		 </tr> 			 
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Runden:</b></td>
		 	<td>
		 		<table cellpadding="0" cellspacing="0">
		 		 <tr>
		 		 	<td><b>Challenger</b></td>
		 		 	<td><img src="images/spacer.gif" width="20"/></td>
		 		 	<td><b>Opponent</b></td>
		 		 </tr>
		 		 <tr>
		 		 	<td><input type="text" name="round1_challenger" class="egl_text"/></td>
		 		 	<td></td>
		 		 	<td><input type="text" name="round1_opponent" class="egl_text"/></td>
		 		 </tr>
		 		 <tr>
		 		 	<td><input type="text" name="round2_challenger"  class="egl_text"/></td>
		 		 	<td></td>
		 		 	<td><input type="text" name="round2_opponent" class="egl_text"/></td>
		 		 </tr>
		 		 <tr>
		 		 	<td><input type="text" name="round3_challenger"  class="egl_text"/></td>
		 		 	<td></td>
		 		 	<td><input type="text" name="round3_opponent" class="egl_text"/></td>
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

 </td></tr>
</table>
{/if}