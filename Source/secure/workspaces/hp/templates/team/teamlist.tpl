<h2>{$LNG_BASIC.c1011}</h2>
<table cellpadding="0" width="100%">
	<tr><td align="center">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c2621 link="`$url_file`page=list.teams"}</td></tr>
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
						<td><A href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$teams_per_page}"><b><u>{$smarty.section.page.index+1}</u></b></a></td>
					{else}
						<td><A href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$teams_per_page}"><b>{$smarty.section.page.index+1}</b></a></td>
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
{section name=t loop=$teams}
 <tr><td>{include file="devs/hr2.tpl" width="100%"}</td></tr>
 <tr>
 	<td valign="top">
 		<table border="0" width="100%">
 		 <tr><td width="1%">
  	 			{if $teams[t]->logo_file != 'non'}
	 				<A href="{$url_file}page=team.info&team_id={$teams[t]->id}"><img border="1" style="border-color:#000000;" src="{$path_logos}teams/{$teams[t]->logo_file}" width="100" height="100"> </a>
	 			{else}
	 				<A href="{$url_file}page=team.info&team_id={$teams[t]->id}"><img border="1" style="border-color:#000000;" src="images/logo.na.jpg" width="100" height="100"></a>
	 			{/if} 		
	 	</td>
	 	<td valign="top" width="25%">
	 	
	 	
	
		 		{* Team-ID *}
		 		<table border="0">
		 		 <tr>
		 		 	<td><font size="1"><i>{$LNG_BASIC.c4835}</font></i></td>
		 		 </tr>
		 		 <tr>
		 		 	<td> <b>{$teams[t]->id}</b></td>
		 		 </tr>
		 		</table>
		 		
	
		 		{* Team-Name *}
		 		<table border="0">
		 		 <tr>
		 		 	<td><font size="1"><i>{$LNG_BASIC.c4831}</font></i></td>
		 		 </tr>
		 		 <tr>
		 		 	<td> <A href="{$url_file}page=team.info&team_id={$teams[t]->id}"><b>{cutstr num=20 text=$teams[t]->name|strip_tags}</b></a></td>
		 		 </tr>
		 		</table>
		 		
	
		 		{* Team-Tag *}
		 		<table border="0">
		 		 <tr>
		 		 	<td><font size="1"><i>{$LNG_BASIC.c4832}</i></font></td>
		 		 </tr>
		 		 <tr>
		 		 	<td> <b>{$teams[t]->tag|strip_tags}</b></td>
		 		 </tr>
		 		</table>
		 		
		 		{* Team members *}
		 		<table border="0">
		 		 <tr>
		 		 	<td><font size="1"><i>{$LNG_BASIC.c2608}</i></font></td>
		 		 </tr>
		 		 <tr>
		 		 	<td> <b>{$teams[t]->num_teammembers|tointeger}</b></td>
		 		 </tr>
		 		</table>	 	
		 		
	 	
	 	 </td>
	 	 <td valign="top" width="25%">
	 	 
		 		{* Created *}
		 		<table border="0">
		 		 <tr>
		 		 	<td><font size="1"><i>{$LNG_BASIC.c2618}</i></font></td>
		 		 </tr>
		 		 <tr>
		 		 	<td> <b>{date timestamp=$teams[t]->created format="%d. %b %y"}</b></td>
		 		 </tr>
		 		</table>
		 		
		 			
		 		{* Team Nationality/Land *}
		 		<table border="0">
		 		 <tr>
		 		 	<td><font size="1"><i>{$LNG_BASIC.c5504}</font></i> </td>
		 		 </tr>
		 		 <tr>
		 		 {if !$teams[t]->country_id}
		 		 	<td><b>{$LNG_BASIC.c1021}</b></td>
		 		 {else}
		 		 	<td><b>{$teams[t]->country_name}</b> <img src="{$path_country}{$teams[t]->country_image_file}"></td>
		 		 {/if}
		 		 </tr>
		 		</table>
		 		
		 		
		 		{* Clan name *}
		 		<table border="0">
		 		 <tr>
		 		 	<td><font size="1"><i>{$LNG_BASIC.c4260}</i></font></td>
		 		 </tr>
		 		 <tr>
		 		 {if $teams[t]->clan_id}
		 		 	<td> <A href="{$url_file}page=clan.info&clan_id={$teams[t]->clan_id}"><b>{$teams[t]->clan_name|strip_tags}</b></a> </td>
		 		 {else}
		 		 	<td> -- </td>
		 		 {/if}
		 		 </tr>
		 		</table>
	 	 
	 	 
	 	 </td>
	 	 <td valign="top" width="25%">
	 	 
		 		{* Team options *}
		 		<table border="0">
		 		 <tr>
		 		 	<td><font size="1"><i>{$LNG_BASIC.c4652}</i></font></td>
		 		 </tr>
		 		  <tr>
		 		 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c2500 link="`$url_file`page=team.info&team_id=`$teams[t]->id`"} </td>
		 		  </tr>	
		 		</table>
		 				 		
	 	 </td>
	 	 </tr>
	 	</table>
 	
 	</td>
</tr>
{/section}
</table>


<br>
<table border="0" width="100%">
 <tr>
		 	<td width="50%"><b>{lng_parser content=$LNG_BASIC.c4651 p1=$curr_page+1 p2=$num_pages}</b></td>
 	<td align="right">
		<table>
		<tr>
		{section name=page loop=$num_pages}
		{if $smarty.section.page.index > $curr_page-5  &&  $smarty.section.page.index < $curr_page+5 }
			{if $smarty.section.page.index == $curr_page}
				<td><A href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$teams_per_page}"><b><u>{$smarty.section.page.index+1}</u></b></a></td>
			{else}
				<td><A href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$teams_per_page}"><b>{$smarty.section.page.index+1}</b></a></td>
			{/if}
		{/if}
		{/section}
		</tr>
		</table>
	</td>
 </tr>
</table>