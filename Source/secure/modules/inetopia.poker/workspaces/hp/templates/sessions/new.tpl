{include file="devs/message.tpl"}

<h2>Poker Veranstaltung erstellen</h2>

<form name="f" action="{$url_file}page={$url_page}&a=create" method="post">
<table>
 <tr>
 	<td><b>Name:</b></td>
 	<td><input name="name" type="text"/></td>
 </tr>
 <tr>
 	<td><b>Tische:</b></td>
 	<td><input name="tables" type="text" value="1"/></td>
 </tr>
 <tr>
 	<td><b>Spielerzahl:</b></td>
 	<td><input name="max_players" type="text" value="6"/></td>
 </tr>
 <!--#
 <tr>
 	<td><b>Veranstalter:</b></td>
 	<td><select name="organiser_id">
 			<option value="-1">Privat</option>
 			{section name=orga loop=$organiser}
	 			<option value="{$organiser[orga]->id}">{$organiser[orga]->name}</option>
 			{/section}
 		</select>
	</td>
 </tr>
 #-->
 <tr>
 	<td><b>Anmeldung nur via Einladung:</b></td>
 	<td>..</td>
  </tr>
 <tr>
 	<td><b>Termin:</b></td>
 	<td><input name="date" type="text" value="Heute"/></td>
 </tr>
 <tr>
 	<td><b>Ort:</b></td>
 	<td><input name="city" type="text"/></td>
 </tr>
 <tr>
 	<td><b>PLZ:</b></td>
 	<td><input name="plz" type="text"/></td>
 </tr>
 <tr>
 	<td><b>Straﬂe:</b></td>
 	<td><input name="street" type="text"/></td>
 </tr>
 <tr>
 	<td><b>Beschreibung:</b></td>
 	<td><textarea name="description"></textarea></td>
 </tr>
 <tr>
  <td colspan="2">
  		{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="anmelden" link="javascript:document.f.submit();"}
  </td>
 </tr>
</table>
</form>