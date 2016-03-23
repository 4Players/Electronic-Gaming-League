<script language="javascript" src="javascript/browser_handling"></script>
<table>
 <tr>
 	<td><A href="{$url_file}page=cms.eglviewer.folder_edit&cat_id={$CatRoot->oProperties->id}&work_catid={$properties->id}&a=deletecat" title="Kategorie editieren"><img border="0" src="images/admin/edit_small.gif"/></a></td>
 	<td><A href="javascript: MessageCheckAction('Soll die Kategorie wirklich gelöscht werden?', '{$url_file}page=cms.eglviewer.overview&cat_id={$cat_id}&work_catid={$properties->id}&a=deletecat');" title="Kategorie löschen"><img border="0" src="images/admin/remove_small.gif"/></a></td>
 </tr>
</table> 