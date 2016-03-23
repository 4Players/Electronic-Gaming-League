<h2>{$LNG_BASIC.c4850}</h2>
{include file="devs/message.tpl"}

{if $clan_members AND !$success}

	<form name="fpermissions" action="{$url_file}page={$url_page}&clan_id={$clan->id}&a=go" method="post">
	
	<table border="0" width="100%" cellpadding="5" cellspacing="1">
	 <tr bgcolor="{#clr_content_border#}">
	 	<td><b>{$LNG_BASIC.c4854}</b></td>
	 	<td><b>{$LNG_BASIC.c4851}</b></td>
	 	<td align="center"><b>{$LNG_BASIC.c4855}</b></td>
	 </tr >
	{* LISTE Clan-Members auf *}
	{section name=member loop=$clan_members}
		<tr  bgcolor="{#clr_content#}">
			<td><A href="{$url_file}page=member.info&member_id={$clan_members[member]->member_id}">{$clan_members[member]->nick_name|strip_tags|stripslashes}</td>
			<td> <select name="member_permissions_{$smarty.section.member.index}" class="egl_select" style="width:100%">
					{section name=icp loop=$cpl}
						{if $clan_members[member]->permissions == $cpl[icp]->const } 
							<option selected value="{$cpl[icp]->const}">{$cpl[icp]->name}</option>
						{else}
							<option value="{$cpl[icp]->const}"> {$cpl[icp]->name} </option>
						{/if}
					{/section}

				</select>
				{* Speichert member_id daten in versteckter Form => NICHT ÄNDERN !!! *}
				<input type=hidden name="clan_member_{$smarty.section.member.index}" value="{$clan_members[member]->member_id}"/>
				
				</td>
			<td align="center">
				<A title="{lng_parser content=$LNG_BASIC.c4852 rights=$cpl[0]->name}" href='{$url_file}page=clan.set_leader&clan_id={$clan->id}&member_id={$clan_members[member]->member_id}'><b>{$cpl[0]->name}</b></a> &nbsp;|&nbsp;
				<A href='{$url_file}page=clan.kick&clan_id={$clan->id}&member_id={$clan_members[member]->member_id}'><b>{$LNG_BASIC.c4853}</b></a>
			</td>
		</tr>
	{/section}
		<tr bgcolor="{#clr_content#}">
			<td colspan="4" align="center">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.fpermissions.submit();"}</td>
		</tr>
	</table>
	
	</form>	

{/if}