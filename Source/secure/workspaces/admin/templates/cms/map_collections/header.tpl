<table cellpadding="5">
 <tr>
	<td align="center"><a href="{$url_file}page=cms.map_collections.overview"><img border="0" src="images/b_mapcollection_overview.gif"/></a></td>
	<td align="center"><a href="{$url_file}page=cms.map_collections.add"><img border="0" src="images/b_mapcollection_add.gif"/></a></td>
	{if isset($smarty.get.collection_id)}
		<td align="center"><a href="{$url_file}page={$url_page}&collection_id={$smarty.get.collection_id}&a=delete"><img border="0" src="images/b_mapcollection_delete.gif"/></a></td>
	{/if}
 </tr>
 <tr>
 	<td align="center"><b>Übersicht</b></td>
 	<td align="center"><b>Collection anlegen</b></td>
 	{if isset($smarty.get.collection_id)}<td align="center"><b>Collection löschen</b></td>{/if}
 </tr>
</table>
