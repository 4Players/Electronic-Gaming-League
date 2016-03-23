	{section name=item loop=$curr_member_list}


		<A href='{$url_file}page=cms.member.central&member_id={$curr_member_list[item]->member_id}'>{$curr_member_list[item]->nick_name|strip_tags}</a>
	 					
	 	{** Komma setzten, falls nötig **}
	 	{if !$smarty.section.item.last}, {/if}
	{/section}

			
			
	{if !sizeof($curr_member_list) }
	<i>KEINE</i>
	{/if}
