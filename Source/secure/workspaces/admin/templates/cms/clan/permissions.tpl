<h2>C-Zugriffsrechte</h2>
{include file="cms/clan/header_menu.tpl"}
<hr size="1"/>
{include file="etc/message.tpl"}


{if $clan_members AND !$success}

	<form action="{$url_file}page={$url_page}&clan_id={$clan->id}&a=go" method="post">
	
	<table border="0" width="100%" cellpadding="5" cellspacing="1">
	 <tr bgcolor="#E8E5DE">
	 	<td><b>Nickname</b></td>
	 	<td><b>Rechte</b></td>
	 </tr >
	<!--# LISTE Clan-Members auf #-->
	{section name=member loop=$clan_members}
		<tr  bgcolor="{#clr_content#}">
			<td><a href='{$url_file}page=cms.member.central&member_id={$clan_members[member]->member_id}'>{$clan_members[member]->nick_name|strip_tags|stripslashes}</a></td>
			<td> <select style="width:200px;" name="member_permissions_{$smarty.section.member.index}" class="egl_select">
			
					{section name=icp loop=$cpl}
						{if $clan_members[member]->permissions == $cpl[icp]->const } 
							<option  selected value="{$cpl[icp]->const}">{$cpl[icp]->name}</option>
						{else}
							<option value="{$cpl[icp]->const}"> {$cpl[icp]->name} </option>
						{/if}
					{/section}

				</select>
				<!--# Speicher member_id daten in versteckter Form => NICHT ÄNDERN !!! #-->
				<input type=hidden name="clan_member_{$smarty.section.member.index}" value="{$clan_members[member]->member_id}">
				
				</td>
				<!--# <td align="center"> <i> [ <A href='{$url_file}page=clan.kick&clan_id={$clan->id}&member_id={$clan_members[member]->member_id}'><b>kick</b></a> ]</td>*} #-->
		</tr>
	{/section}
		<tr bgcolor="{#clr_content#}">
			<td colspan="4"><input type="image" src="images/buttons/new/bt_send.gif"/></td>
		</tr>
	</table>

  </form>
  
{/if}