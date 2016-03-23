<h2>{$LNG_BASIC.c5120}</h2>
{include file="devs/message.tpl"}

{if !$success}
	
	{if $smarty.get.a == "search"}
	
	 <form name="f" action="{$url_file}page={$url_page}&a=go" method="POST">
	 <table border="0" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}" width="300" align="center">
	  <tr bgcolor="{#clr_content_rel#}"><td align="center">
		<table border="0" cellpadding="5" align="center" width="100%">
		 <tr>
			<td width="30%"><b>{$LNG_BASIC.c1011}:</b></td>
			<td><select class="egl_select" style="width:100%;" name="team_id">
				{section name=team loop=$teamlist}
					<option value="{$teamlist[team]->id}">{$teamlist[team]->name|strip_tags|stripslashes}(ID:{$teamlist[team]->id})</option>
				{/section}
				{if sizeof($teamlist) == 0}
					<option value="-1">{$LNG_BASIC.c5121}</option>
				{/if}
				</select>
			</td>
		 </tr>
		 <tr>
			<td><b>Passwort:</b></td>
			<td><input style="width:100%" type=password class="egl_text" name="join_psd"></td>
		 </tr>
		 <tr>
			<td> </td>
			<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR link="javascript:document.f.submit();" caption=$LNG_BASIC.c1214}</td>
		 </tr>
		</table>
	 </td></tr>
	</table>
	 </form>
		
	{else}
	 <form name="f" action="{$url_file}page={$url_page}&a=search" method="POST">
	 <table border="0" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}" width="300" align="center">
	  <tr bgcolor="{#clr_content_rel#}"><td align="center">
		<table border="0" cellpadding="5" align="center" width="100%">
		 <tr>
			<td width="30%"><b> {$LNG_BASIC.c4831}:</b></td>
			<td><input style="width:100%" type=text class="egl_text" name="join_name"></td>
		 </tr>
		 <tr>
			<td width="30%"><b>{$LNG_BASIC.c4835}:</b></td>
			<td><input style="width:100%" type=text class="egl_text" name="join_id"></td>
		 </tr>
		 <tr>
			<td> </td>
			<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR link="javascript:document.f.submit();" caption=$LNG_BASIC.c1018}</td>
		 </tr>
		</table>
	 </td></tr>
	</table>
	 </form>
	{/if}
{/if}
