	{section name=item loop=$clan_curr_member_list}

		{***DISPLAY LOGOS ? ***}
		{if $clan->display_player_logo}
		
			{*Tabellen Anfang nur einmal schreiben*}
			{if $smarty.section.item.first }
				<table border=0 cellpadding="0" cellspacing="2" width="100%">
			 {/if}
		 				 
			{*Tabelle:Neue Zeile nur alle Nx schreiben*}
			{if $smarty.section.item.index%2==0}<tr>{/if}
		 				 
				 <td valign="top" bgcolor="{#clr_content_rel_border#}" width="50%">
				   <table border=0 cellpadding="0" cellspacing="1" width="100%">
				    <tr bgcolor="{#clr_content_rel#}"><td width="60">
					{if $clan_curr_member_list[item]->photo_file != 'non'}
						<img src='{$path_photos}{$clan_curr_member_list[item]->photo_file}' width='60' height='80'>
		 			{else}
		 				<img src='images/photo.na.jpg' width='60' height='80'>
					{/if}
		 			</td><td valign="top">
		 				<table border=0 width="100%" cellpadding="5" cellspacing="2">
		 				 <tr><td>
	 						<A href='{$url_file}page=member.info&member_id={$clan_curr_member_list[item]->member_id}'> {$clan_curr_member_list[item]->nick_name|strip_tags}</a><br/>
 							
	 						{if $clan_curr_member_list[item]->birthday }
	 							{age date=$clan_curr_member_list[item]->birthday} {$LNG_BASIC.c1213} <br>
	 						{/if}
 							<br>
 							
	 						{section name=country loop=$countries}
	 							{if $countries[country]->id == $clan_curr_member_list[item]->country_id}
	 								<img src="{$path_country}{$countries[country]->image_file}"><i>({$countries[country]->name})</i>
	 							{/if}
	 						{/section}
	 						
 						 </td> </tr>
 						</table>
 						
	 				</td></tr>
	 			   </table>
	 			  </td>
	 				 
	 		{*Tabelle:Ende Zeile nur alle Nx schreiben*}
		 	{if $smarty.section.item.index%2==1}</tr>{/if}
			{if $smarty.section.item.last }</table> {/if}
	 	{else}
			<A href='{$url_file}page=member.info&member_id={$clan_curr_member_list[item]->member_id}'>{$clan_curr_member_list[item]->nick_name|strip_tags}</a>
		{/if}
	 					
	 					
	 	{** Komma setzten, falls nötig **}
	 	{if !$smarty.section.item.last && !$clan->display_player_logo}, {/if}
	{/section}

	{if sizeof($clan_curr_member_list)==0} <i>{$LNG_BASIC.c1212}</i> {/if}
