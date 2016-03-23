<h2>{$LNG_BASIC.c1013}</h2>
<table cellpadding="0" width="100%">
	<tr><td align="center">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Clans suchen" link="`$url_file`page=list.clans"}</td></tr>
</table>	

<table border="0" width="100%" cellpadding="4" cellspacing="1">
  <tr>
 	<td>
		<table border="0" width="100%">
		 <tr>
		 	<td width="50%"><b>{lng_parser content=$LNG_BASIC.c4651 p1=$curr_page+1 p2=$num_pages}</b></td>
		 	<td align="right">
				<table>
				<tr>
				{section name=page loop=$num_pages}
				{if $smarty.section.page.index > $curr_page-5  &&  $smarty.section.page.index < $curr_page+5 }
					{if $smarty.section.page.index == $curr_page}
						<td><a href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$clans_per_page}"><b><u>{$smarty.section.page.index+1}</u></b></a></td>
					{else}
						<td><a href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$clans_per_page}"><b>{$smarty.section.page.index+1}</b></a></td>
					{/if}
				{/if}
				{/section}
				</tr>
				</table>
			</td>
		 </tr>
		</table>
 	</td>
 </tr>
{section name=c loop=$clans}
 <tr><td>{include file="devs/hr2.tpl" width="100%"}</td></tr>
 <tr>
 	<td valign="top">
 		<table border="0" width="100%">
 		 <tr><td width="1%">
	 			{if $clans[c]->logo_file != 'non'}
	 				<a href="{$url_file}page=clan.info&clan_id={$clans[c]->id}"><img  border="1" style="border-color:#000000;" src="{$path_logos}clans/{$clans[c]->logo_file}" width="100" height="100"> </a>
	 			{else}
	 				<a href="{$url_file}page=clan.info&clan_id={$clans[c]->id}"><img   border="1" style="border-color:#000000;" src="images/logo.na.jpg" width="100" height="100"></a>
	 			{/if} 		
	 	</td>
	 	<td valign="top" width="25%">
	 	
	
		 		{* Clan-ID *}
		 		<table border="0">
		 		 <tr>
		 		 	<td><font size="1"><i>{$LNG_BASIC.c4726}</i></font></td>
		 		 </tr>
		 		 <tr>
		 		 	<td> <b>{$clans[c]->id}</b></td>
		 		 </tr>
		 		</table>
		 		
	
		 		{* Clan-Name *}
		 		<table border="0">
		 		 <tr>
		 		 	<td><font size="1"><i>{$LNG_BASIC.c4312}</i></font></td>
		 		 </tr>
		 		 <tr>
		 		 	<td> <A href="{$url_file}page=clan.info&clan_id={$clans[c]->id}"><b>{cutstr num=20 text=$clans[c]->name|strip_tags|stripslashes}</b></a></td>
		 		 </tr>
		 		</table>
		 		
	
		 		{* Clan-Tag *}
		 		<table border="0">
		 		 <tr>
		 		 	<td><font size="1"><i>{$LNG_BASIC.c4313}</i></font></td>
		 		 </tr>
		 		 <tr>
		 		 	<td><b>{$clans[c]->tag|strip_tags|stripslashes}</b></td>
		 		 </tr>
		 		</table>
		 		
	 	 
		 		{* Clan created *}
		 		<table border="0">
		 		 <tr>
		 		 	<td><font size="1"><i>{$LNG_BASIC.c4262}</i></font></td>
		 		 </tr>
		 		 <tr>
		 		 	<td><b>{date timestamp=$clans[c]->created format="%d. %b %y"}</b></td>
		 		 </tr>
		 		</table>
		 				 		
		 		
	 	
	 	
	 	 </td>
	 	 <td valign="top" width="25%">
	 	 
	
		 		{* Clan Nationality *}
		 		<table border="0">
		 		 <tr>
		 		 	<td><font size="1"><i>{$LNG_BASIC.c4784}</i></font></td>
		 		 </tr>
		 		 <tr>
		 		 {if !$clans[c]->country_id}
		 		 	<td><b>{$LNG_BASIC.c1021}</b></td>
		 		 {else}
		 		 	<td><b>{$clans[c]->country_name}</b> <img src="{$path_country}{$clans[c]->country_image_file}"></td>
		 		 {/if}
		 		 </tr>
		 		</table>
		 				 		
		 		{* Clan Homepage *}
		 		<table border="0">
		 		 <tr>
		 		 	<td><font size="1"><i>{$LNG_BASIC.c4314}</i></font></td>
		 		 </tr>
		 		 <tr>
		 		 	<td><b>{cutstr num=20 text=$clans[c]->hp|strip_tags|stripslashes}</b></td>
		 		 </tr>
		 		</table>

		 		
		 		{* Clan members *}
		 		<table border="0">
		 		 <tr>
		 		 	<td><font size="1"><i>{$LNG_BASIC.c4791}</i></font></td>
		 		 </tr>
		 		 <tr>
		 		 	<td><b>{$clans[c]->num_clanmembers|tointeger}</b></td>
		 		 </tr>
		 		</table>		 			 		
	 	 
	 	 
	 	 </td>
	 	 <td valign="top" width="25%">

		 		
		 				 		
		 		
		 		{* Clan Options *}
		 		<table border="0">
		 		 <tr>
		 		 	<td><font size=1><i>{$LNG_BASIC.c4652}</i></font></td>
		 		 </tr>
		 		  <tr>
		 		 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c2500 link="`$url_file`page=clan.info&clan_id=`$clans[c]->id`"} </td>
		 		  </tr>	
		 		</table>
		 			 	 
	 	 </td>
	 	 </tr>
	 	</table>
 	
 	</td>
</tr>
{/section}
</table>

<br/>
<table border="0" width="100%">
 <tr>
 	<td width="50%"><b>{lng_parser content=$LNG_BASIC.c4651 p1=$curr_page+1 p2=$num_pages}</b></td>
 	<td align="right">
		<table>
		<tr>
		{section name=page loop=$num_pages}
		{if $smarty.section.page.index > $curr_page-5  &&  $smarty.section.page.index < $curr_page+5 }
			{if $smarty.section.page.index == $curr_page}
				<td><A href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$clans_per_page}"><b><u>{$smarty.section.page.index+1}</u></b></a></td>
			{else}
				<td><A href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$clans_per_page}"><b>{$smarty.section.page.index+1}</b></a></td>
			{/if}
		{/if}
		{/section}
		</tr>
		</table>
	</td>
 </tr>
</table>