<h2>News</h2>
<b>Kategorien</b>
{include file="etc/message.tpl"}

<script language="JavaScript" type="text/javascript" src="javascript/detail_window.js"></script>
{literal}
<script language="javascript"> 
	function load_bgcolor(obj, color ) { obj.style.backgroundColor 	= color;}

	function change_image_src( obj, pic ){obj.src = pic;}
</script>
{/literal}


{if $newscategories->oProperties->id != -1}
	<table cellpadding="5" border="0">
	 <tr>
	 	<td><img src="images/admin/folder_opened.gif"/></td>
	 	<td ><b>{$newscategories->oProperties->name}</b><br/>
			<table cellpadding="2" border="0"><tr>
			<td align="center"><A title="EGL-ROOT" href="{$url_file}page={$url_page}&cat_id=-1">Root</a></td> <td align="center"><b>&raquo;</b></td>
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
	 	<td><b>News Root</b></td>
	 </tr>
	</table>
	
{/if}

<!--#
<table width="">
 <tr>
 	<td><img src="images/admin/folder_back.gif"/></td>
 	<td><img src="images/admin/folder_forward.gif"/></td>
 </tr>
</table>
#-->

<br/>
	
<table width="100%" border="0">
 <tr><td valign="top">
 	<!--# CONTENT #-->
 	
 	{if sizeof($newscategories->aNodes)}
	<table cellpadding="0" cellspacing="0" width="500">
	 <tr>
	 	<td><b>In dieser Kategorie gibt es weitere Unterkategorien:</b></td>
	 </tr>
	 <tr>
	 	<td background="images/admin/category_splitline.gif" style="background-repeat:no-repeat;"><img src="images/spacer.gif" height="5"/></td>
	 </tr>
	</table>
	 
	{include file="cms/eglviewer/view_folder.tpl" root_tree=$newscategories cats_per_line="5" options="false"}
	{/if}
	
	<br/><br/>
	
	{if sizeof($categorynews)}
	<table cellpadding="0" cellspacing="0" width="500">
	 <tr>
	 	<td><b>Zu dieser Kategorie gehören folgende letzten News (letzten 100):</b> [ <A href="{$url_file}page={$CURRENT_MODULE_ID}:archive&cat_id={$newscategories->oProperties->id}">Archiv</a> ]</td>
	 </tr>
	 <tr>
	 	<td background="images/admin/category_splitline.gif" style="background-repeat:no-repeat;"><img src="images/spacer.gif" height="5"/></td>
	 </tr>
	 <tr>
	 	<td valign="top"> 
	
	 	{assign var="cats_per_line" value="6"}
	  	{capture assign="cat_lines"}{compute_lines array=$categorynews items_per_line=$cats_per_line}{/capture}
		<table border="0" cellpadding="10">
		   {section name=y loop=$cat_lines}
			 <tr>
			   {section name=x loop=$cats_per_line}
			   {assign var="index" value=$smarty.section.y.index*$cats_per_line+$smarty.section.x.index}
			   {if $index < sizeof($categorynews) }
				<td valign="top" align="center">
					
						{capture assign="news_date"}{date timestamp=$categorynews[$index]->created format="%d.%m.%y"}{/capture}
						{capture assign="today_date"}{date timestamp=$smarty.const.EGL_TIME format="%d.%m.%y"}{/capture}
					
						{if $news_date == $today_date}<A href="{$url_file}page={$CURRENT_MODULE_ID}:admin&cat_id={$newscategories->oProperties->id}&news_id={$categorynews[$index]->id}"><img border="0" onmousemove="javascript:detailwindow_showdiv('dwindow{$categorynews[$index]->id}');" onmouseout="javascript:detailwindow_hidediv('dwindow{$categorynews[$index]->id}');" src="images/admin/news_today.gif"/></a>{/if}
						{if $news_date != $today_date}<A href="{$url_file}page={$CURRENT_MODULE_ID}:admin&cat_id={$newscategories->oProperties->id}&news_id={$categorynews[$index]->id}"><img border="0" onmousemove="javascript:detailwindow_showdiv('dwindow{$categorynews[$index]->id}');" onmouseout="javascript:detailwindow_hidediv('dwindow{$categorynews[$index]->id}');" src="images/admin/news.gif"/></a>{/if}
						<br/><b>{cutstr text=$categorynews[$index]->title num=20}</b> <br/>
				</td>
				{/if}
				{/section}
			 </tr>
			{/section}
		</table>		 	 
		 	 
		 	 
	 	</td>
	 </tr>
	</table>
	{/if}
	
 </td>
 <td valign="top" width="200">
  	<!--# RIGHT-MENU #-->
 
  	<table border="0" width="250" cellpadding="0" cellspacing="0">
	 <tr><td background="images/admin/catbox/top.gif" style="background-repeat:no-repeat"><img src="images/spacer.gif" width="250" height="28"/></td></tr>
  	 <tr>
  	 	<td background="images/admin/catbox/middle.gif" style="background-repeat:repeat-y;">
  	 	<table width="100%" cellpadding="3" align="center"><tr><td>
  	 	
			<table width="100%" bgcolor="#E1DACB" cellpadding="4">
			 <tr><td><b>Weitere Funktionen zu dieser Kategorie</td></tr>
			</table>
			<br/>
	 		
	 		
		  	<table width="100%">
		  	 <tr onClick="if (newsadmin.style.display == 'none') newsadmin.style.display = 'block'; else newsadmin.style.display = 'none';"><td width="1%"><img src="images/admin/newsadmin.gif"/></td><td><A href="#"><b>Administratoren</b></a></td></tr>
		  	 <tr><td colspan="2">
		  	 <div id="newsadmin" style="display:none;">
		  	 
		  	 <form method="POST" action="{$url_file}page={$url_page}&cat_id={$newscategories->oProperties->id}&a=add_admin">
		  	 	<table width="100%">
		  	 	  <tr>
		  	 		<td><b>Eingetragene Admins:</b></td>
		  	 	  </tr>
		  	 	  <tr>
		  	 	  	<td>
					 	{section name=catadmin loop=$categoryadmins}
					 		<A title="Mehr Informationen?" href="{$url_file}page=cms.member.central&member_id={$categoryadmins[catadmin]->member_id}">{$categoryadmins[catadmin]->nick_name|strip_tags|stripslashes}</a>[ <A title="Admin entfernen" href="{$url_file}page={$url_page}&cat_id={$newscategories->oProperties->id}&permission_id={$categoryadmins[catadmin]->id}&a=delete_admin"><img border="0" src="images/admin/button_cancel_small.gif"/></a> ]
					 		{if !$smarty.section.catadmin.last},{/if}
					 	{/section}
					 	{if sizeof($categoryadmins)==0}Keine{/if}		  	 	  	
		  	 	  	</td>
		  	 	  </tr>
		  	 	</table>
		  	 		
		  	 		
		  	 	<table width="100%">
		  	 		<tr>
		  	 			<td colspan="2"><b>Admin hinzufügen:</b></td>
		  	 		</tr>
		  	 		<tr>
		  	 			<td>Kategorie:</td>
						{if $newscategories->oProperties->id != -1}<td>{$newscategories->oProperties->name}</td>
						{else}<td>News Root</td>{/if}
		  	 		</tr>
		  	 		<tr>
		  	 			<td>Rechte:</td>
		  	 			<td>schreiben / editieren</td>
		  	 		</tr>
		  	 		<tr>
		  	 			<td></td>
		  	 			<td>
		  	 				<select name="admin_id" class="egl_select" style="width:100%;">
		  	 				{section name=admin loop=$adminlist}
		  	 					<option value="{$adminlist[admin]->id}">{$adminlist[admin]->nick_name|strip_tags|stripslashes}</option>
		  	 				{/section}
		  	 				</select>
		  	 			</td>
		  	 		</tr>
		  	 		<tr>
		  	 			<td></td>
		  	 			<td><input type="submit" size="15" class="egl_button" value=" Rechte vergeben "/></td>
		  	 		</tr>
		  	 		<tr>
		  	 			
		  	 		</tr>
		  	 	</table>
		  	 </form>
			  	<hr/> 
		  	 </div>
		  	 </td></tr>
		  	 <tr><td width="1%"><img src="images/modules/inetopia_news/admin/add.gif"/></td><td><A href="{$url_file}page={$CURRENT_MODULE_ID}:create&cat_id={$newscategories->oProperties->id}"><b>News schreiben</b></a></td></tr>
		  	 <tr onClick="if (newcat.style.display == 'none') newcat.style.display = 'block'; else newcat.style.display = 'none';"><td width="1%"><img src="images/modules/inetopia_news/admin/admin.gif"/></td><td><A href="#"><b>Kurze News schreiben</b></a></td></tr>
		  	 <tr><td colspan="2">
		  	 <form method="POST" action="{$url_file}page={$url_page}&cat_id={$newscategories->oProperties->id}&a=createnews">
		  	 <div id="newcat" style="display:none;">
		  	 	<table width="100%">
		  	 		<tr>
		  	 			<td>Kategorie:</td>
		  	 			<td>{$newscategories->oProperties->name}</td>
		  	 		</tr>
		  	 		<tr>
		  	 			<td>Uhrzeit:</td>
		  	 			<td>{date}</td>
		  	 		</tr>
		  	 		<tr>
		  	 			<td width="1%">Titel:&nbsp;</td>
		  	 			<td width="1%"><input name="news_title" type="text" style="width:100%;" class="egl_text"/></td>
		  	 		</tr>
		  	 		<tr>
		  	 			<td width="1%">Kurztext:&nbsp;</td>
		  	 			<td width="1%"><input name="news_short_text" type="text" style="width:100%;" class="egl_text"/></td>
		  	 		</tr>
		  	 		<tr>
		  	 			<td width="1%">Text:&nbsp;</td>
		  	 			<td width="1%"><textarea name="news_text" class="egl_textbox" style="width:100%" rows="10"/></textarea></td>
		  	 		</tr>
		  	 		<tr>
		  	 			<td></td>
		  	 			<td><input type="submit" size="15" class="egl_button" value=" News verfassen "/></td>
		  	 		</tr>
		  	 		<tr>
		  	 			
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
	   </table>
	 	
 
 
 </td>
</tr></table>

<!--# DETAIL WINDOWS #-->
{section name=news loop=$categorynews}
<div id="dwindow{$categorynews[news]->id}" style="position:absolute; visibility:hidden; z-index:2">
	<table width="250" cellpadding="0" cellspacing="1" bgcolor="{#clr_content_border#}">
	 <tr>
	 	<td bgcolor="{#clr_content#}">
	 	<table><tr><td>
		{capture assign="news_date"}{date timestamp=$categorynews[news]->created format="%d.%m.%y"}{/capture}
		{capture assign="today_date"}{date timestamp=$smarty.const.EGL_TIME format="%d.%m.%y"}{/capture}
					
		<b>{$categorynews[news]->title}</b> <br/>
		{cutstr text=$categorynews[news]->short_text num=60}</b> <br/>
		<br/>
		<font style="font-size:10px;">erstellt am {date timestamp=$categorynews[news]->created format="%d.%m.%y %H:%M:%S"} von {$categorynews[news]->member_nick_name}[{$categorynews[news]->member_id}]</font> <br/>
		
		</td></tr>
		</table>
	 	</td>
	 </tr>
	</table>	
</div>
{/section}