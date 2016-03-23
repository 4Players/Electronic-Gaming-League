{include file="devs/message.tpl"}

{* Clan-Daten vorhanden ?*}
{if $clan}

	<h2>{$clan->name|strip_tags|stripslashes}</h2>
		
	{include file="devs/hr_black.tpl" width="100%"}
		
	<table border="0" width="100%" >
	 <tr>
	 	<td width="1%" valign="top">
	
		 		<table border=0 bgcolor="{#clr_content#}" cellpadding="0" cellspacing="1">
		 		 <tr><td>
	 			{if $clan->logo_file != 'non'}
	 				<img border="1" style="border-color:#000000;" src="{$path_logos}clans/{$clan->logo_file}" width="100" height="100"> 
	 			{else}
	 				<img border="1" style="border-color:#000000;" src="images/logo.na.jpg" width="100" height="100">
	 			{/if}
		 		</td></tr>
		 		</table>
		 		 	
	 	</td>
	 	<td valign="top">
		
	 		{* ID *}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size=1><i>{$LNG_BASIC.c4250}, {$LNG_BASIC.c4251}</i></font></td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom;"> <b>{$clan->id}</b></td>
	 		 </tr>
	 		</table>	
	
	 	
	 		{* Name *} 
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size=1><i>{$LNG_BASIC.c4721}</i></font></td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom;"> <b> {$clan->name|strip_tags|stripslashes}</b></td>
	 		 </tr>
	 		</table>
	 	
	 		
	 		{* Tag *}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size=1><i>{$LNG_BASIC.c4722}</i></font></td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom;"> <b>{$clan->tag|strip_tags|stripslashes}	</b></td>
	 		 </tr>
	 		</table>
	 		
	 		{* LAND *}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size=1><i>{$LNG_BASIC.c4784}</i></font> </td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom;">
			 		{section name=country loop=$countries}
			 			{if $clan->country_id == $countries[country]->id}
			 				<b>{$countries[country]->name}</b> <img src="{$path_country}{$countries[country]->image_file}">
			 			{/if}
			 		{sectionelse}
				 		<b>{$LNG_BASIC.c1021}</b>
			 		{/section}
	 		 	</td>
	 		 </tr>
	 		</table> 		
	
	 		
	 	</td>
	 	<td width="40%" valign="top">
		 				
		 				
	 		{* Homepage *}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size=1><i>{$LNG_BASIC.c4723}</i></font></td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom;"> <b>{hp url=$clan->hp|strip_tags}</b>	</td>
	 		 </tr>
	 		</table>
	 	
	 		{* IRC *}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size=1><i>{$LNG_BASIC.c4315}</i></font></td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom;"> <b>{lng_parser content=$LNG_BASIC.c5003 irc_server=$clan->irc} </b> 	</td>
	 		 </tr>
	 		</table>
	 		
	 		
	 		{* registered *}
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font size=1><i>{$LNG_BASIC.c4262}</i></font></td>
	 		 </tr>
	 		 <tr>
	 		 	<td background="images/eglbeta/desc_bg.gif" style="background-repeat: repeat-x; background-position:bottom;"> <b>{date timestamp=$clan->created format="%d.%m.%Y"}</b></td>
	 		 </tr>
	 		</table>
	 		
	
	 		
	 	</td>
	 </tr>
	</table>
	 		
	
	<!--#$clan_members has been sorted to $clan_members[0...cpl][0..clan_member] (cpl=clan permission-list)#-->
	<br/>
	
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	 <tr><td><h2>{$LNG_BASIC.c5000}</h2></td></tr>
	 <tr><td>{include file="devs/hr_black.tpl" width="100%"}</td></tr>
	</table>

	<table border="0" width="100%" cellpadding="5" cellspacing="1">
 	{section name=cp loop=$clan_members}
	{if sizeof($clan_members[cp]) > 0}
		{assign var="clan_curr_member_list" value=$clan_members[cp] }
		 <tr>
			<td bgcolor="{#clr_content#}" width="20%" valign="top">{$cpl[cp]->name}({$clan_members[cp]|@count})</td>	
			<td bgcolor="{#clr_content#}" > {include file="etc/clan.list_permissions.tpl"}	</td>	
		 </tr>
	{/if}
	{/section}
	</table>
 			
	{if sizeof($clan_teams) > 0}
 	<br/><br/>
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	 <tr><td><h2>{$LNG_BASIC.c5001}</h2></td></tr>
	 <tr><td>{include file="devs/hr_black.tpl" width="100%"}</td></tr>
	</table>
	 <table border="0" cellpadding="1" cellspacing="1" width="100%">
	 <tr>
	 	<td bgcolor="{#clr_content#}"> 
	 	
	 	{if !$clan->display_team_details}
			{section name=team loop=$clan_teams}
				<A href='{$url_file}page=team.info&team_id={$clan_teams[team]->id}'>{$clan_teams[team]->name|strip_tags|stripslashes}</a>
				{if !$smarty.section.team.last}	, {/if}
			{/section}
			
		{else}
			{section name=team loop=$clan_teams}
			 <table border="0" width="100%" cellpadding="0" cellspacing="1" bgcolor="{#clr_content#}">
			  <tr>
			 	<td width="1%"> 

			 		<table border=0 bgcolor="{#clr_content#}" cellpadding="0" cellspacing="1">
			 		 <tr><td>
		 			{if $clan_teams[team]->logo_file != 'non'}
		 				<a href="{$url_file}page=team.info&team_id={$clan_teams[team]->id}"><img border="0" src="{$path_logos}teams/{$clan_teams[team]->logo_file}" width="100" height="100"> </a>
		 			{else}
		 				<a href="{$url_file}page=team.info&team_id={$clan_teams[team]->id}"><img border="0" src="images/logo.na.jpg" width="100" height="100"></a>
		 			{/if}
			 		</td></tr>
			 		</table>
			 	</td>
			 	<td valign="top">

			 		{* Name *}
			 		<table border="0">
			 		 <tr>
			 		 	<td><A href="{$url_file}page=team.info&team_id={$clan_teams[team]->id}"><h2>{$clan_teams[team]->name|strip_tags|stripslashes}</h2></a></td>
			 		 </tr>
			 		</table>	
			 	
			 		{* team-Tag *}
			 		<table border="0">
			 		 <tr>
			 		 	<td><font size=1><i>{$LNG_BASIC.c4832}</i></font></td>
			 		 </tr>
			 		 <tr>
			 		 	<td><b>{$clan_teams[team]->tag|strip_tags|stripslashes}</b></td>
			 		 </tr>
			 		</table>	

			 	</td>
			 	<td width="33%">
			 	
			 		{* created *}
			 		<table border="0">
			 		 <tr>
			 		 	<td><font size=1><i>{$LNG_BASIC.c2618}</i></font></td>
			 		 </tr>
			 		 <tr>
			 		 	<td> <b>{date timestamp=$clan_teams[team]->created format="%d.%m.%Y"}</b></td>
			 		 </tr>
			 		</table>				 	
			 				 	
			 	
			 		{* created *}
			 		<table border="0">
			 		 <tr>
			 		 	<td><font size=1><i>{$LNG_BASIC.c2619}</i></font></td>
			 		 </tr>
			 		 <tr>
			 		 	<td> <b>{$clan_teams[team]->num_teammembers|tointeger}</b></td>
			 		 </tr>
			 		</table>				 		
			 	
			 	</td>
 			  </tr>
 			  {if !$smarty.section.team.last}<tr><td colspan="3">{include file="devs/hr_black.tpl" width="100%"}{/if}
 			 </table>			
			{/section}
		{/if}
	 	</td>
	 </tr>
	 </table>
	{/if}
 	
	{if strlen($clan->description)}
	<br/><br/>
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	 <tr><td><h2>{$LNG_BASIC.c5002}</h2></td></tr>
	 <tr><td>{include file="devs/hr_black.tpl" width="100%"}</td></tr>
	</table>	
	<table border="0" width="100%" cellpadding=0 cellspacing=0>
	 <tr>
		<td bgcolor=""> 
			<table border="0" width="100%" cellpadding="3" cellspacing="1" bgcolor="{#clr_content#}">
			 <tr><td> {$clan->description|strip_tags|stripslashes|bbcode2html|nl2br}  </td></tr>
			</table>
		</td>	
	 </tr>
	</table> 	
	{/if}
		 
	<br/><br/>
	<table border="0" width="100%" bgcolor="{#clr_content#}" cellpadding="3" cellspacing="0">
	 <tr>
	 	<td align="right"> <A href='{$url_file}page={$url_page}&clan_id={$clan->id}&comment=write#comment_show'> <b>{$LNG_BASIC.c4203} {#clip_start#}{$comment_count}{#clip_end#}</b></a></td> 
	 </tr>
	</table>
	
	{include file="etc/comment.show.tpl"}
	<br/><br/>
	<!--# WRITE ? #-->
	{include file="etc/comment.write.tpl"}
 	
{/if}
