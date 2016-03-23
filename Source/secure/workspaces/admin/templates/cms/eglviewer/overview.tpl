<h2>EGL Viewer</h2>

{literal}
<script language="javascript"> 
	function load_bgcolor(obj, color ) { obj.style.backgroundColor 	= color;}

	function change_image_src( obj, pic ){obj.src = pic;}
</script>
{/literal}


{if $CatRoot->oProperties->id != -1}
	<table cellpadding="5" border="0">
	 <tr>
	 	<td><img src="images/admin/folder_opened.gif"/></td>
	 	<td ><b>{$CatRoot->oProperties->name}</b><br/>
			<table cellpadding="2" border="0"><tr>
			 <td align="center"><A title="EGL-ROOT" href="{$url_file}page={$url_page}&cat_id=-1">Root</a></td> <td align="center"><b>	&raquo;</b></td>
			{section name=path loop=$path}
				<td align="center"><A title="{$path[path]->name}" href="{$url_file}page={$url_page}&cat_id={$path[path]->id}">{$path[path]->name}</a></td> {if !$smarty.section.path.last}<td align="center"><b>&raquo;</b></td>{/if}
			{/section}
			</tr></table>
	 	
	 	</td>
	 </tr>
	</table>
{else}

	<table cellpadding="5" border="0">
	 <tr>
	 	<td><img src="images/admin/folder_opened.gif"/></td>
	 	<td><b>EGL_ROOT</b></td>
	 </tr>
	</table>
	
{/if}

<br/>
	
<table width="100%" border="0">
 <tr><td valign="top">
 	<!--# CONTENT #-->
 	
	<table cellpadding="0" cellspacing="0" width="500">
	 <tr>
	 	<td><b>In diesem Kategorie gibt es weitere Unterkategorien:</b></td>
	 </tr>
	 <tr>
	 	<td background="images/admin/category_splitline.gif" style="background-repeat:no-repeat;"><img src="images/spacer.gif" height="5"/></td>
	 </tr>
	</table>
		{include file="cms/eglviewer/view_folder.tpl" root_tree=$CatRoot cats_per_line="5" options="true"}
	<br/><br/>
	
	<table cellpadding="0" cellspacing="0" width="500">
	 <tr>
	 	<td><b>Zu dieser Kategorie gehören folgende Elemente:</b></td>
	 </tr>
	 <tr>
	 	<td background="images/admin/category_splitline.gif" style="background-repeat:no-repeat;"><img src="images/spacer.gif" height="5"/></td>
	 </tr>
	 <tr>
	 	<td> <table><tr><td>Keine Implementierung vorhanden.</td></tr></table> </td>
	 </tr>
	</table>
	
 </td>
 <td valign="top" width="200">
  	<!--# RIGHT-MENU #-->
 
  	<table border="0" width="250" cellpadding="0" cellspacing="0">
	 <tr><td background="images/admin/catbox/top.gif" style="background-repeat:no-repeat"><img src="images/spacer.gif" width="250" height="28"/></td></tr>
  	 <tr>
  	 	<td background="images/admin/catbox/middle.gif" style="background-repeat:repeat-y;">
  	 	<table width="100%" cellpadding="3" align="center"><tr><td>
  	 	
			<table width="100%" bgcolor="#E1DACB" cellpadding="4">
			 <tr><td><b>Weitere Funktionen</td></tr>
			</table>
			<br/>
	 		
	 		<form method="POST" action="{$url_file}page={$url_page}&cat_id={$CAT_ID}&a=newcat">
		  	<table width="100%">
		  	 <tr onClick="if (newcat.style.display == 'none') newcat.style.display = 'block'; else newcat.style.display = 'none';"><td width="1%"><img src="images/admin/folder_add.gif"/></td><td><A href="#"><b>Neue Kategorie</b></a></td></tr>
		  	 <tr><td colspan="2">
		  	 <div id="newcat" style="display:none;">
		  	 	<table width="100%">
		  	 		<tr>
		  	 			<td width="1%">Name:&nbsp;</td>
		  	 			<td width="1%"><input name="cat_name" type="text" size="15" class="egl_text"/></td>
		  	 			<td><input type="submit" size="15" class="egl_button" value=" GO "/></td>
		  	 		</tr>
		  	 	</table>
			  	<hr/>
		  	 </div>
		  	 </td></tr>
		  	</table>
		  	</form>


		  </td></tr></table>
		 </td></tr>
		 <tr><td background="images/admin/catbox/bottom.gif" style="background-repeat:no-repeat"><img src="images/spacer.gif" width="250" height="27"/></td></tr>
		</td></tr>
	</table>  	 	
 
 
 </td>
</tr></table>