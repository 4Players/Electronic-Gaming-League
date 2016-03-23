<h2>{$LNG_BASIC.c5270}</h2>
{include file="devs/message.tpl"}

{if !$success}
	<form name="fkick" action="{$url_file}page={$url_page}&team_id={$_get.team_id}&member_id={$_get.member_id}&a=go" method="POST">
		
	<table border="0" cellpadding="5" cellspacing="1" width="60%" bgcolor="{#clr_content_border#}" align="center">
	<tr bgcolor="{#clr_content#}"><td align="center"> 
		<table border="0" align="center" cellpadding="5" width="100%">
	 	<tr>
	  		<td width="50"><b>{$LNG_BASIC.c1014}:</b> </td>
		  	<td><select class="egl_select" name="kick_member_id" style="width:100%;"> 
					<option value="-1">---  {$LNG_BASIC.c1300} ---</option>
		 			{section name=cmember loop=$team_members} 
		  				{if $team_members[cmember]->permissions == $const_leader }
			  					<option disabled value="-1">{$team_members[cmember]->nick_name|strip_tags|stripslashes}</option>
		  				{else}
		  					{if $_get.member_id == $team_members[cmember]->member_id }
			  					<option selected value="{$team_members[cmember]->member_id}">{$team_members[cmember]->nick_name|strip_tags}</option>
		  					{else}
			  					<option value="{$team_members[cmember]->member_id}">{$team_members[cmember]->nick_name|strip_tags|stripslashes}</option>
		  					{/if}
		  				{/if}
		  			{/section}
	 	 		</select>
	 	 		</td>
	 	</tr>
	 	<tr>
	 	 	<td><b>{$LNG_BASIC.c1208}:</b></td>
	 	 	<td><input type="checkbox" name="kick_check" value="yes"/></td>
	 	</tr>
	 	<tr>
	 	 	<td></td>
	 	 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.fkick.submit();"}</td>
	 	</tr>
		</table>
	</td></tr>
	</table>
	</form>
{/if}