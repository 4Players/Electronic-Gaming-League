<h2>T-Zentrale `{$team->name|strip_tags|stripslashes}`</h2>
{include file="cms/team/header_menu.tpl"}
<hr size="1"/>


<table width="100%" border="0" cellpadding="0" cellspacing="10">
 <tr>
 	<td width="50%" valign="top">
 	
		{* DESCRIPTION:
		-----------------
		$clan_members has been sorted to $clan_members[0...cpl][0..clan_member] (cpl=clan permission-list)
		*}
		<table border="0" width="100%" cellpadding="5" cellspacing="1">
 			 <tr bgcolor="{#clr_content_border#}">
 			 	<td colspan="2"><b>Team-Struktur</b></td>
 			 </tr>
		{section name=cp loop=$team_members}
			{assign var="curr_member_list" value=$team_members[cp] }
 			 <tr>
 				<td align="left" bgcolor="{#clr_content#}" width="20%" valign="top"><b>{$tpl[cp]->name}</b>:</td>	
 				<td bgcolor="{#clr_content#}" > {include file="etc/team.list_detailed_permissions.tpl"}	</td>	
 			 </tr>
 		{/section}
		</table>
 	</td>
 	<td valign="top">
 		&nbsp;
 	
 	</td>
 </tr>
</table> 			