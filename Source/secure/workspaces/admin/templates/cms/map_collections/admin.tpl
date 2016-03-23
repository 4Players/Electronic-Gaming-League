<h2>Map-Collection verwalten</h2>

{include file="cms/map_collections/header.tpl"}
<hr/>

<form action="{$url_file}page={$url_page}&collection_id={$COLLECTION->id}&a=collection" method="POST" name="f_col">
<table cellpadding="5" border="0">
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

<br/><hr/><br/>
<div>Insgesamt {$MAPS|@count} Maps eingetragen,
<font color="#A80000">zum Löschen bitte Feldname leer lassen</font>
</div>
<br/>

<form action="{$url_file}page={$url_page}&collection_id={$COLLECTION->id}&a=maps" method="POST" name="f">
<table cellpadding="5" cellspacing="1" width="100%">
{section name=newmap loop=5}
<tr bgcolor="{#clr_content#}">
	<td width="30"><font color="#00A800">NEU</font></td>
	<td><input type="text" class="egl_maps" name="map_name_new_{$smarty.section.newmap.index}" value="" style="width:400px;"/></td>
</tr>
{/section}

{section name=map loop=$MAPS}
<tr>
	<td>{$smarty.section.map.index+1}.</td>
	<td><input type="text" class="egl_maps" name="map_name_{$smarty.section.map.index}" value="{$MAPS[map]->map_name}" style="width:400px;"/></td>
</tr>
{/section}
<tr>
	<td colspan="2">{include file="buttons/bt_universal.tpl" caption="übernehmen" link="javascript:document.f.submit();"}</td>
</tr>
</table>
</form>