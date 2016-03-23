<table border="0" width="100%" cellpadding="0" cellspacing="0">
 <tr><td valign="top">
 
	<table><tr><td><img src="images/cupicon_gold_small.gif" width="50"/></td><td><font style="font-size:20px;">{$cup->name|strip_tags|stripslashes}</font><br/><b>{$LNG_MODULE.c1000}</b></td></tr></table>
	
	<table width="400" border="0">
	 <tr>
	 	<td valign="top"></td>
	 	<td valign="top">
	 	
	 		<table cellpadding="2">
	 		 <tr>
	 		 	<td><b>{$LNG_MODULE.c1002}:</b></td><td>{date timestamp=$cup->start_time}</td>
	 		 </tr>
			 <tr>
			 	<td><b>{$LNG_MODULE.c1001}:</b></td><td>{if $cup->is_public}<!--# YES #-->{$LNG_BASIC.c1023}{else}{$LNG_BASIC.c1024}<!--# NO #-->{/if}</td>
			 </tr>
	 		 <tr>
	 		 	<td><b>{$LNG_MODULE.c1003}:</b></td><td>{$cup->max_participants}</td>
	 		 </tr>
	 		 <tr>
	 		 	<td><b>{$LNG_MODULE.c1004}:</b></td><td>{$cup->num_participants}</td>
	 		 </tr>
	 		 <tr>
	 		 	<td><b>{$LNG_MODULE.c1005}:</b> </td><td>
					 	{section name=admin loop=$adminlist}
					 		<a href="{$url_file}page=member.info&member_id={$adminlist[admin]->member_id}">{$adminlist[admin]->nick_name|strip_tags|stripslashes}</a>
					 		{if !$smarty.section.admin.last},{/if}
					 	{/section}
					 	{if sizeof($adminlist)==0}{$LNG_BASIC.c1212}{/if}
	 		 	</td>
	 		 </tr>
			</table>
			<br/>
			{include file="devs/hr2.tpl" width="100%"}<br/>
						
			<b>{$LNG_MODULE.c1006}:</b>
			<table border="0" cellpadding="5" cellspacing="0" width="100%">
			 <tr>
			 	<td>{if strlen($cup->map_pool|nl2br)==0}{$LNG_MODULE.c1007}{else}{$cup->map_pool|nl2br}{/if}</td>
			  </tr>
			</table><br/>
			
			{include file="devs/hr2.tpl" width="100%"}<br/>
			{if $cup->finished && $cup->num_participants}
				<div align="left"><h2>{$LNG_MODULE.c1008}:</h2></div><br/>
				<br/>
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				 <tr>
					<td>{include file="`$page_dir`/ranking.tpl"}</td>
				 </tr>
				</table>
			{include file="devs/hr2.tpl" width="100%"}<br/>
			{/if}
			
		  <!--# DESCRIPTION #-->
		  {if strlen($cup->description) > 0}
		 	<table width="100%" height="270" border="0" cellpadding="0" cellspacing="0" style="background-repeat:no-repeat;">
		 	 <tr><td valign="top">
			 		<div align="left"><h2>{$LNG_MODULE.c1009}:</h2></div>
			 		<br/><br/>
			 		{include file="devs/dropdown_textbox.tpl" text=`$cup->description` link="<b>Mehr lesen</b>"}
					{include file="devs/hr2.tpl" width="100%"}<br/>
			</td></tr>
		  </table>
		  {/if}
		  
		  <!--# NEWS #-->
			{if isset($cupnews) }
		 	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" >
		 	 <tr><td valign="top">
		 	 
		 		<table border="0" width="100%" cellpadding="0" cellspacing="0"><tr><td valign="top">
			 		<br/>
			 		<h2>{$LNG_MODULE.c1010}</h2>
					 	<table width="100%" cellpadding="5" cellspacing="2">
					 	{section name=news loop=$cupnews}
					 	 <tr>
					 		<td>
						 		<table cellpadding="2" cellspacing="0">
						 		 <tr><td><a class="news_href" href="{$url_file}page={module_getid cname='INETOPIA_NEWS'}:show&news_id={$cupnews[news]->id}"><font style="font-size:16px;"><b>{$cupnews[news]->title|strip_tags|stripslashes}</b></font></a></td></tr>
						 		 <tr><td><font style="font-size:12px;">{$cupnews[news]->short_text|stripslashes}</font></td></tr>
						 	 	 <tr><td><a href="{$url_file}page={module_getid cname='INETOPIA_NEWS'}:show&news_id={$cupnews[news]->id}"><b>{$LNG_BASIC.c2361}</b></a><br/>

						 	 	 <font style="font-size:10px">
						 	 	 
						 	 	 {if $cupnews[news]->member_id == $smarty.const.EGL_NO_ID}
							 	 	 {lng_parser content=$LNG_BASIC.c2362 name=$LNG_BASIC.c1019 timestamp=$cupnews[news]->released}
							 	 	 <!--# written by Root-ADMIN #-->
						 	 	 {else}
						 	 	 	{lng_parser content=$LNG_BASIC.c2362 name=$cupnews[news]->member_nick_name timestamp=$cupnews[news]->released}
						 	 	 {/if}
						 	 	 <!--#, {$cupnews[news]->num_comments} Kommentare #-->
						 	 	 </font>
						 	 	 
						 	 	 
						 	 	</table>
					 	 	</td>
					 	 	{if $cupnews[news]->image_file != "non"}<td><img border="1" style="border-color:#000000;" src="{$smarty.const.EGLDIR_NEWS_IMAGES}{$cupnews[news]->image_file}" width="120" height="90"/></td>{/if}
					 	 
					 	 </tr>
					 	{if !$smarty.section.news.last}<tr><td colspan="2">{include file="devs/hr2.tpl" width="100%"}</td></tr>{/if}
					 	{/section}
					 	</table>
					 	
				</td></tr>
				</table>
				
			</td></tr>
		  </table>
		  {/if}
		  		  
	 	</td>
	 </tr>
	</table>
 </td>
 <td width="100" align="center" valign="top">

	{include file="`$page_dir`/menu_right.tpl"} 

 </td></tr>
</table>
