<h2>Veranstalter `{$organiser->name}`</h2>


 		{*  DESCRIPTION:
 			-----------------
 			$clan_members has been sorted to $clan_members[0...cpl][0..clan_member] (cpl=clan permission-list)
 			
 			*}
 			
 			
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
			</table>	
			<table border="0" width="100%" cellpadding="5" cellspacing="1" >
			{section name=cp loop=$organiser_members}
			
				{assign var="curr_member_list" value=$organiser_members[cp] }
			
				{*if sizeof($curr_member_list) > 0 *}
 			 <tr>
 				<td bgcolor="{#clr_content_border#}" width="20%" valign="top"><b>{$tpl[cp]->name}</b>:</td>	
 				<td bgcolor="{#clr_content#}" > {include file="etc/organiser.list_detailed_permissions.tpl"}	</td>	
 			 </tr>
 				{*/if*}
	 		{/section}
 			</table>
 			
 			
 			