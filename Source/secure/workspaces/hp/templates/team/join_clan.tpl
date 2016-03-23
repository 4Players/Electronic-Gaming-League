<h2>{$LNG_BASIC.c5250}</h2>
{include file="devs/message.tpl"}

{if $team->clan_id == $smarty.const.EGL_NO_ID}
	
	{if !$success}
	
		{if $smarty.get.a == "search"}
		
		 <form name="f" action="{$url_file}page={$url_page}&team_id={$team->id}&a=go" method="POST">
		 <table border="0" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}" width="400" align="center">
		  <tr bgcolor="{#clr_content_rel#}"><td align="center">
			<table border="0" cellpadding="5" align="center" width="100%">
			 <tr>
				<td width="30%"><b>{$LNG_BASIC.c1013}:</b></td>
				<td><select class="egl_select" style="width:100%;" name="clan_id">
					{section name=clan loop=$clanlist}
						<option value="{$clanlist[clan]->id}">{$clanlist[clan]->name|strip_tags|stripslashes}(ID:{$clanlist[clan]->id})</option>
					{/section}
					{if sizeof($clanlist) == 0}
						<option value="-1">{$LNG_BASIC.c4731}</option>
					{/if}
					</select>
				</td>
			 </tr>
			 <tr>
				<td><b>{$LNG_BASIC.c1003}:</b></td>
				<td><input style="width:100%" type=password class="egl_text" name="join_psd"/></td>
			 </tr>
			 <tr>
				<td></td>
				<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR link="javascript:document.f.submit();" caption=$LNG_BASIC.c1214 }</td>
			 </tr>
			</table>
		 </td></tr>
		</table>
		 </form>
			
		{else}
		
		<form name="f" action="{$url_file}page={$url_page}&team_id={$team->id}&a=search" method="POST">
			<table botder="0" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}" width="400" align="center">
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>{$LNG_BASIC.c1010}:</b></td>
			 	<td><A href="{$url_file}page=team.info&team_id={$team->id}">{$team->name|strip_tags|stripslashes}</a></td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>{$LNG_BASIC.c4721}:</b></td>
			 	<td><input type="text" class="egl_text" style="width:100%" name="join_name" value=""/></td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>{$LNG_BASIC.c4726}:</b></td>
			 	<td><input type="text" class="egl_text" style="width:100%" name="join_id" value=""/></td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td></td>
			 	<td>{include file="buttons/bt_universal.tpl" caption=$LNG_BASIC.c1215 color=$GLOBAL_COLOR link="javascript:document.f.submit();"}</td>
			 </tr>
			 </table>
		 </form>
		 
		 {/if}
		 
	 {/if}
	 
 {/if}