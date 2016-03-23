<h2>News</h2>
<b>Kategorien</b>


<script language="JavaScript" type="text/javascript" src="javascript/detail_window.js"></script>
{literal}
<script language="javascript"> 
	function load_bgcolor(obj, color ) { obj.style.backgroundColor 	= color;}

	function change_image_src( obj, pic ){obj.src = pic;}
</script>
{/literal}


{if $newscategories->oProperties->id != -1}
  <table width="100%">
   <tr><td>
		<table cellpadding="5" border="0">
		 <tr>
		 	<td><img src="images/hpadmin/folder_grey_open.gif"/></td>
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
	</td>
	<td align="right" valign="bottom">
		{include file="buttons/bt_universal.tpl" caption="News erstellen" color=$GLOBAL_COLOR link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.create&cat_id=`$newscategories->oProperties->id`"}	
	
	</td></tr>
 </table>
{else}
  <table width="100%">
   <tr><td>
		<table cellpadding="5" border="0">
		 <tr>
		 	<td><img src="images/hpadmin/folder_grey_open.gif"/></td>
		 	<td><b>News Root</b></td>
		 </tr>
		</table>
	</td>
	<td align="right" valign="bottom">
		{include file="buttons/bt_universal.tpl" caption="News erstellen" color=$GLOBAL_COLOR link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.create&cat_id=`$newscategories->oProperties->id`"}	
	</td></tr>
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
	 	<td background="images/hpadmin/splitline.gif" style="background-repeat:no-repeat;"><img src="images/spacer.gif" height="5"/></td>
	 </tr>
	</table>
	 
	{include file="`$page_dir`/view_folder.tpl" root_tree=$newscategories cats_per_line="5" options="false"}
	{/if}
	
	<br/><br/>
	
	{if sizeof($categorynews)}
	<table cellpadding="0" cellspacing="0" width="500">
	 <tr>
	 	<td><b>Zu dieser Kategorie gehören folgende letzten News (letzten 100):</b> [ <A href="{$url_file}page={$CURRENT_MODULE_ID}:archive&cat_id={$newscategories->oProperties->id}">Archiv</a> ]</td>
	 </tr>
	 <tr>
	 	<td background="images/hpadmin/splitline.gif" style="background-repeat:no-repeat;"><img src="images/spacer.gif" height="5"/></td>
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
					
						{if $news_date == $today_date}<A href="{$url_file}page={$CURRENT_MODULE_ID}:administration.admin&cat_id={$newscategories->oProperties->id}&news_id={$categorynews[$index]->id}"><img border="0" onmousemove="javascript:detailwindow_showdiv('dwindow{$categorynews[$index]->id}');" onmouseout="javascript:detailwindow_hidediv('dwindow{$categorynews[$index]->id}');" src="images/hpadmin/newstoday.gif"/></a>{/if}
						{if $news_date != $today_date}<A href="{$url_file}page={$CURRENT_MODULE_ID}:administration.admin&cat_id={$newscategories->oProperties->id}&admin&news_id={$categorynews[$index]->id}"><img border="0" onmousemove="javascript:detailwindow_showdiv('dwindow{$categorynews[$index]->id}');" onmouseout="javascript:detailwindow_hidediv('dwindow{$categorynews[$index]->id}');" src="images/hpadmin/news.gif"/></a>{/if}
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