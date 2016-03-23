<h2>{$LNG_BASIC.c4720}</h2>
{include file="devs/message.tpl"}
	{if !$success }
	 <form name="f" action="{$url_file}page={$url_page}&a=go" method="POST">
	 <table cellpadding="5" cellspacing="1" border="0" align="center" width="300" bgcolor="{#clr_content_border#}">
	  <tr bgcolor="{#clr_content#}"><td>
	  
		<table border="0" cellpadding="5" align="center" width="100%">
		 <tr>
		 	<td width="20%"><b>{$LNG_BASIC.c4721}:</b> </td>
		 	<td><input style="width:100%" type=text class="egl_text" name="clan_name"></td>
		 </tr>
		 <tr>
		 	<td><b>{$LNG_BASIC.c4722}:</b></td>
		 	<td><input style="width:100%" type=text class="egl_text" name="clan_tag"></td>
		 </tr>
		 <tr>
		 	<td><b>{$LNG_BASIC.c4723}: </b></td>
		 	<td><input style="width:100%" type=text class="egl_text" name="clan_hp" value="http://"></td>
		 </tr>
		 <tr>
		 	<td></td>
		 	<td>{include file="buttons/bt_universal.tpl" caption=$LNG_BASIC.c1018 link="javascript:document.f.submit();" color=$GLOBAL_COLOR}</td>
		 </tr>
		</table>
		
	 </td></tr>
	 </table>
	 
	 </form>
{/if}