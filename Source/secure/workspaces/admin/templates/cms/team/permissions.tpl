<h2>T-Mitglieder `{$team->name|strip_tags|stripslashes}`</h2>
{include file="cms/team/header_menu.tpl"}
<hr size="1"/>
{if $team && $team_members }
{include file="devs/message.tpl"}

	<form name="fpermissions" action="{$url_file}page={$url_page}&team_id={$team_members[0]->team_id}&a=go" method="post">
	<table border="0" width="100%" cellpadding="5" cellspacing="1">
	 <tr bgcolor="{#clr_content_border#}">
	 	<td><b>Nickname</b></td>
	 	<td><b>Rechte</b></td>
	 </tr>
	{section name=team loop=$team_members}
		<tr bgcolor="{#clr_content#}">
			<td width="200"><A href='{$url_file}page=member.info&member_id={$team_members[team]->id}'>{$team_members[team]->nick_name|strip_tags|stripslashes}</td>
			<td> <select style="width:200px;" name="team_permissions_{$smarty.section.team.index}" class="egl_select">
			
					{section name=icp loop=$tpl}
						{if $team_members[team]->permissions == $tpl[icp]->const } 
							<option selected value="{$tpl[icp]->const}">{$tpl[icp]->name}</option>
						{else}
							<option value="{$tpl[icp]->const}">{$tpl[icp]->name}</option>
						{/if}
					{/section}

				</select>
				<input type=hidden name="team_member_{$smarty.section.team.index}" value="{$team_members[team]->member_id}"/>
				</td>
		</tr>
	{/section}
		<tr bgcolor="{#clr_content#}">
			<td colspan="4" align="center">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="abchicken" link="javascript:document.fpermissions.submit();"}</td>
		</tr>
	</table>
	
	</form>	

{/if}