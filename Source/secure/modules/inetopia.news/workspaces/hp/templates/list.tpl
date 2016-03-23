{section name=news_sec loop=$news_sections}

		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<!--
		 <tr><td align="right">
		 		<table border="0" cellpadding="0" cellspacing="0">
		 		 <tr>
		 		 	{if $news_sections[news_sec]->btoday}
		 		 		<td><b> Heute, {$news_sections[news_sec]->day}.{$news_sections[news_sec]->month}. </b></td>
		 		 	{elseif $news_sections[news_sec]->byesterday}
		 		 		<td><b> Gestern, {$news_sections[news_sec]->day}.{$news_sections[news_sec]->month}. </b></td>
		 		 	{else}
		 		 		<td><b> {weekday day=$news_sections[news_sec]->weekday}, {$news_sections[news_sec]->day}.{$news_sections[news_sec]->month}. </b></td>
		 		 	{/if}
		 		 </tr>
		 		</table>
		 		
		 	</td></tr>
		 -->
		 <tr><td> 
		 		{* CONTENT *}
		 		<table border="0" width="98%" cellpadding="0" cellspacing="0" align="center">
		 		 <tr>
		 		 	<td>
		 		 	
		 		 	{* NEWS-LIST *}
		 		 	<table border=0 cellpadding="0" cellspacing="1" width="100%">
		 		 	 <tr><td>
						<table border="0" width="100%" cellpadding="0" cellspacing="3">
							{section name=news loop=$news_sections[news_sec]->news}
							{**
								 <tr>
								 	<td><b><i>{$news_sections[news_sec]->news[news]->subject|stripslashes}<b></td>
								 	<td width="1%"><b>{date timestamp=$news_sections[news_sec]->news[news]->created format="%H:%M"} </td>
								 </tr>
							**}
							{if $smarty.section.news.index == 2}
								 <tr>
									<td colspan="2"><A TARGET="_BLANK" HREF="http://inetopia.org"><img border=0 src="images/eglbeta/anzeige.gif"></A></td>
								 </tr>
							{/if}
								 <tr>
								 	<td colspan="2"><A class="news_href"href="{$url_file}page={$CURRENT_MODULE_ID}:news.show&news_id={$news_sections[news_sec]->news[news]->id}"><font size="5">{$news_sections[news_sec]->news[news]->title|stripslashes}</font> </a> </td>
								 </tr>
								 <tr>
								 <td colspan="2" valign="top">
								 	<table border="0" width="100%" cellpadding="0" cellspacing="0">
								 	 <tr>
								 	 	<td valign="top"> 
								 	 	<font size=2>{cutstr num=550 text=$news_sections[news_sec]->news[news]->text|bbcode2html|stripslashes}</font>
								 	</td></tr>
								 	{**
								 	<tr><td colspan="2">
								 	 	
								 	 		<table width="100%" cellpadding="0" cellspacing="10">
								 	 		 <tr>
								 	 		 	<td width="50%"> <b>Autor:  <A href="{$url_file}page=member.info&member_id={$news_sections[news_sec]->news[news]->member_id}">{$news_sections[news_sec]->news[news]->member_nick_name|strip_tags}</a> </b></td>
								 	 		 	<td align="right"> 	<A href="{$url_file}page={$CURRENT_MODULE_ID}:news.show&news_id={$news_sections[news_sec]->news[news]->id}#comment_show"><b>{$news_sections[news_sec]->news[news]->num_comments} Kommentare</b></a> |
								 	 								<A href="{$url_file}page={$CURRENT_MODULE_ID}:news.show&news_id={$news_sections[news_sec]->news[news]->id}"><b>Mehr lesen</b></a>
								 	 			</td>
								 	 		 </tr>
								 	 		</table>
								 	 		
								 	 </td></tr>
								 	 **}
								 	</table>
								 	<br>
								 </td></tr>
								 
								 {if !$smarty.section.news.last }
								 <tr><td colspan="2">{include file="devs/hr.tpl" width="100%"}</td></tr>
								 {/if}
							{/section}
						</table>
						
					</td></tr>
					</table>
		 		 	
		  	 	 </td></tr>
		 		</table>
		 </td></tr>
		</table>

{/section}

<br>
