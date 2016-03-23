<h2>Map-Collections</h2>
{include file="cms/map_collections/header.tpl"}
<hr/>

<table>
{section name=Y loop=10}
	<tr>
	{section name=X loop=5}
		{capture name="list_index"}{math equation="Y*5+X" X=$smarty.section.X.index Y=$smarty.section.Y.index}{/capture}
		{if $MAP_COLLECTIONS[$smarty.capture.list_index]}
		<td>
			<table width="200" style="border:medium dotted #FFA400; border-width:2px; background-color:#FFFDFA;"
				   onmouseover="this.style.backgroundColor='#FFECD0';"
				   onmouseout="this.style.backgroundColor='#FFFDFA';">
			 <tr>
			 	<td onclick="javascript:document.location.href='{$url_file}page=cms.map_collections.admin&collection_id={$MAP_COLLECTIONS[$smarty.capture.list_index]->id}';">
				<a href="{$url_file}page=cms.map_collections.admin&collection_id={$MAP_COLLECTIONS[$smarty.capture.list_index]->id}"><b>{$MAP_COLLECTIONS[$smarty.capture.list_index]->name}</b></a>
				<br/>
				Anz. Maps: {$MAP_COLLECTIONS[$smarty.capture.list_index]->num_maps}
			 	</td>
			 	<td width="50">
			 		{if $MAP_COLLECTIONS[$smarty.capture.list_index]->game_id > 0}
				 		<img style="border-color:black;" width="50" height="70" src="{$PATH_GAMES}small/{$MAP_COLLECTIONS[$smarty.capture.list_index]->game_logo}"/>
				 	{/if}
			 	</td>
			 </tr>
			</table>
		</td>
		{/if}
	{/section}
	</tr>
{/section}
</table>