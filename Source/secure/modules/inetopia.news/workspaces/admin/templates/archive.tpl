<h2>News Archiv</h2>
{include file="etc/message.tpl"}

<form name="news_form" action="{$url_file}page={$url_page}&a=start_search" method="POST">
<table width="100%" cellpadding="20" background="images/admin/search_news.gif" style="background-repeat:no-repeat;">
 <tr><td>
 	<br/><br/><br/>
 	
	<table border="0" cellpadding="0" cellspacing="2" width="100%" bgcolor="#C0C0C0">
	 <tr><td bgcolor="#FFFFFF">
		<table border="0" cellpadding="5" cellspacing="1" width="100%">
		<tr bgcolor="{#clr_content#}">
		 	<td><b>Verfasst</b><br/>(Release Datum)</td>
		 	<td>
		 		<table cellpadding="0">
		 		  <tr><td>vom</td></tr>
		 		 <tr>
		 		 	<td><input type="text" class="egl_text" value="{date timestamp=1 format='%d.%m.%y'}" name="start_date" size="10"/> um <input type="text" class="egl_text" value="{date timestamp=1 format='%H:%M:%S'}" name="start_clock" size="10"/></td>
		 		  </tr>
		 		  <tr><td>bis</td></tr>
		 		  <tr>
		 		 	<td><input type="text" class="egl_text" value="{date timestamp=$smarty.const.EGL_TIME format='%d.%m.%y'}" name="end_date" size="10"/> um <input type="text" class="egl_text" value="{date timestamp=$smarty.const.EGL_TIME format='%H:%M:%S'}" name="end_clock" size="10"/></td>
				 </tr>
				 <tr><td><img src="images/spacer.gif" height="10"/></td></tr>
				 <tr>
				 	<td><input type="checkbox" name="search_disable_date" value="yes" class="egl_checkbox">Erstellungsdatum nicht einbeziehen</td>
				 </tr>
				</table>
					 	
		 	</td>
		 </tr>
		<tr bgcolor="{#clr_content#}">
		 	<td><b>Titel enthält:</b></td>
		 	<td><input class="egl_text" type="text" size="70" name="search_title" value="{$_post.search_title}"/></td>
		</tr>
		<tr bgcolor="{#clr_content#}">
		 	<td><b>Kurzttext enthält:</b></td>
		 	<td><input class="egl_text" type="text" size="70" name="search_short_text" value="{$_post.search_short_text}"/></td>
		</tr>
		<tr bgcolor="{#clr_content#}">
		 	<td><b>Text enthält:</b></td>
		 	<td><input class="egl_text" type="text" size="70" name="search_text" value="{$_post.search_text}"/></td>
		 </tr>
		<tr bgcolor="{#clr_content#}">
			<td><b>In Kategorie:</b></td>
			<td><select style="width:300;" name="search_cat_id" class="egl_select">
					<option value="-1">Keine Kategorie ausgewählt</option>					
					<option disabled >------------------------------------</option>					
					{defun name="testrecursion" catroot=$categoryroot level="0"}
					    <option value="{$catroot->oProperties->id}" {if $catroot->oProperties->id == $_post.search_cat_id || $catroot->oProperties->id == $_get.cat_id}selected{/if} >{section name=c loop=$level}&nbsp;&nbsp;&nbsp;{/section} {$catroot->oProperties->name}</option>
						{foreach from=$catroot->aNodes item=node} 
							{fun name="testrecursion" catroot=$node level=$level+1 }
						{/foreach}
					{/defun}
			 </select>		
			</td>	  
		</tr>
		<!--#
		<tr bgcolor="{#clr_content#}">
		 	<td><b>Unterkategien einbeziehen:</b></td>
		 	<td><input type="checkbox" class="egl_checkbox" name="search_subcategories" value="yes"> Ja</td>
		 </tr>
		 #-->
		<tr bgcolor="{#clr_content#}">
		 	<td></td>
		 	<td><input type="image" src="images/buttons/new/bt_send.gif"/></td>
		 </tr>
	</table>
 </td></tr>
</table>

{if sizeof($SEARCH_RESULT)}
	<br/><br/><br/>
	<h2>Such Ergebnisse:</h2>
	
	<table width="100%">
	
	{section name=news loop=$SEARCH_RESULT}
	 <tr><td>
		<table cellpadding="5">
		 <tr>
		 	<td><img src="images/admin/small_news.gif"/></td>
		 	<td>
		 		<A href="{$url_file}page={$CURRENT_MODULE_ID}:admin&news_id={$SEARCH_RESULT[news]->id}"><b>{$SEARCH_RESULT[news]->title}</b></a> <br/>
		 		<font style="font-size:10px;">Geschrieben von <A href="{$url_file}page=cms.member.central&member_id={$SEARCH_RESULT[news]->member_id}">{$SEARCH_RESULT[news]->member_nick_name}</a> am {date timestamp=$SEARCH_RESULT[news]->created}, Release am {date timestamp=$SEARCH_RESULT[news]->released}</font>
		 	
		 	</td>
		</table>
	 </tr></td>
	 <tr><td><hr/></td></tr>
	{/section}
	
{/if}