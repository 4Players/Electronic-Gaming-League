<h2>Übersicht</h2>


<table cellpadding="5" border="0">
 <tr>
 	<td><img src="images/admin/folder_opened.gif"/></td>
 	<td><b>Moduleübersicht</b></td>
 </tr>
</table>
	
<br/>

<table width="100%" border="0">
 <tr><td valign="top">
 	<!--# CONTENT #-->
 	
	<table cellpadding="0" cellspacing="0" width="500">
	 <tr>
	 	<td><b>Aktivierte Module:</b></td>
	 </tr>
	 <tr>
	 	<td background="images/admin/category_splitline.gif" style="background-repeat:no-repeat;"><img src="images/spacer.gif" height="5"/></td>
	 </tr>
	 <tr>
		<td>
			<table cellpadding="10"><tr>
			 {section name=mod loop=$modules_activated}
			 	<td align="center">
			 		<img src="images/admin/navi/cmod_overview.gif" /><br/>
			 		<div>
			 			<a href="">{$modules_activated[mod].data->sName|strip_tags|stripslashes}</a>
			 		</div>
			 	</td>
			 {/section}
			</tr></table>
		</td>
	 </tr>	 
	</table>
	<br/><br/>
	
	
	
	<table cellpadding="0" cellspacing="0" width="500">
	 <tr>
	 	<td><b>Installierte Module:</b></td>
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
 
  	<!---#
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
 	#-->
 
 </td>
</tr></table>