<h2>{$LNG_BASIC.c4634}</h2>
{include file="devs/message.tpl"}
{if !$success}

	<form name="finvite" action="{$url_file}page={$url_page}&clan_id={$_get.clan_id}&a=go" method="POST">
	
		<table border="0" cellpadding="5" cellspacing="1" width="100%" align="center" bgcolor="{#clr_content_border#}">
		 <tr bgcolor="{#clr_content#}">
		 	<td width="20%"><b>{$LNG_BASIC.c1022}:</b></td>
		 	<td><input style="width:200;" type="text" class="egl_text" name="invite_id" value="{$_post->invite_id}"></td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>{$LNG_BASIC.c1020}:</b></td>
		 	<td><input style="width:200" type="text" class="egl_text" name="invite_nickname" value="{$_post->invite_nickname}"></td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td valign="top"><b>{$LNG_BASIC.c1027}:</b></td>
		 	<td><textarea style="width:100%" name="invite_text" class="egl_textbox" rows="10">{$_post->invite_text}</textarea></td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td></td> 
		 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.finvite.submit();"}</td> 
		 </tr>
		</table>
		
	</form>
{/if}