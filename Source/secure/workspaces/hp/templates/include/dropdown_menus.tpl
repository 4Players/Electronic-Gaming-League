{*********************************************************************************************************}
{*****************              G A M E S 		                              ****************************}
{*********************************************************************************************************}
<div id='d1' style="position:absolute; visibility:hidden; z-index:2">
 <table border='0' cellpadding="0" cellspacing="1" bgcolor="#000000" width="250" onmouseout="startTime();" onmouseover="stopTime();">
  <tr>
   <td bgcolor="#FFFFFF">
   		
   		<table border="0" width="100%" cellpadding="0" cellspacing="0">
   		{section name=pgame loop=$pgames}
	   	  <tr onclick="javascript:document.location='{$url_file}page=chosegame&game_id={$pgames[pgame]->id}&curr_page={$url_page}';">   
   		 	<td>
   		 	{if $pgames[pgame]->id == $smarty.cookies.member.game_id}
   		 	 <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#FFF4CD"  onmouseover="javascript:set_style_bg(this, '#E3E3E3');" onmouseout="javascript:set_style_bg(this, 'FFF4CD' );">
   		 	   <tr>
   		 	   	<td width="1%"><img src="{$PATH_GAMES}small/{$pgames[pgame]->logo_small_file}" width="15" height="20"/></td>
   		 	   	<td width="1%"><img src="images/spacer.gif" width="10" height="1"/></td>
	   		 	<td><A class="chosegame_a" href="{$url_file}page=chosegame&game_id={$pgames[pgame]->id}&curr_page={$url_page}"><b>{$pgames[pgame]->name}</b></a></td>
	   		  </tr>
	   		</table>
	   		{else}
   		 	 <table width="100%" cellpadding="0" cellspacing="0" onmouseover="javascript:set_style_bg(this, '#E3E3E3');" onmouseout="javascript:set_style_bg(this, '' );" >
	   	  	  <tr>   
   		 	   	<td width="1%"><img src="{$PATH_GAMES}small/{$pgames[pgame]->logo_small_file}" width="15" height="20"/></td>
   		 	   	<td width="1%"><img src="images/spacer.gif" width="10" height="1"/></td>
	   		 	<td><A class="chosegame_a" href="{$url_file}page=chosegame&game_id={$pgames[pgame]->id}&curr_page={$url_page}"><b>{$pgames[pgame]->name}</b></a></td>
	   		  </tr>
	   		</table>
	   		{/if}
   					 	
   		 	</td>
   		 </tr>
   		 {if !$smarty.section.pgame.last}<tr><td  background="images/interruped_line.gif" width="{$width}" style="background-repeat: repeat-x;"><img src="images/spacer.gif" width="1"/></td></tr>{/if}
   		 {/section}
   		</table>
   	
   </td>
  </tr>
 </table>
</div>


{*********************************************************************************************************}
{*****************              M E M B E R     M E N U 		              ****************************}
{*********************************************************************************************************}

<div id='d2' style="position:absolute; visibility:hidden; z-index:2; width:230;">
 <table border='0' cellpadding="1" cellspacing="2" width="100%" onmouseout="startTime();" onmouseover="stopTime();">
  <tr>
   <td bgcolor="#000000">
   		
	 	<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#FFFFFF"><tr><td>
	 		<!--### NAVIGATION START ###-->
	 		{if $is_loggedin}
		 		{include file="etc/accounts.info.tpl"}
		 	{else}
	   		 	 <table width="100%" cellpadding="3" cellspacing="0" onmouseover="javascript:set_style_bg(this, '#E3E3E3');" onmouseout="javascript:set_style_bg(this, '' );">
	   		 	   <tr>
		   		 	<td><A href="{$url_file}page=signin"><b>{$LNG_BASIC.c4014}</b></a></td>
		   		  </tr>
		   		 </table>
	   		</td></tr>
		  	<tr><td>
		  	
	   		 	 <table width="100%" cellpadding="3" cellspacing="0" onmouseover="javascript:set_style_bg(this, '#E3E3E3');" onmouseout="javascript:set_style_bg(this, '' );">
	   		 	   <tr>
		   		 	<td><A href="{$url_file}page=login"><b>{$LNG_BASIC.c4015}</b></a></td>
		   		  </tr>
		   		</table>
		 	{/if}
	 	</td></tr></table>
   </td>
  </tr>
 </table>
</div>


{*********************************************************************************************************}
{*******************              CHALLENGE-MODULES 	                  ********************************}
{*********************************************************************************************************}
{if $smarty.cookies.member.game_id > 0}
<div id="d3" style="position:absolute; visibility:hidden; z-index:2">

 <table border='0' cellpadding="0" cellspacing="1" bgcolor="#000000" width="230" onmouseout="javascript:startTime();" onmouseover="javascript:stopTime();">
  <tr>
   <td bgcolor="#FFFFFF" >
   		{if sizeof($game_ladders) > 0}
   		<table><tr><td><img src="images/ladder_small_bgwhite.gif" width="18"/></td><td><font style="font-size:16px"><b>{$LNG_BASIC.c0011}</b></font></td></tr></table>
   		<table border="0" width="100%" cellpadding="3" cellspacing="0">
   		{section name=mladder loop=$game_ladders}
	   	  <tr>   
   		 	<td onclick="javascript:document.location='{$url_file}page={module_getid cname='INETOPIA_LADDER'}:overview&ladder_id={$game_ladders[mladder]->id}';" onmouseover="set_style_bg(this, '#E3E3E3' );" onmouseout="set_style_bg(this, '');" >
   		 	 <table width="100%" cellpadding="0" cellspacing="0">
   		 	   <tr>
   		 	   	<!--# <td width="1%"><img src="{$PATH_COUNTRY}germany.gif" width="15" /></td>#-->
   		 	   	{if strlen($game_ladders[mladder]->country_image_file) > 0}
	   		 	   	<td width="1%"><img src="{$PATH_COUNTRY}{$game_ladders[mladder]->country_image_file}" width="15" /></td>
	   		 	{else}
	   		 	   	<td width="1%"><img src="images/spacer.gif" width="15" /></td>
	   		 	{/if}
	   		 	   		 	   	
   		 	   	<td width="1%"><img src="images/spacer.gif" width="10" height="1"/></td>
	   		 	<td><A class="chosegame_a" href="{$url_file}page={module_getid cname='INETOPIA_LADDER'}:overview&ladder_id={$game_ladders[mladder]->id}"><b>{$game_ladders[mladder]->name|strip_tags|replace:' ':'&nbsp;'}</b></a></td>
	   		  </tr>
	   		</table>
   		  </td>
   		 </tr>
   		{/section}
   		</table>
		<br/>
   		{/if}
   		{if sizeof($game_cups) > 0}
   		<table><tr><td><img src="images/cups_small.gif" width="15"/></td><td><font style="font-size:16px"><b>{$LNG_BASIC.c0021}</b></font></td></tr></table>
   		<table border="0" width="100%" cellpadding="3" cellspacing="0">
   		{section name=mcups loop=$game_cups}
	   	  <tr>   
   		 	<td onclick="javascript:document.location='{$url_file}page={module_getid cname='INETOPIA_CUP'}:info&cup_id={$game_cups[mcups]->id}';" onmouseover="set_style_bg(this, '#E3E3E3' );" onmouseout="set_style_bg(this, '');" >
   		 	 <table width="100%" cellpadding="0" cellspacing="0">
   		 	   <tr>
   		 	   <!--# <td width="1%"><img src="{$PATH_GAMES}small/{$game_cups[mcups]->game_logo_file}" width="15" height="20"/></td#-->
   		 	   	{if strlen($game_cups[mcups]->country_image_file) > 0}
	   		 	   	<td width="1%"><img src="{$PATH_COUNTRY}{$game_cups[mcups]->country_image_file}" width="15" /></td>
	   		 	{else}
	   		 	   	<td width="1%"><img src="images/spacer.gif" width="15" /></td>
	   		 	{/if}
   		 	   	   		 	   	
   		 	   	<td width="1%"><img src="images/spacer.gif" width="10" height="1"/></td>
	   		 	<td><A class="chosegame_a" href="{$url_file}page={module_getid cname='INETOPIA_CUP'}:info&cup_id={$game_cups[mcups]->id}"><b>{$game_cups[mcups]->name|strip_tags|replace:' ':'&nbsp;'}</b></a></td>
	   		  </tr>
	   		</table>
   		  </td>
   		 </tr>
   		{/section}
   		</table>
   		{/if}
		
   </td>
  </tr>
 </table>
</div>
{/if}