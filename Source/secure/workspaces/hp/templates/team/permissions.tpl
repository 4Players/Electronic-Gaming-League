<h2>{$LNG_BASIC.c5400}</h2>
{include file="devs/message.tpl"}

{if $team_members AND !$success}

	<form name="fpermissions" action="{$url_file}page={$url_page}&team_id={$team_members[0]->team_id}&a=go" method="post">
	<table border="0" width="100%" cellpadding="5" cellspacing="1">
	 <tr bgcolor="{#clr_content_border#}">
	 	<td><b>{$LNG_BASIC.c4831}</b></td>
	 	<td><b>{$LNG_BASIC.c5401}</b></td>
	 	<td width="200"></td>
	 </tr>
	{section name=team loop=$team_members}
		<tr bgcolor="{#clr_content#}">
			<td width="200"><A href='{$url_file}page=member.info&member_id={$team_members[team]->id}'>{$team_members[team]->nick_name|strip_tags|stripslashes}</td>
			<td> <select style="width:100%;" name="team_permissions_{$smarty.section.team.index}" class="egl_select">
			
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
			<td width="100" align="center">
				<A title="{lng_parser content=$LNG_BASIC.c4852 rights=$cpl[0]->name}" href="{$url_file}page=team.setleader&team_id={$team_members[team]->team_id}&member_id={$team_members[team]->member_id}"><b> {$tpl[0]->name}</b></a> &nbsp;|&nbsp;
				<A href='{$url_file}page=team.kick&team_id={$team_members[team]->team_id}&member_id={$team_members[team]->member_id}'><b>{$LNG_BASIC.c4853}</b></a>
			</td>
		</tr>
	{/section}
		<tr bgcolor="{#clr_content#}">
			<td colspan="4" align="center">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.fpermissions.submit();"}</td>
		</tr>
	</table>
	
	</form>	

{/if}