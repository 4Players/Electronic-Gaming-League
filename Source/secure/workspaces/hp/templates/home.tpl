<h2>{$LNG_BASIC.c2350}</h2>

 	<table border="0" width="100%" border="0" cellpadding="0" cellspacing="0">
 	 <tr><td valign="top" width="70%">
		 	<table width="90%" cellpadding="2">
		 	{section name=news loop=$news_left}
		 	{if $news_left[news]}
		 	 <tr>
		 	 	{if $news_left[news]->image_file == "non"}<td colspan="2">{else}<td>{/if}
			 		<table cellpadding="2" cellspacing="0">
			 		 <tr><td>
			 		 	
			 		 	<table cellpadding="3" cellspacing="0" width="100%">
			 		 	 <tr>
			 		 	 {if $news_left[news]->game_id}
			 		 		<td width="1%"><A href="{$url_file}page=gameview.summary&game_id={$news_left[news]->game_id}"><img border="1" style="border-color:#000000;" src="{$PATH_GAMES}small/{$news_left[news]->game_logo_small_file}" width="30" height="40"/></td>
			 		 	 {/if}
			 		 		<td><A class="news_href" href="{$url_file}page={module_getid cname='INETOPIA_NEWS'}:show&news_id={$news_left[news]->id}"><font style="font-size:16px;"><b>{$news_left[news]->title|stripslashes}</b></font></a></td>
			 		 	 </tr>
			 		 	 </table>
			 		 	</td>
			 		 </tr>
			 		 <tr><td><font style="font-size:12px;">{$news_left[news]->short_text|strip_tags|stripslashes}</font></td></tr>
			 	 	 <tr><td><A href="{$url_file}page={module_getid cname='INETOPIA_NEWS'}:show&news_id={$news_left[news]->id}"><b>{$LNG_BASIC.c2361}</b></a><br/>
					<font style="font-size:10px">
					
					{if $news_left[news]->member_id == $smarty.const.EGL_NO_ID}
						{lng_parser content=$LNG_BASIC.c2362 name=$LNG_BASIC.c1019 timestamp=$news_left[news]->released}
					{else}
						{lng_parser content=$LNG_BASIC.c2362 name=$news_left[news]->member_nick_name timestamp=$news_left[news]->released}
					{/if}
					
					</font>
			 	 	</table>
		 	 	</td>
		 	 	{if $news_left[news]->image_file != "non"}
		 	 	<td><img border="1" style="border-color:#000000; background-color:#FFFFFF;" src="{$smarty.const.EGLDIR_NEWS_IMAGES}{$news_left[news]->image_file}" width="120" height="90"/></td>
		 	 	{/if}
		 	 </tr>
		 	{if !$smarty.section.news.last}<tr><td colspan="2">{include file="devs/hr2.tpl" width="100%"}</td></tr>{/if}
		 	{/if}
		 	{/section}
		 	</table>
		 	
	</td>
	<td valign="top" align="center">
		 	<table width="100%" cellpadding="2">
		 	
		 	{section name=news loop=$news_right}
		 	{if $news_right[news]}
		 	 <tr>
		 	 	<td>
			 		<table cellpadding="2" cellspacing="0"> 
			 		 <tr><td>
			 		 	
			 		 	<table cellpadding="3" cellspacing="0" width="100%">
			 		 	 <tr>
			 		 		<td><A class="news_href" href="{$url_file}page={module_getid cname='INETOPIA_NEWS'}:show&news_id={$news_right[news]->id}"><font style="font-size:16px;"><b>{$news_right[news]->title|stripslashes}</b></font></a></td>
			 		 	 </tr>
			 		 	 </table>
			 		 	</td>
			 		 </tr>
					<tr><td>
						<font style="font-size:10px">
						
						{if $news_right[news]->member_id == $smarty.const.EGL_NO_ID}
							{lng_parser content=$LNG_BASIC.c2362 name=$LNG_BASIC.c1019 timestamp=$news_right[news]->released}
						{else}
							{lng_parser content=$LNG_BASIC.c2362 name=$news_right[news]->member_nick_name timestamp=$news_right[news]->released}
						{/if}						
						</font>
					</td></tr>
			 	 	</table>
		 	 	</td>
		 	 </tr>
		 	{if !$smarty.section.news.last}<tr><td colspan="2">{include file="devs/hr2.tpl" width="100%"}</td></tr>{/if}
		 	{/if}
		 	{/section}
		 	</table>
	 </td>
	</tr>
	</table>

	
	
