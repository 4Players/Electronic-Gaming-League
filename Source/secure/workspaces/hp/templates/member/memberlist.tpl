<h2>{$LNG_BASIC.c1015}</h2>
<table cellpadding="0" width="100%">
	<tr><td align="center">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c4650 link="`$url_file`page=list.members"}</td></tr>
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
						<td><A href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$members_per_page}"><b><u>{$smarty.section.page.index+1}</u></b></a></td>
					{else}
						<td><A href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$members_per_page}"><b>{$smarty.section.page.index+1}</b></a></td>
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
 
{section name=m loop=$members}
 <tr><td>{include file="devs/hr2.tpl" width="100%"}</td></tr>
 <tr>
 	<td valign="top">
 		<table border="0" width="100%">
 		 <tr><td width="1%">
	 			{if $members[m]->photo_file != 'non'}
	 				<A href="{$url_file}page=member.info&member_id={$members[m]->id}"><img border="1" style="border-color:#000000;" src="{$path_photos}{$members[m]->photo_file}" width="100" height="133"> </a>
	 			{else}
	 				<A href="{$url_file}page=member.info&member_id={$members[m]->id}"><img   border="1" style="border-color:#000000;" src="images/photo.na.jpg" width="100" height="133"></a>
	 			{/if} 		
	 	</td>
	 	<td valign="top" width="25%">
	 	
	
		 		{* Member-ID *}
		 		<table border="0">
		 		 <tr>
		 		 	<td><font size=1><i>{$LNG_BASIC.c4250},{$LNG_BASIC.c4251}</font></i> </td>
		 		 </tr>
		 		 <tr>
		 		 	<td> <b>{$members[m]->id}</b></td>
		 		 </tr>
		 		</table>
		 		
	
		 		{* Nick-Name *}
		 		<table border="0">
		 		 <tr>
		 		 	<td><font size="1"><i>{$LNG_BASIC.c4252}</font></i> </td>
		 		 </tr>
		 		 <tr>
		 		 	<td> <A href="{$url_file}page=member.info&member_id={$members[m]->id}"><b>{$members[m]->nick_name|strip_tags|stripslashes}</b></a></td>
		 		 </tr>
		 		</table>
		 		
		 		{* Pre *}
		 		<table border="0">
		 		 <tr>
		 		 	<td><font size=1><i>{$LNG_BASIC.c4255}</font></i> </td>
		 		 </tr>
		 		 <tr>
		 		 	<td> <b>
					 {if $members[m]->public_keys.first_name OR $members[m]->public_keys.first_name }
						{if $members[m]->public_keys.first_name} {$members[m]->first_name|strip_tags} {/if} 
						{if $members[m]->public_keys.next_name} {$members[m]->next_name|strip_tags} {/if} 
					{else}
						<b>{$LNG_BASIC.c1021}</b>
		 			 {/if}
		 		 	</b>
		 		 	</td>
		 		 </tr>
		 		</table>
		 		
	 	
	 	
	 	 </td>
	 	 <td valign="top" width="25%">
	 	 
	
		 		{* Team Nationality *}
		 		<table border="0">
		 		 <tr>
		 		 	<td><font size=1><i>{$LNG_BASIC.c4257}</font></i> </td>
		 		 </tr>
		 		 <tr>
		 		 	{if $members[m]->public_keys.country_id}
			 		 	<td><b>{$members[m]->country_name}</b> <img src="{$path_country}{$members[m]->country_image_file}"></td>
			 		{else}
			 			<td><b>{$LNG_BASIC.c1021}</b></td> {*N/A*}
			 		{/if}
		 		 </tr>
		 		</table>
		 		
		 		
		 		{* Clan name *}
		 		<table border="0">
		 		 <tr>
		 		 	<td><font size=1><i>{$LNG_BASIC.c4260}</i></font></td>
		 		 </tr>
		 		 <tr>
		 		 	{if $members[m]->public_keys.clan_name}
			 		 	<td><b>{$members[m]->clan_name|strip_tags|stripslashes}</b> </td>
			 		{else}
			 			<td><b>{$LNG_BASIC.c1021}</b></td> {*N/A*}
			 		{/if}
		 		 </tr>
		 		</table>

	 	 
	 	 </td>
	 	 <td valign="top" width="25%">
	 	 
		 		{* Joined *}
		 		<table border="0">
		 		 <tr>
		 		 	<td><font size=1><i>{$LNG_BASIC.c4262}</i></font></td>
		 		 </tr>
		 		 <tr>
		 		 	<td> <b>{date timestamp=$members[m]->created format="%d. %b %y"}</b></td>
		 		 </tr>
		 		</table>
		 		
		 				 		
		 		{* Options *}
		 		<table border="0">
		 		 <tr>
		 		 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c4268 link="`$url_file`page=pm.write&member_id=`$members[m]->id`"} </td>
		 		 </tr>	
		 		 <tr>
		 		 	<td>
		 		 	{if !$members[m]->public_keys.email }
		 		 		{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c4267 link="`$url_file`page=email_send&member_id=`$members[m]->id`"}
		 		 	{else}
		 		 		{*include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c4267 link="mailto:`$members[m]->email`"*}
		 		 	{/if}
		 		 	
		 		 	</td>
		 		  </tr>
		 		  <tr>
		 		 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c2500 link="`$url_file`page=member.info&member_id=`$members[m]->id`"} </td>
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
 	<td width="50%"><b>Seite {$curr_page+1} von {$num_pages}</b></td>
 	<td align="right">
		<table>
		<tr>
		{section name=page loop=$num_pages}
		{if $smarty.section.page.index > $curr_page-5  &&  $smarty.section.page.index < $curr_page+5 }
			{if $smarty.section.page.index == $curr_page}
				<td><A href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$members_per_page}"><b><u>{$smarty.section.page.index+1}</u></b></a></td>
			{else}
				<td><A href="{$url_file}page={$url_page}&pos={$smarty.section.page.index*$members_per_page}"><b>{$smarty.section.page.index+1}</b></a></td>
			{/if}
		{/if}
		{/section}
		</tr>
		</table>
	</td>
 </tr>
</table>