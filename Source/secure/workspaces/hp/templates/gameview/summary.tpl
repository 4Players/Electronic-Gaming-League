<table border="0" width="100%" cellpadding="5">
 <tr><td valign="top">
 	<table border="0" width="100%" cellpadding="2">
 	 <tr>
 	 	<td width="1%"><table border="0" cellpadding="0" cellspacing="1" bgcolor="#000000"><tr><td><img width="100" src="{$PATH_GAMES}/small/{$gameinfo->logo_small_file}"/></td></tr></table></td>
 	 	<td width="1%"><img src="images/spacer.gif" width="1"/></td>
 	 	<td valign="top">
 	 	 <font style="font-size:15px"><b>{$gameinfo->name|strip_tags|stripslashes}</b></font><br/>
 	 	 {if strlen($gameinfo->short_description)}{$gameinfo->short_description|strip_tags|stripslashes}{else}{$LNG_BASIC.c3053}{/if} <br/><br/>
 	 	 {include file="devs/hr2.tpl" width="100%"}<br/>
 	 	 {if strlen($gameinfo->publisher)}<b>{$LNG_BASIC.c3051}:</b> {$gameinfo->publisher|strip_tags|stripslashes}<br/>{/if}
 	 	 {if strlen($gameinfo->developer)}<b>{$LNG_BASIC.c3050}:</b> {$gameinfo->developer|strip_tags|stripslashes}<br/>{/if}
 	 	 {if $gameinfo->release_date}<b>{$LNG_BASIC.c3052}:</b> {date timestamp=$gameinfo->release_date format="%d.%m.%Y"}<br/>{/if}
 	 	</td>
 	 </tr>
 	</table>
 	
 	<table width="100%" height="400" border="0" cellpadding="0" cellspacing="0" background="_images/eglbeta/content/design/{$GLOBAL_COLOR}/bg_left.gif" style="background-repeat:no-repeat;">
 	 <tr><td valign="top">
 		<table border="0" width="390" cellpadding="5"><tr><td valign="top">
 		<br/>
		 	&nbsp;&nbsp;<b>{$LNG_BASIC.c3054}</b><br/>
		 	<table width="100%" cellpadding="2">
		 	{section name=news loop=$gamenews}
		 	 <tr>
		 	 	{if $gamenews[news]->image_file == "non"}<td colspan="2">{else}<td>{/if}
			 		<table cellpadding="2" cellspacing="0">
			 		 <tr><td><a class="news_href" href="{$url_file}page={module_getid cname='INETOPIA_NEWS'}:show&news_id={$gamenews[news]->id}"><font style="font-size:16px;"><b>{$gamenews[news]->title|stripslashes}</b></font></a></td></tr>
			 		 <tr><td><font style="font-size:12px;">{$gamenews[news]->short_text|strip_tags|stripslashes}</font></td></tr>
			 	 	 <tr><td><a href="{$url_file}page={module_getid cname='INETOPIA_NEWS'}:show&news_id={$gamenews[news]->id}"><b>{$LNG_BASIC.c2361}</b></a><br/>
					<font style="font-size:10px">
						{if $gamenews[news]->member_id == $smarty.const.EGL_NO_ID} 
							{*ADMINISTRATOR*} 
							{lng_parser content=$LNG_BASIC.c2362 name=$LNG_BASIC.c1019 time=$gamenews[news]->released}
						{else}
							{lng_parser content=$LNG_BASIC.c2362 name=$gamenews[news]->member_nick_name time=$gamenews[news]->released}
						{/if}
						<!--# {$gamenews[news]->num_comments} Kommentare #--> 
					</font>
			 	 	</table>
		 	 	</td>
		 	 	{if $gamenews[news]->image_file != "non"}
		 	 	<td><img border="1" style="border-color:#000000; background-color:#FFFFFF;" src="{$smarty.const.EGLDIR_NEWS_IMAGES}{$gamenews[news]->image_file}" width="120" height="90"/></td>
		 	 	{/if}
		 	 </tr>
		 	{if !$smarty.section.news.last}<tr><td colspan="2">{include file="devs/hr2.tpl" width="100%"}</td></tr>{/if}
		 	{/section}
		 	</table>
		 	
		</td></tr>
		</table>
		
	</td></tr>
  </table>
 
 </td>
 <td width="250" valign="top">
 	<!-- GAME-CUPS -->
 	<table width="100%" border="0" height="300" cellpadding="0" cellspacing="0" background="images/eglbeta/content/design/{$GLOBAL_COLOR}/bg_right.gif" style="background-repeat:no-repeat;">
 	 <tr><td valign="top">
 		<table border="0" width="260" cellpadding="10"><tr><td valign="top">

		 	<!--# LADDER #-->
		 	
		 	{if sizeof($game_ladderlist) > 0}
			 	<table><tr>
			 	 <td align="center" width="50"><img src="images/modules/inetopia_ladder/logo_ladder2.gif"/></td>
			 	 <td><font style="font-size:20px;"><b>{$LNG_BASIC.c0011}</b></font></td>
			 	 </tr></table>
			 	<table cellpadding="5">
			 	{section name=ladder loop=$game_ladderlist}
			 		<tr>
		   		 	   	{if strlen($game_ladderlist[ladder]->country_image_file) > 0}
			   		 	   	<td width="1%"><img src="{$PATH_COUNTRY}{$game_ladderlist[ladder]->country_image_file}" width="15" /></td>
			   		 	{else}
			   		 	   	<td width="1%"><img src="images/spacer.gif" width="15" /></td>
			   		 	{/if}			 			
			 			<td><a class="league_a" href="{$url_file}page={module_getid cname='INETOPIA_LADDER'}:overview&ladder_id={$game_ladderlist[ladder]->id}"><b>{$game_ladderlist[ladder]->name|strip_tags|stripslashes}</b></a> <br/>
			 			<font style="font-size:10px">
				 			{lng_parser content=$LNG_BASIC.c3057 participants=$game_ladderlist[ladder]->num_participants matches=$game_ladderlist[ladder]->num_matches}
		 				</font>
		 				{if $game_ladderlist[ladder]->fastchallenge_mode}
		 					<br/><font style="color:red; font-size:10px;">{$LNG_BASIC.c3063}</font>
		 				{/if}
			 			
			 			</td>
			 		</tr>
			 	{/section}
			 	</table>
			 	<br/><br/>
		 	{/if}

 			<!--# CUPS #-->
		 	{if sizeof($game_cuplist) > 0}
			 	<table><tr>
			 	 <td align="center" width="50"><img src="images/eglbeta/cups.gif"/></td>
			 	 <td><font style="font-size:20px;"><b>{$LNG_BASIC.c0021}</b></font></td>
			 	 </tr></table>
			 	<table cellpadding="5">
			 	{section name=cup loop=$game_cuplist}
			 		<tr>
		   		 	   	{if strlen($game_cuplist[cup]->country_image_file) > 0}
			   		 	   	<td width="1%"><img src="{$PATH_COUNTRY}{$game_cuplist[cup]->country_image_file}" width="15" /></td>
			   		 	{else}
			   		 	   	<td width="1%"><img src="images/spacer.gif" width="15" /></td>
			   		 	{/if}			 			
			 			<td><A class="league_a" href="{$url_file}page={module_getid cname='INETOPIA_CUP'}:info&cup_id={$game_cuplist[cup]->id}"><b>{$game_cuplist[cup]->name|strip_tags|stripslashes}</b></a> <br/>
			 			<font style="font-size:10px">
				 			{lng_parser content=$LNG_BASIC.c3058 participants=$game_cuplist[cup]->num_participants start=$game_cuplist[cup]->start_time}
			 			</font>
			 			</td>
			 		</tr>
			 	{/section}
			 	</table>
			 	<br/><br/>
			 {/if}
		 	
		 	
		 	<!--# CURRENT POLL #-->
		 	{if isset($currpoll)}
			 	{if !$currpoll_already_voted}
				 	<form action="{$url_file}page={module_getid cname='INETOPIA_POLLS'}:vote&poll_id={$currpoll->id}&poll_id={$currpoll->id}&game_id={$gameinfo->id}&a=voting" name="current_poll" method="POST">
				 	<font style="font-size:20px;"><b>{$LNG_BASIC.c3060}</b></font><br/>
				 	<table width="98%" align="center">
				 	 <tr>
				 	 	<td colspan="2"><b>{$currpoll->question|strip_tags|stripslashes}</b></td>
				 	 </tr>
				 	 {section name=ans loop=$currpoll_answers}
				 	 <tr>
				 	 	<td width="1%"><input type="radio" name="poll_vote_{$currpoll->id}" value="{$currpoll_answers[ans]->id}"/></td>
				 	 	<td>{$currpoll_answers[ans]->answer|strip_tags|stripslashes}</td>
				 	 </tr>
				 	 {/section}
				 	 <tr>
				 	 	<td colspan="2">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c3062 link="javascript:document.current_poll.submit();"}</td>
				 	 </tr>
				 	</table>
				 	
				 	<br/>
				 	<div align="left"> <A title="{$LNG_BASIC.c3061}" href="{$url_file}page={module_getid cname='INETOPIA_POLLS'}:overview&game_id={$gameinfo->id}"><b>{$LNG_BASIC.c3061}</b></a></div>
				 	</form>
			 	{else}
				 	<font style="font-size:20px;"><b>{$LNG_BASIC.c3060}</b></font><br/>
				 	<table width="98%" align="center">
				 	 <tr>
				 	 	<td colspan="3"><b>{$currpoll->question|strip_tags|stripslashes}</b></td>
				 	 </tr>
				 	 {section name=ans loop=$currpoll_answers}
				 	 <tr>
				 	 	<td width="1%"><b>&sdot;</b></td>
				 	 	<td>{$currpoll_answers[ans]->answer|strip_tags|stripslashes}</td>
				 	 	<td width="50">
						 	<table border="0" width="{percent max=$currpoll->num_hits value=$currpoll_answers[ans]->hits}%" cellpadding="0" cellspacing="1">
						 	 <tr><td bgcolor="#FFA901" background="images/poll_processbar.gif" style="background-repeat:repeat-x;"><img src="images/spacer.gif" height="10"></td></tr>
						 	</table> 		 	
			 		 	</td>
				 		<td width="10">{percent max=$currpoll->num_hits value=$currpoll_answers[ans]->hits}%</td>
				 	 </tr>
				 	 {/section}
				 	</table>
				 	<br/>
				 	<div align="left"> <A title="{$LNG_BASIC.c3061}" href="{$url_file}page={module_getid cname='INETOPIA_POLLS'}:overview&game_id={$gameinfo->id}"><b>{$LNG_BASIC.c3061}</b></a></div>
			 	{/if}
		 	{/if}
		 	
		 </td></tr>
		</table>
	 	
 	</td></tr>
 	</table>
 	
 </td>
</tr></table>
