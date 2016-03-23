<h2>Map-Collection anlegen</h2>

{include file="cms/map_collections/header.tpl"}
<hr/>

<form action="{$url_file}page={$url_page}&collection_id={$COLLECTION->id}&a=add" method="POST" name="f_col">
<table cellpadding="5">
 <tr>
 	<td><b>Name:</b></td>
 	<td><input type="text" name="name" style="width:300px;" value="{$COLLECTION->name|strip_tags|stripslashes}"/></td>
 </tr>
 <tr>
 	<td><b>Spiel:</b></td>
 	<td><select class="egl_select" style="width:300px;" name="game_id">
 		<option value="-1">Nicht Spielspezifisch</option>
 	{section name=game loop=$GAMES}
 		<option {if $GAMES[game]->id == $COLLECTION->game_id}selected{/if} value="{$GAMES[game]->id}">{$GAMES[game]->name}</option>
 	{/section}
 	</select>
 	</td>
 </tr>
 <tr>
 	<td colspan="2">{include file="buttons/bt_universal.tpl" caption="übernehmen" link="javascript:document.f_col.submit();"}</td>
 </tr>
</table>
</form>
