<h2>{$LNG_BASIC.c4730}</h2>
{include file="devs/message.tpl"}

{if !$success}
	
	{if $smarty.get.a == "search"}
	
	 <form name="f" action="{$url_file}page={$url_page}&a=go" method="POST">
	 <table border="0" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}" width="300" align="center">
	  <tr bgcolor="{#clr_content_rel#}"><td align="center">
		<table border="0" cellpadding="5" align="center" width="100%">
		 <tr>
			<td width="30%"><b>{$LNG_BASIC.c1013}:</b></td>
			<td><select class="egl_select" style="width:100%;" name="clan_id">
				{section name=clan loop=$clanlist}
					<option value="{$clanlist[clan]->id}">{$clanlist[clan]->name|strip_tags|stripslashes}(ID:{$clanlist[clan]->id})</option>
				{/section}
				{if sizeof($clanlist) == 0}
					<option value="-1">{$LNG_BASIC.c4731}</option> {*NO CLAN FOUND*}
				{/if}
				</select>
			</td>
		 </tr>
		 <tr>
			<td><b>{$LNG_BASIC.c1003}:</b></td>
			<td><input style="width:100%" type=password class="egl_text" name="join_psd"></td>
		 </tr>
		 <tr>
			<td> </td>
			<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR link="javascript:document.f.submit();" caption=$LNG_BASIC.c4732}</td>
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
			<td width="30%"><b>{$LNG_BASIC.c4721}</b></td>
			<td><input style="width:100%" type=text class="egl_text" name="join_name"/></td>
		 </tr>
		 <tr>
			<td width="30%"><b>{$LNG_BASIC.c4726}:</b></td>
			<td><input style="width:100%" type=text class="egl_text" name="join_id"/></td>
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